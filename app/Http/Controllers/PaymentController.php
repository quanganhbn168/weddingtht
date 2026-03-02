<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Subscription;
use App\Services\MoMoPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected MoMoPaymentService $momoService;
    
    // Pricing in VND
    const PLANS = [
        'pro' => [
            'name' => 'Pro',
            'price' => 199000, // 199,000 VND/month
            'duration_months' => 1,
        ],
        'pro_yearly' => [
            'name' => 'Pro (Năm)',
            'price' => 1990000, // 1,990,000 VND/year (~17% discount)
            'duration_months' => 12,
        ],
    ];
    
    public function __construct(MoMoPaymentService $momoService)
    {
        $this->momoService = $momoService;
    }
    
    /**
     * Initiate payment for a plan upgrade
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:pro,pro_yearly',
        ]);
        
        $user = $request->user();
        $planKey = $request->input('plan');
        $plan = self::PLANS[$planKey];
        
        // Generate unique order ID
        $orderId = 'PRO_' . $user->id . '_' . time();
        
        // Create payment transaction record
        $transaction = PaymentTransaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'gateway' => 'momo',
            'plan' => $planKey,
            'amount' => $plan['price'],
            'status' => PaymentTransaction::STATUS_PENDING,
        ]);
        
        // Create MoMo payment
        $returnUrl = route('payment.callback');
        $notifyUrl = route('payment.ipn');
        
        $result = $this->momoService->createPayment(
            orderId: $orderId,
            amount: $plan['price'],
            orderInfo: "Nâng cấp gói {$plan['name']} - E-Wedding SaaS",
            returnUrl: $returnUrl,
            notifyUrl: $notifyUrl,
            requestType: 'captureWallet' // MoMo QR / wallet
        );
        
        if ($this->momoService->isPaymentSuccessful($result) && isset($result['payUrl'])) {
            // Save request ID
            $transaction->update(['request_id' => $result['requestId'] ?? null]);
            
            // Redirect to MoMo payment page
            return redirect()->away($result['payUrl']);
        }
        
        // Payment creation failed
        $transaction->markAsFailed($result);
        
        return redirect()->route('dashboard.pricing')
            ->with('error', 'Không thể tạo thanh toán MoMo. Vui lòng thử lại sau. Lỗi: ' . ($result['message'] ?? 'Unknown'));
    }
    
    /**
     * Handle MoMo redirect callback (user returns from MoMo)
     */
    public function callback(Request $request)
    {
        $orderId = $request->input('orderId');
        $resultCode = $request->input('resultCode');
        
        $transaction = PaymentTransaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return redirect()->route('dashboard.pricing')
                ->with('error', 'Không tìm thấy giao dịch.');
        }
        
        // Check if already processed by IPN
        if ($transaction->status === PaymentTransaction::STATUS_SUCCESS) {
            return redirect()->route('dashboard')
                ->with('success', 'Thanh toán thành công! Gói Pro đã được kích hoạt.');
        }
        
        if ($resultCode == 0) {
            // Payment successful - but wait for IPN to confirm
            return redirect()->route('dashboard')
                ->with('success', 'Thanh toán thành công! Gói Pro sẽ được kích hoạt trong giây lát.');
        }
        
        // Payment failed or cancelled
        return redirect()->route('dashboard.pricing')
            ->with('error', 'Thanh toán không thành công hoặc đã bị hủy.');
    }
    
    /**
     * Handle MoMo IPN (Instant Payment Notification)
     */
    public function ipn(Request $request)
    {
        $data = $request->all();
        
        Log::info('MoMo IPN Received', $data);
        
        // Verify signature
        if (!$this->momoService->verifyCallback($data)) {
            Log::warning('MoMo IPN Invalid Signature', $data);
            return response()->json(['message' => 'Invalid signature'], 400);
        }
        
        $orderId = $data['orderId'];
        $resultCode = (int) $data['resultCode'];
        
        $transaction = PaymentTransaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            Log::warning('MoMo IPN Transaction Not Found', ['orderId' => $orderId]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        
        // Already processed
        if ($transaction->status !== PaymentTransaction::STATUS_PENDING) {
            return response()->json(['message' => 'Already processed']);
        }
        
        if ($resultCode === 0) {
            // Payment successful
            $transaction->markAsSuccessful(
                transId: $data['transId'] ?? null,
                payType: $data['payType'] ?? null,
                responseData: $data
            );
            
            // Activate subscription
            $this->activateSubscription($transaction);
            
            Log::info('MoMo Payment Successful', ['orderId' => $orderId, 'transId' => $data['transId'] ?? null]);
        } else {
            // Payment failed
            $transaction->markAsFailed($data);
            Log::info('MoMo Payment Failed', ['orderId' => $orderId, 'resultCode' => $resultCode]);
        }
        
        return response()->json(['message' => 'IPN processed']);
    }
    
    /**
     * Activate user subscription after successful payment
     */
    protected function activateSubscription(PaymentTransaction $transaction): void
    {
        $user = $transaction->user;
        $planKey = $transaction->plan;
        $plan = self::PLANS[$planKey] ?? self::PLANS['pro'];
        
        // Calculate expiration
        $expiresAt = now()->addMonths($plan['duration_months']);
        
        // Create or update subscription
        $user->subscription()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan' => Subscription::PLAN_PRO,
                'status' => Subscription::STATUS_ACTIVE,
                'started_at' => now(),
                'expires_at' => $expiresAt,
                'payment_method' => 'momo',
                'transaction_id' => $transaction->trans_id,
            ]
        );
        
        Log::info('Subscription Activated', [
            'user_id' => $user->id,
            'plan' => 'pro',
            'expires_at' => $expiresAt,
        ]);
    }
    
    /**
     * Show payment history
     */
    public function history(Request $request)
    {
        $transactions = $request->user()
            ->paymentTransactions()
            ->latest()
            ->paginate(10);
        
        return view('dashboard.payments.history', compact('transactions'));
    }
}
