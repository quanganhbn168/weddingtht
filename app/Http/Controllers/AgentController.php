<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agent;
use App\Models\Wedding;
use App\Models\User;

class AgentController extends Controller
{
    /**
     * Get the current agent for the authenticated user
     */
    protected function getAgent()
    {
        $user = Auth::user();
        return Agent::where('user_id', $user->id)->first();
    }

    /**
     * Agent Dashboard - Overview
     */
    public function dashboard()
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        // Stats
        $stats = [
            'total_customers' => User::where('agent_id', $agent->id)->count(),
            'total_weddings' => Wedding::where('agent_id', $agent->id)->count(),
            'quota_used' => $agent->quota_used,
            'quota_remaining' => $agent->getRemainingQuota(),
            'subscription_plan' => $agent->getSubscriptionPlanLabel(),
            'is_trial' => $agent->isOnTrial(),
            'trial_ends_at' => $agent->trial_ends_at,
            'subscription_ends_at' => $agent->subscription_ends_at,
        ];

        // Recent weddings
        $recentWeddings = Wedding::where('agent_id', $agent->id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent customers
        $recentCustomers = User::where('agent_id', $agent->id)
            ->latest()
            ->take(5)
            ->get();

        return view('agent.dashboard', compact('agent', 'stats', 'recentWeddings', 'recentCustomers'));
    }

    /**
     * Customer Management
     */
    public function customers(Request $request)
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $query = User::where('agent_id', $agent->id)->with('weddings');

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        $customers = $query->latest()->paginate(15);

        return view('agent.customers', compact('agent', 'customers'));
    }

    /**
     * Wedding Management for Agent
     */
    public function weddings(Request $request)
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $query = Wedding::where('agent_id', $agent->id)->with(['user', 'template']);

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('groom_name', 'like', "%{$request->search}%")
                  ->orWhere('bride_name', 'like', "%{$request->search}%")
                  ->orWhere('slug', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $weddings = $query->latest()->paginate(15);

        return view('agent.weddings', compact('agent', 'weddings'));
    }

    /**
     * Agent Settings / Profile
     */
    public function settings()
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        return view('agent.settings', compact('agent'));
    }

    /**
     * Update Agent Settings
     */
    public function updateSettings(Request $request)
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $agent->update($validated);

        return redirect()->route('agent.settings')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Create Customer Account
     */
    public function createCustomer(Request $request)
    {
        $agent = $this->getAgent();
        
        if (!$agent) {
            return back()->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $customer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => bcrypt($validated['password']),
            'agent_id' => $agent->id,
            'role' => 'customer',
        ]);

        return redirect()->route('agent.customers')->with('success', 'Đã tạo tài khoản khách hàng: ' . $customer->email);
    }
}
