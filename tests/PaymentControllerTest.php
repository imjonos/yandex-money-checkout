<?php
namespace CodersStudio\YandexMoneyCheckout\Tests;

use App\User;
use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use CodersStudio\YandexMoneyCheckout\Facades\YandexMoneyCheckout;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

class PaymentControllerTest extends BaseTestCase
{
    use RefreshDatabase, CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Store feature test.
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::first();
        $data = [
            'amount' => 2,
            'description' => 'Test order 1',
            'order_id' => 1,
            'phone' => '79881234567',
            'items' => [
                [
                    'description' => 'item 1',
                    'quantity' => 2,
                    'amount' => 123,
                    'vat_code' => 1
                ]
            ],
        ];
        $response = $this->actingAs($user)->ajax('post', route('yandexmoneycheckout.payments.store'), $data);
        $response->assertStatus(201);
    }

    /**
     * Ajax request testing
     * @param $method
     * @param $route
     * @param array $parameters
     * @return TestResponse
     */
    protected function ajax(string $method, string $route, array $parameters = []):TestResponse
    {
        return $this->json(
            $method, $route, $parameters, ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
    }


}
