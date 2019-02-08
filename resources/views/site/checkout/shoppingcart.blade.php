@extends('layouts.site')

@section('content')
<form action="{{ route('site.checkout.confirm') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" id="deliverOrCollect" name="deliverOrCollect" value="deliver">
    <input type="hidden" id="preferredShop" name="preferredShop" value="{{ $checkout->shop_id }}">
    <div class="row hide-on-med-and-up"></div>
    <div class="container container-content">
        <div class="row">
            <h3 class="center-align hide-on-small-only">My Shopping Cart</h3>
            <h5 class="center-align hide-on-med-and-up">My Shopping Cart</h3>
            <div class="divider"></div>
        </div>
        <div class="row hide-on-small-only">
            <table class="table striped">
                <thead>
                    <tr>
                        <th style="width: 60%;">Itens</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 10%;"></th>
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
                        <td><a class="btn-icon" href="{{ route('site.checkout.plusitem', $checkoutItem->id) }}" title="add"><i class="tiny material-icons">add_circle_outline</i></a><span style="padding: 10px;">{{ $checkoutItem->quantity }}</span><a class="btn-icon" href="{{ route('site.checkout.minusitem', $checkoutItem->id) }}" title="remove"><i class="tiny material-icons">remove_circle_outline</i></a></td>
                        <td>£ {{ number_format($checkoutItem->unitary_price, 2, '.', ',') }}</td>
                        <td>£ {{ number_format($checkoutItem->total_price, 2, '.', ',') }}</td>
                        <td>                        
                            <a class="btn-icon" href="{{ route('site.checkout.removeitem', $checkoutItem->id) }}" title="delete"><i class="small material-icons">delete</i></a>
                        </td>
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
                        <li><b>Quantity: </b><span class="right"><a class="btn-icon" href="{{ route('site.checkout.plusitem', $checkoutItem->id) }}" title="add"><i class="tiny material-icons">add_circle_outline</i></a><span style="padding: 10px;">{{ $checkoutItem->quantity }}</span><a class="btn-icon" href="{{ route('site.checkout.minusitem', $checkoutItem->id) }}" title="remove"><i class="tiny material-icons">remove_circle_outline</i></a></span></li>
                        <li><b>Price: </b><span class="right">£ {{ number_format($checkoutItem->unitary_price, 2, '.', ',') }}</span></li>
                        <li class="divider"></li>
                        <li><b>Total Item: </b><span class="right">£ {{ number_format($checkoutItem->total_price, 2, '.', ',') }}</span></li>
                    </ul>
                </div>
                <div class="card-action right-align" style="min-height: 70px;">
                    <a class="btn-icon" href="{{ route('site.checkout.removeitem', $checkoutItem->id) }}" title="delete"><i class="small material-icons">delete</i></a>
                </div>
            </div>
            @endforeach
        </div>
        @if($checkoutItems->count() == 0)
        <div class="row center-align" style="font-family: BarterExchange-Regular;">Your cart is empty.</div>
        @endif
        <div class="row section hide-on-small-only">
            <div class="col m8" style="background-color: #f2f2f2; width: 65%;margin-right: 1rem; border-radius: 20px;">
                <div class="input-field" style="margin-top: 0rem; margin-bottom: 2rem;">
                    <input class="validate" type="radio" name="radioDeliveryOrCollect-med" onclick="$('#deliverOrCollect').val('deliver');" checked>
                    <label>Deliver or</label>
                    <input class="validate" type="radio" name="radioDeliveryOrCollect-med" onclick="$('#deliverOrCollect').val('collect');">
                    <label>Collect?</label>
                </div>
                <label class="label-radio">Choose the shop:</label>
                <div class="input-field" style="margin-top: 0rem;">
                    @foreach($shops as $shop)
                    <input class="validate" type="radio" name="radioPreferredShop-med" {{ $checkout->shop_id == $shop->id ? 'checked' : '' }} onclick="$('#preferredShop').val({{ $shop->id }});" {{ $shop->isOpen() ? '' : 'disabled' }}>
                    <label>{{ $shop->name }} - {{ $shop->address }} <i>{{ $shop->isOpen() ? '' : '- Closed Now' }}</i></label>
                    @endforeach
                </div>
                <div class="row"></div>
                <div class="row"></div>
            </div>
            <div class="col m4" style="border: solid 1px #4f4d1f; border-radius: 20px">
                <ul style="margin: 0px; font-family: BarterExchange-Regular; padding: 20px;">
                    <li><b>Subtotal: </b><span class="right">£ {{ number_format($checkout->partial_value, 2, '.', ',') }}</span></li>
                    <li><b>Delivery Fee: </b><span class="right">£ {{ number_format($checkout->delivery_fee, 2, '.', ',') }}</span></li>
                    <li><b>Rider Tip: </b><a class="btn-icon" style="padding-right: 5px;" href="{{ route('site.checkout.plustip') }}" title="add"><i class="tiny material-icons">add_circle_outline</i></a><a class="btn-icon" href="{{ route('site.checkout.minustip') }}" title="remove"><i class="tiny material-icons">remove_circle_outline</i></a><span class="right">£ {{ number_format($checkout->rider_tip, 2, '.', ',') }}</span></li>
                    <div class="divider"></div>
                    <li><b>Total: </b><span class="right">£ {{ number_format($checkout->total_value, 2, '.', ',') }}</span></li>
                    <div class="row hide-on-small-only center" style="padding-top: 20px; font-family: HussarBoldWeb;">
                        <button class="btn waves-effect waves-light">Checkout</button>
                    </div>
                </ul>
            </div>
        </div>
        <div class="row section hide-on-med-and-up">
            <div class="col s12" style="border: solid 1px #4f4d1f; border-radius: 20px">
                <ul style="margin: 0px; font-family: BarterExchange-Regular; padding: 20px;">
                    <li><b>Subtotal: </b><span class="right">£ {{ number_format($checkout->partial_value, 2, '.', ',') }}</span></li>
                    <li><b>Delivery Fee: </b><span class="right">£ {{ number_format($checkout->delivery_fee, 2, '.', ',') }}</span></li>
                    <li><b>Rider Tip: </b><a class="btn-icon" style="padding-right: 5px;" href="{{ route('site.checkout.plustip') }}" title="add"><i class="tiny material-icons">add_circle_outline</i></a><a class="btn-icon" href="{{ route('site.checkout.minustip') }}" title="remove"><i class="tiny material-icons">remove_circle_outline</i></a><span class="right">£ {{ number_format($checkout->rider_tip, 2, '.', ',') }}</span></li>
                    <div class="divider"></div>
                    <li><b>Total: </b><span class="right">£ {{ number_format($checkout->total_value, 2, '.', ',') }}</span></li>
                </ul>
            </div>
            <div class="col s12" style="background-color: #f2f2f2; margin-top: 1rem; border-radius: 20px;">
                <div class="input-field" style="margin-top: 0rem; margin-bottom: 2rem;">
                    <input class="validate" type="radio" name="radioDeliveryOrCollect-mobile" onclick="$('#deliverOrCollect').val('deliver');" checked>
                    <label>Deliver or</label>
                    <input class="validate" type="radio" name="radioDeliveryOrCollect-mobile" onclick="$('#deliverOrCollect').val('collect');">
                    <label>Collect?</label>
                </div>
                <label class="label-radio">Choose the shop:</label>
                <div class="input-field" style="margin-top: 0rem;">
                    @foreach($shops as $shop)
                    <input class="validate" type="radio" name="radioPreferredShop-mobile" {{ $checkout->shop_id == $shop->id ? 'checked' : '' }} onclick="$('#preferredShop').val({{ $shop->id }});" {{ $shop->isOpen() ? '' : 'disabled' }}>
                    <label>{{ $shop->name }} - {{ $shop->address }} <i>{{ $shop->isOpen() ? '' : '- Closed Now' }}</i></label>
                    @endforeach
                </div>
                <div class="row"></div>
            </div>
        </div>
        <div class="row center-align hide-on-med-and-up">
            <button class="btn waves-effect waves-light">Checkout</button>
        </div>
    </div>
    <div class="row"></div>
</form>
@endsection