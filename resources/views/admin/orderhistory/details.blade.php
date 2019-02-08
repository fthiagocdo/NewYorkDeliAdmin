@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">Order Details</h3>
        <h5 class="center-align hide-on-med-and-up">Order Details</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 55%;">Itens</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 15%;">Price</th>
                    <th style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody style="border-bottom: 1px solid #d0d0d0">
            @foreach($checkoutItems as $checkoutItem)
                <tr>
                    <td>
                        <ul style="margin: 0px;">
                            <p style="margin: 0px;"><b>{{ $checkoutItem->menuItem->name }}</b></p>
                            <li><b>Type: </b>{{ $checkoutItem->menuItem->type->name }}</li>
                            @if($checkoutItem->checkoutItemExtras->count() > 0)
                            <li><b>Extras: </b></li>
                            @endif
                            @foreach($checkoutItem->checkoutItemExtras as $checkoutItemExtra)
                            <li style="margin-left: 15px;">{{ $checkoutItemExtra->menuExtra->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td><span style="padding: 10px;">x{{ $checkoutItem->quantity }}</span></td>
                    <td>£ {{ number_format($checkoutItem->unitary_price, 2, '.', ',') }}</td>
                    <td>£ {{ number_format($checkoutItem->total_price, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row hide-on-med-and-up">
        @foreach($checkoutItems as $checkoutItem)
        <div class="card card-table" style="font-family: BarterExchange-Regular;">
            <div class="card-content" style="min-height: 80px;">
                <ul style="margin: 0px;">
                    <p style="margin: 0px;"><b>{{ $checkoutItem->menuItem->name }}</b></p>
                    <li><b>Type: </b>{{ $checkoutItem->menuItem->type->name }}</li>
                    @if($checkoutItem->checkoutItemExtras->count() > 0)
                    <li><b>Extras: </b></li>
                    @endif
                    @foreach($checkoutItem->checkoutItemExtras as $checkoutItemExtra)
                    <li style="margin-left: 15px;">{{ $checkoutItemExtra->menuExtra->name }}</li>
                    @endforeach
                    <li><b>Quantity: </b><span class="right">x{{ $checkoutItem->quantity }}</span></li>
                    <li><b>Price: </b><span class="right">£ {{ number_format($checkoutItem->unitary_price, 2, '.', ',') }}</span></li>
                    <li class="divider"></li>
                    <li><b>Total Item: </b><span class="right">£ {{ number_format($checkoutItem->total_price, 2, '.', ',') }}</span></li>
                </ul>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row section hide-on-small-only">
        <div class="col m8"></div>
        <div class="col m4" style="border: solid 1px #4f4d1f; border-radius: 20px">
            <ul style="margin: 0px; font-family: BarterExchange-Regular; padding: 20px;">
                <li><b>Subtotal: </b><span class="right">£ {{ number_format($checkout->partial_value, 2, '.', ',') }}</span></li>
                <li><b>Delivery Fee: </b><span class="right">£ {{ number_format($checkout->delivery_fee, 2, '.', ',') }}</span></li>
                <li><b>Rider Tip: </b><span class="right">£ {{ number_format($checkout->rider_tip, 2, '.', ',') }}</span></li>
                <div class="divider"></div>
                <li><b>Total: </b><span class="right">£ {{ number_format($checkout->total_value, 2, '.', ',') }}</span></li>
                <div class="row hide-on-small-only center" style="padding-top: 20px; font-family: HussarBoldWeb;">
                    <a class="btn waves-effect waves-light" style="width: 200px;" href="{{ route('admin.orderhistory.orderagain', $checkout->id) }}">Order Again</a>
                </div>
            </ul>
        </div>
    </div>
    <div class="row section hide-on-med-and-up">
        <div class="col s12" style="border: solid 1px #4f4d1f; border-radius: 20px">
            <ul style="margin: 0px; font-family: BarterExchange-Regular; padding: 20px;">
                <li><b>Subtotal: </b><span class="right">£ {{ number_format($checkout->partial_value, 2, '.', ',') }}</span></li>
                <li><b>Delivery Fee: </b><span class="right">£ {{ number_format($checkout->delivery_fee, 2, '.', ',') }}</span></li>
                <li><b>Rider Tip: </b><span class="right">£ {{ number_format($checkout->rider_tip, 2, '.', ',') }}</span></li>
                <div class="divider"></div>
                <li><b>Total: </b><span class="right">£ {{ number_format($checkout->total_value, 2, '.', ',') }}</span></li>
            </ul>
            <div class="row hide-on-med-and-up center" style="padding-top: 20px; font-family: HussarBoldWeb;">
                <a class="btn waves-effect waves-light" style="width: 200px;" href="{{ route('admin.orderhistory.orderagain', $checkout->id) }}">Order Again</a>
            </div>
        </div>
    </div>
</div>
<div class="row"></div>
@endsection