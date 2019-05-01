@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">Opening Time for {{ ucfirst($shop->name) }}</h3>
        <h5 class="center-align hide-on-med-and-up">Opening Time for {{ ucfirst($shop->name) }}</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 30%;">Day of Week</th>
                    <th style="width: 30%;">Opening Time</th>
                    <th style="width: 30%;">Closing Time</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ ucfirst($register->day_week) }}</td>
                    <td>{{ $register->opening_time }}</td>
                    <td>{{ $register->closing_time }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.shop.shopschedule.edit', $register->id) }}"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="javascript: if(confirm('Delete shop schedule?')){ window.location.href = '{{ route('admin.shop.shopschedule.delete', $register->id) }}' }"><i class="small material-icons">delete</i></a>
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
                        <p><b>Day of Week: </b><span>{{ ucfirst($register->day_week) }}</span></p>
                        <p><b>Opening Time: </b><span>{{ $register->opening_time }}</span></p>
                        <p><b>Closing Time: </b><span>{{ $register->closing_time }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.shop.shopschedule.edit', $register->id) }}"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="javascript: if(confirm('Delete shop schedule?')){ window.location.href = '{{ route('admin.shop.shopschedule.delete', $register->id) }}' }"><i class="small material-icons">delete</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($registers->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
    <div class="row hide-on-small-only">
        <a class="btn waves-effect waves-light" href="{{ route('admin.shop.shopschedule.add', $shop->id) }}">Add</a>
    </div>
    <div class="row center-align hide-on-med-and-up">
        <a class="btn waves-effect waves-light" href="{{ route('admin.shop.shopschedule.add', $shop->id) }}">Add</a>
    </div>
</div>
<div class="row"></div>
@endsection