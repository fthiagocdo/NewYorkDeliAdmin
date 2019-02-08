@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">Order History</h3>
        <h5 class="center-align hide-on-med-and-up">Order History</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 15%;">Id</th>
                    <th style="width: 20%;">Date</th>
                    <th style="width: 20%;">Value</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ str_pad($register->id, 6, "0", STR_PAD_LEFT) }}</register>
                    <td>{{ Util::formatDate(Util::createDateFromDatabase($register->updated_at)) }}</register>
                    <td>£ {{ number_format($register->total_value, 2, '.', ',') }}</register>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.orderhistory.details', $register->id) }}"><i class="small material-icons" title="Order Details">search</i></a>
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
                        <a class="btn-icon" href="{{ route('admin.orderhistory.details', $register->id) }}"><i class="small material-icons" title="Order Details">search</i></a>
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