@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('codersstudio/yandex-money-checkout::yandex-money-checkout.payment') }}</div>

                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        {{ trans('codersstudio/yandex-money-checkout::yandex-money-checkout.failed') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
