<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\User;
use App\Models\Wedding;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentService
{
    /**
     * Get the current agent for the authenticated user
     */
    public function getCurrentAgent(): ?Agent
    {
        $user = Auth::user();
        return Agent::where('user_id', $user->id)->first();
    }

    /**
     * Get dashboard statistics for an agent
     */
    public function getDashboardStats(Agent $agent): array
    {
        return [
            'total_customers' => User::where('agent_id', $agent->id)->count(),
            'total_weddings' => Wedding::where('agent_id', $agent->id)->count(),
            'quota_used' => $agent->quota_used,
            'quota_remaining' => $agent->getRemainingQuota(),
            'subscription_plan' => $agent->getSubscriptionPlanLabel(),
            'is_trial' => $agent->isOnTrial(),
            'trial_ends_at' => $agent->trial_ends_at,
            'subscription_ends_at' => $agent->subscription_ends_at,
        ];
    }

    /**
     * Get recent weddings for an agent
     */
    public function getRecentWeddings(Agent $agent, int $limit = 5)
    {
        return Wedding::where('agent_id', $agent->id)
            ->with('user')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get recent customers for an agent
     */
    public function getRecentCustomers(Agent $agent, int $limit = 5)
    {
        return User::where('agent_id', $agent->id)
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get paginated customers with search
     */
    public function getCustomers(Agent $agent, array $filters = [], int $perPage = 15)
    {
        $query = User::where('agent_id', $agent->id)->with('weddings');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get paginated weddings with search and filtering
     */
    public function getWeddings(Agent $agent, array $filters = [], int $perPage = 15)
    {
        $query = Wedding::where('agent_id', $agent->id)->with(['user', 'template']);

        // Search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('groom_name', 'like', "%{$search}%")
                  ->orWhere('bride_name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Update agent settings
     */
    public function updateSettings(Agent $agent, array $data): bool
    {
        return $agent->update($data);
    }

    /**
     * Create a new customer for an agent
     */
    public function createCustomer(Agent $agent, array $data): User
    {
        return DB::transaction(function () use ($agent, $data) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => bcrypt($data['password']),
                'agent_id' => $agent->id,
                'role' => 'customer',
            ]);
        });
    }
}
