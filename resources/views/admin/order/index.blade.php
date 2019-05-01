@extends('layouts.site')

@section('content')
<input type="hidden" id="shop_id" name="shop_id" value="{{ $shop->id }}">
<input type="hidden" id="new_order" name="new_order" value="{{ $hasNewOrder }}">
<audio id="notification" src="{{ asset('/sounds/new_order.mp3') }}"></audio>
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Orders - {{ $shop->name }}</h3>
        <h5 class="center-align hide-on-med-and-up">List of Orders - {{ $shop->name }}</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 15%;">Id</th>
                    <th style="width: 20%;">Date</th>
                    <th style="width: 35%;">Customer</th>
                    <th style="width: 20%;">Value</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ str_pad($register->id, 6, "0", STR_PAD_LEFT) }}</td>
                    <td>{{ Util::formatDate(Util::createDateFromDatabase($register->updated_at)) }}</td>
                    <td>{{ ucwords($register->user->name) }}</td>
                    <td>£ {{ number_format($register->total_value, 2, '.', ',') }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.order.print', $register->id) }}" target="_blank" onclick="location.reload();"><i class="small material-icons" title="Print Order">print</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row hide-on-med-and-up">
        @foreach($registers as $register)
            <div class="col s12 m6">
                <div class="card card-table">
                    <div class="card-content" style="min-height: 80px;">
                        <p><b>Id: </b><span>{{ str_pad($register->id, 6, "0", STR_PAD_LEFT) }}</span></p>
                        <p><b>Date: </b><span>{{ Util::formatDate(Util::createDateFromDatabase($register->updated_at)) }}</span></p>
                        <p><b>Customer: </b><span>{{ ucfirst($register->name) }}</span></p>
                        <p><b>Value: </b><span>£ {{ number_format($register->total_value, 2, '.', ',') }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.order.print', $register->id) }}" target="_blank" onclick="location.reload();"><i class="small material-icons" title="Print Order">print</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($registers->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
    <div class="row" align="center">
        {{ $registers->links() }}
    </div>
</div>
<div class="row"></div>
@endsection