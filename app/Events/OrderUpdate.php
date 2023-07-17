<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use App\Repository\OrderRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(OrderRepository::ORDER_CHANNEL_NAME),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.update';
    }

    public function broadcastWith(): array
    {
        $orders = OrderRepository::getOrdersByUser($this->user);
        return [
            'orders' => $orders,
        ];
    }

}
