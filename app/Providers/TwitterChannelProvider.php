<?php

namespace App\Providers;

use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Log;
use Exception;

class TwitterChannelProvider
{
    public function sendMessage($message, $channelId)
    {
        if (empty($channelId)) {
            throw new \BadMethodCallException('channelId required');
        }

        try {
            $subscribers = Twitter::getListsSubscribers(['list_id' => $channelId]);

            foreach ($subscribers as $subscriber) {
                Twitter::postDm([
                    'event' => [
                        'type' => 'message_create',
                        'message_create' => [
                            'target' => [
                                'recipient_id' => $subscriber
                            ],
                            'message_data' => $message
                            
                        ]
                    ]
                ]);
            }

            return response()->json(['success' => true]);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function subscribeToList($listId, $ownerId)
    {
        try {
            Twitter::postListSubscriber(['list_id' => $listId, 'owner_id' => $ownerId]);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error subscribing user ' . $ownerId . ' to chat ' . $listId . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
