@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">Choose a shop</h3>
        <h5 class="center-align hide-on-med-and-up">Choose a Shop</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 55%;">Address</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ ucfirst($register->name) }}</td>
                    <td>{{ $register->address }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.order.orders', $register->id) }}" title="List Orders"><i class="small material-icons">search</i></a>
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
                        <p><b>Name: </b><span>{{ ucfirst($register->name) }}</span></p>
                        <p><b>Address: </b><span>{{ $register->address }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.order.orders', $register->id) }}" title="List Orders"><i class="small material-icons">search</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($registers->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
</div>
<div class="row"></div>
@endsection