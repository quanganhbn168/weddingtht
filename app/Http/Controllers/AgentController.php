<?php

namespace App\Http\Controllers;

use App\Services\AgentService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }

    /**
     * Agent Dashboard - Overview
     */
    public function dashboard()
    {
        $agent = $this->agentService->getCurrentAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $stats = $this->agentService->getDashboardStats($agent);
        $recentWeddings = $this->agentService->getRecentWeddings($agent);
        $recentCustomers = $this->agentService->getRecentCustomers($agent);

        return view('agent.dashboard', compact('agent', 'stats', 'recentWeddings', 'recentCustomers'));
    }

    /**
     * Customer Management
     */
    public function customers(Request $request)
    {
        $agent = $this->agentService->getCurrentAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $customers = $this->agentService->getCustomers($agent, $request->all());

        return view('agent.customers', compact('agent', 'customers'));
    }

    /**
     * Wedding Management for Agent
     */
    public function weddings(Request $request)
    {
        $agent = $this->agentService->getCurrentAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $weddings = $this->agentService->getWeddings($agent, $request->all());

        return view('agent.weddings', compact('agent', 'weddings'));
    }

    /**
     * Agent Settings / Profile
     */
    public function settings()
    {
        $agent = $this->agentService->getCurrentAgent();
        
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
        $agent = $this->agentService->getCurrentAgent();
        
        if (!$agent) {
            return redirect()->route('dashboard')->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $this->agentService->updateSettings($agent, $validated);

        return redirect()->route('agent.settings')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Create Customer Account
     */
    public function createCustomer(Request $request)
    {
        $agent = $this->agentService->getCurrentAgent();
        
        if (!$agent) {
            return back()->with('error', 'Bạn chưa được cấp quyền đại lý.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $customer = $this->agentService->createCustomer($agent, $validated);

        return redirect()->route('agent.customers')->with('success', 'Đã tạo tài khoản khách hàng: ' . $customer->email);
    }
}
