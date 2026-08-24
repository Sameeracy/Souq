<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripePaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_stripe_webhook_marks_order_as_processing(): void
    {
        // 1. Create a user and an initial pending order
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $product = Product::create([
            'seller_id' => $seller->id,
            'title' => 'Test Artisan Rug',
            'description' => 'A beautiful rug',
            'price' => 5000.00,
        ]);

        $order = Order::create([
            'user_id' => $buyer->id,
            'delivery_address' => 'House 1, Street 2, Islamabad',
            'contact_details' => '03001234567',
            'total_amount' => 5000.00,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'seller_id' => $seller->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 5000.00,
            'status' => 'pending',
        ]);

        // 2. Mock payload sent by Stripe Webhook for checkout.session.completed
        $payload = [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_sample_session_123',
                    'client_reference_id' => (string) $order->id,
                    'payment_status' => 'paid',
                ],
            ],
        ];

        // 3. Post webhook request
        $response = $this->postJson(route('stripe.webhook'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        // 4. Verify order was marked processing and paid
        $order->refresh();
        $this->assertEquals('processing', $order->status);
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('cs_test_sample_session_123', $order->stripe_session_id);
    }
}
