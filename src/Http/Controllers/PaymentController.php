<?php

namespace CodersStudio\YandexMoneyCheckout\Http\Controllers;

use CodersStudio\YandexMoneyCheckout\Facades\YandexMoneyCheckout;
use CodersStudio\YandexMoneyCheckout\Http\Requests\StoreRequest;
use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyCard;
use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyPayment;
use CodersStudio\YandexMoneyCheckout\Models\YandexMoneyStatus;
use Illuminate\Http\Request;
use YandexCheckout\Client;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Create the payment
     *
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $items = [];

        foreach ($data['items'] AS $item) {
            $value = $item;
            $value['amount'] = [
                'value' => $item['amount'],
                'currency' => config('yandex-money-checkout.currency')
            ];
            $items[] = $value;
        }


        $paymentData = [
            'amount' => [
                'value' => $data['amount'],
                'currency' => config('yandex-money-checkout.currency')
            ],
            'payment_method_data' => [
                'type' => config('yandex-money-checkout.payment_method_type')
            ],
            'receipt' => [
                'customer' => [
                    'phone' => $data['phone']
                ],
                'items' => $items
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('yandexmoneycheckout.payments.redirect', ['order' => $data['order_id']])
            ],
            'capture' => config('yandex-money-checkout.capture'),
            'save_payment_method' => config('yandex-money-checkout.save_payment_method'),
            'description' => $data['description'],
            'metadata' => [
                'order_id' => $data['order_id']
            ]
        ];

        $response = YandexMoneyCheckout::create($paymentData);

        if(!$response) abort(400);

        //get confirmation url
        $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();

        if(request()->ajax()) {
            return response()->json([
                'confirmation_url' => $confirmationUrl
            ], 201);
        }

        return  response()->redirectTo($confirmationUrl);
    }


    /**
     * Webhook for yandex requests
     * Documentation https://kassa.yandex.ru/developers/api#webhook
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        $data = $request->get('object', null);
        if($data){
            $paymentMethod =  $data["payment_method"];
            $payment = YandexMoneyPayment::where('payment_id', $data['id'])->firstOrFail();
            $status = YandexMoneyStatus::where('name', $data['status'])->firstOrFail();
            $payment->update(['yandex_money_status_id' => $status->id]);
            if($paymentMethod['type'] === 'bank_card'){
                $card = $paymentMethod['card'];
                YandexMoneyCard::updateOrCreate([
                    "first6" => $card['first6'],
                    "last4" => $card['last4'],
                    "card_type" => $card['card_type'],
                    "yandex_money_payment_id" => $payment->id
                ]);
            }
        }
        return response()->json([], 200);
    }

    /**
     * Return URL
     * Check the status of the payment after user confirmation
     *
     * @param Request $request
     * @param int $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, int $order)
    {
        $payment = YandexMoneyPayment::where('order_id', $order)->orderBy('id', 'DESC')->firstOrFail();
        $failedRoute = config('yandex-money-checkout.failed_route');
        $successRoute = config('yandex-money-checkout.success_route');
        $redirectRoute = ($payment->status->name === 'waiting_for_capture')?$successRoute:$failedRoute;
        return response()->redirectToRoute($redirectRoute, ['order' => $order]);
    }

    /**
     * Success default page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('codersstudio/yandex-money-checkout::payments.success');
    }


    /**
     * Failed default page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function failed()
    {
        return view('codersstudio/yandex-money-checkout::payments.failed');
    }
}
