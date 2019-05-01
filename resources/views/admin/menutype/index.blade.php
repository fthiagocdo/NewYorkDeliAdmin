@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Menu Types</h3>
        <h5 class="center-align hide-on-med-and-up">List of Menu Types</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
        <form action="{{ route('admin.menutype.shop') }}" method="post">
            {{ csrf_field() }}
            <div class="row valign-wrapper">
                <div class="col s12 m4">
                    <div class="input-field">
                        <select name="shop_id">
                            @foreach($shops as $shop)
                            @if($shop_id == $shop->id)
                            <option value="{{ $shop->id }}" selected>{{ $shop->name }}</option>
                            @else
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        <label>Shops</label>
                    </div>
                </div>
                <div class="col s12 m8" style="height: 100%;">
                    <button class="btn waves-effect waves-light">Confirm</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row hide-on-med-and-up">
        <form action="{{ route('admin.menutype.shop') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col s12 m4">
                    <div class="input-field">
                        <select name="shop_id">
                            @foreach($shops as $shop)
                            @if($shop_id == $shop->id)
                            <option value="{{ $shop->id }}" selected>{{ $shop->name }}</option>
                            @else
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        <label>Shops</label>
                    </div>
                </div>
                <div class="col s12 m8 center-align" style="height: 100%;">
                    <button class="btn waves-effect waves-light">Confirm</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 80%;">Name</th>
                    <th style="width: 20%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registers as $register)
                <tr>
                    <td>{{ ucfirst($register->name) }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem', $register->id) }}" title="roles"><i class="small material-icons">assignment</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.edit', $register->id) }}"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="javascript: if(confirm('Delete menu type?')){ window.location.href = '{{ route('admin.menutype.delete', $register->id) }}' }"><i class="small material-icons">delete</i></a>
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
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.menutype.menuitem', $register->id) }}" title="roles"><i class="small material-icons">assignment</i></a>
                        <a class="btn-icon" href="{{ route('admin.menutype.edit', $register->id) }}"><i class="small material-icons">edit</i></a>
                        <a class="btn-icon" href="javascript: if(confirm('Delete menu type?')){ window.location.href = '{{ route('admin.menutype.delete', $register->id) }}' }"><i class="small material-icons">delete</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($registers->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
    <div class="row hide-on-small-only">
        <a class="btn waves-effect waves-light" href="{{ route('admin.menutype.add') }}">Add</a>
    </div>
    <div class="row center-align hide-on-med-and-up">
        <a class="btn waves-effect waves-light" href="{{ route('admin.menutype.add') }}">Add</a>
    </div>
</div>
<div class="row"></div>
@endsection