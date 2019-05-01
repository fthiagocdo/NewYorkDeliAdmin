@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Users</h3>
        <h5 class="center-align hide-on-med-and-up">List of Users</h3>
        <div class="divider"></div>
    </div>
    @include('admin.user._filters')
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 10%;">Id</th>
                    <th style="width: 40%;">Name</th>
                    <th style="width: 40%;">E-mail</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ str_pad($register->id, 6, "0", STR_PAD_LEFT) }}</td>
                    <td>{{ ucfirst($register->name) }}</td>
                    <td>{{ $register->email }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.user.role', $register->id) }}" title="roles"><i class="small material-icons">assignment</i></a>
                        <a class="btn-icon" href="{{ route('admin.user.details', $register->id) }}" title="details"><i class="small material-icons">search</i></a>
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
                    @if(isset($register->avatar))
                    <div class="card-image">
                        <a href="#!"><img src="{{ asset($register->avatar) }}"></a>
                    </div>
                    @endif
                    <div class="card-content" style="min-height: 80px;">
                        <p><b>Id: </b><span>{{ str_pad($register->id, 6, "0", STR_PAD_LEFT) }}</span></p>
                        <p><b>Name: </b><span>{{ ucfirst($register->name) }}</span></p>
                        <p><b>E-mail: </b><span>{{ $register->email }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.user.role', $register->id) }}"><i class="small material-icons">search</i></a>
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
    @can('user_add')
    <div class="row hide-on-small-only">
        <a class="btn waves-effect waves-light" href="{{ route('admin.user.add') }}">Add</a>
    </div>
    <div class="row center-align hide-on-med-and-up">
        <a class="btn waves-effect waves-light" href="{{ route('admin.user.add') }}">Add</a>
    </div>
    @endcan
</div>
<div class="row"></div>
@endsection