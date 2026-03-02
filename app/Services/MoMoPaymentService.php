<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoMoPaymentService
{
    private string $partnerCode;
    private string $accessKey;
    private string $secretKey;
    private string $endpoint;
    
    public function __construct()
    {
        $this->partnerCode = config('services.momo.partner_code', '');
        $this->accessKey = config('services.momo.access_key', '');
        $this->secretKey = config('services.momo.secret_key', '');
        
        // Use sandbox or production endpoint
        $this->endpoint = config('services.momo.sandbox', true)
            ? 'https://test-payment.momo.vn/v2/gateway/api'
            : 'https://payment.momo.vn/v2/gateway/api';
    }
    
    /**
     * Create a MoMo payment request
     *
     * @param string $orderId Unique order ID
     * @param int $amount Amount in VND
     * @param string $orderInfo Order description
     * @param string $returnUrl URL to redirect after payment
     * @param string $notifyUrl IPN callback URL
     * @param string $requestType Payment type: captureWallet, payWithATM, payWithCC
     * @return array
     */
    public function createPayment(
        string $orderId,
        int $amount,
        string $orderInfo,
        string $returnUrl,
        string $notifyUrl,
        string $requestType = 'captureWallet'
    ): array {
        $requestId = $orderId . '_' . time();
        $extraData = '';
        
        // Build raw signature string
        $rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$notifyUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$this->partnerCode}&redirectUrl={$returnUrl}&requestId={$requestId}&requestType={$requestType}";
        
        // Create HMAC SHA256 signature
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
        
        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => config('app.name', 'E-Wedding'),
            'storeId' => $this->partnerCode,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];
        
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->endpoint}/create", $data);
            
            $result = $response->json();
            
            Log::info('MoMo Payment Request', [
                'orderId' => $orderId,
                'amount' => $amount,
                'response' => $result,
            ]);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('MoMo Payment Error', [
                'orderId' => $orderId,
                'error' => $e->getMessage(),
            ]);
            
            return [
                'resultCode' => -1,
                'message' => $e->getMessage(),
            ];
        }
    }
    
    /**
     * Verify MoMo IPN callback
     *
     * @param array $data Callback data from MoMo
     * @return bool
     */
    public function verifyCallback(array $data): bool
    {
        if (!isset($data['signature'])) {
            return false;
        }
        
        $receivedSignature = $data['signature'];
        
        // Rebuild signature from callback data
        $rawHash = "accessKey={$this->accessKey}&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
        
        return $signature === $receivedSignature;
    }
    
    /**
     * Check if payment was successful
     *
     * @param array $data Callback or response data
     * @return bool
     */
    public function isPaymentSuccessful(array $data): bool
    {
        return isset($data['resultCode']) && (int) $data['resultCode'] === 0;
    }
    
    /**
     * Query transaction status
     *
     * @param string $orderId Order ID to check
     * @param string $requestId Original request ID
     * @return array
     */
    public function queryTransaction(string $orderId, string $requestId): array
    {
        $rawHash = "accessKey={$this->accessKey}&orderId={$orderId}&partnerCode={$this->partnerCode}&requestId={$requestId}";
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
        
        $data = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'lang' => 'vi',
            'signature' => $signature,
        ];
        
        try {
            $response = Http::timeout(30)
                ->post("{$this->endpoint}/query", $data);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('MoMo Query Error', [
                'orderId' => $orderId,
                'error' => $e->getMessage(),
            ]);
            
            return [
                'resultCode' => -1,
                'message' => $e->getMessage(),
            ];
        }
    }
}
