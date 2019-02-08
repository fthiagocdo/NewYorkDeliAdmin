@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Menu Item for {{ $menutype->name }}</h3>
        <h5 class="center-align hide-on-med-and-up">List of Menu Item for {{ $menutype->name }}</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 45%;">Description</th>
                    <th style="width: 10%;">Price</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ $register->name }}</td>
                    <td>{{ $register->description }}</td>
                    <td>£ {{ number_format($register->price, 2, '.', ',') }}</td>
                    <td>          
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.menuextra', $register->id) }}" title="roles"><i class="small material-icons">assignment</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.edit', $register->id) }}" title="edit"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.delete', $register->id) }}" title="delete"><i class="small material-icons">delete</i></a>
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
                    <div class="card-image">
                        <a href="#!"><img src="{{ isset($register->image) ? asset($register->image) : asset('img/menu/'.strtolower($menutype->name).'.jpg') }}"></a>
                    </div>
                    <div class="card-content" style="min-height: 80px;">
                        <p><b>Name: </b><span>{{ $register->name }}</span></p>
                        <p><b>Description: </b><span>{{ $register->description }}</span></p>
                        <p><b>Price: </b><span>£ {{ number_format($register->price, 2, '.', ',') }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.menuextra', $register->id) }}" title="roles"><i class="small material-icons">assignment</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.edit', $register->id) }}" title="edit"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem.delete', $register->id) }}" title="delete"><i class="small material-icons">delete</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($registers->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
    <div class="row hide-on-small-only">
        <a class="btn waves-effect waves-light" href="{{ route('admin.menutype.menuitem.add', $menutype->id) }}">Add</a>
    </div>
    <div class="row center-align hide-on-med-and-up">
        <a class="btn waves-effect waves-light" href="{{ route('admin.menutype.menuitem.add', $menutype->id) }}">Add</a>
    </div>
</div>
<div class="row"></div>
@endsection