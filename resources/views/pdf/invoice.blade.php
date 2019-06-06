<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New York Deli</title>
</head>
<body style="width: 300px;">
	<p style="margin: 5px;"><strong>Order Number:</strong> {{ ucwords($checkout->payment->order_number) }}</p>
	<p style="margin: 5px;"><strong>Customer:</strong> {{ ucwords($checkout->customer->name) }}</p>
	<p style="margin: 5px;"><strong>Phone Number:</strong> {{ $checkout->delivery_phone }}</p>
	@if($checkout->deliver_or_collect == 'deliver_address')
	<p style="margin: 5px;"><strong>Address:</strong> {{ ucwords($checkout->delivery_address).', '.strtoupper($checkout->delivery_postcode) }}</p>
	@endif
	@if($checkout->deliver_or_collect == 'deliver_table')
	<p style="margin: 5px;"><strong>Table Number:</strong> {{ $checkout->table_number }}</p>
	@endif
	<p style="margin: 5px;"><strong>{{ $checkout->deliver_or_collect == 'deliver_address' || $checkout->deliver_or_collect == 'deliver_table' ? 'ORDER TO DELIVER AT' : 'ORDER TO COLLECT AT' }} {{ $checkout->time_delivery_collect }}</strong></p>
	<div style="height: 1px; overflow: hidden; background-color: black;"></div>
	@foreach($checkout->checkoutItems as $checkoutItem)
	<p style="margin: 5px;"><strong>{{ $checkoutItem->menuItem->name }} x{{ $checkoutItem->quantity }}</strong><span style="float: right;">&pound; {{ number_format($checkoutItem->total_price, 2, '.', ',') }}</span></p>
	<p style="margin: 5px;"><strong>Type: </strong>{{ $checkoutItem->menuItem->type->name }}</p>
	@if($checkoutItem->checkoutItemExtras->count() > 0)
	<p style="margin: 5px;"><strong>Extras:</strong></p>
	<ul style="margin: 5px;">
	@endif
	@foreach($checkoutItem->checkoutItemExtras as $checkoutItemExtra)
		<li style="list-style-type: none;">{{ $checkoutItemExtra->menuExtra->name }}</li>
	@endforeach
	@if($checkoutItem->checkoutItemExtras->count() > 0)
	</ul>
	@endif
	@endforeach
	@if(isset($checkout->checkout_message))
	<div style="height: 1px; overflow: hidden; background-color: black;"></div>
	<p style="margin: 5px;">{{ $checkout->checkout_message }}</p>
	@endif
	<div style="height: 1px; overflow: hidden; background-color: black;"></div>
	<p style="margin: 5px;"><strong>Subtotal:</strong><span style="float: right;">&pound; {{ number_format($checkout->partial_value, 2, '.', ',') }}</span></p>
	<p style="margin: 5px;"><strong>Delivery Fee:</strong><span style="float: right;">&pound; {{ number_format($checkout->delivery_fee, 2, '.', ',') }}</span></p>
	<p style="margin: 5px;"><strong>Rider Tip:</strong><span style="float: right;">&pound; {{ number_format($checkout->rider_tip, 2, '.', ',') }}</span></p>
	<p style="margin: 5px;"><strong>Total:</strong><span style="float: right;">&pound; {{ number_format($checkout->total_value, 2, '.', ',') }}</span><p>
</body>