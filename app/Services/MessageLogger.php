<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MessageLogger
{
    public function logMessage($orderId, $senderId, $receiverId, $message)
    {
        $logData = [
            'order_id' => $orderId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('chat')->info('Chat Message', $logData);
    }
} 