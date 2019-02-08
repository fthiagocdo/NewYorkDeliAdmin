@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Permissions for {{ ucfirst($role->name) }}</h3>
        <h5 class="center-align hide-on-med-and-up">List of Permissions for {{ ucfirst($role->name) }}</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
			<form action="{{ route('admin.role.permission.add', $role->id) }}" method="post">
				{{ csrf_field() }}
				<div class="row valign-wrapper">
					<div class="col s12 m4">
						<div class="input-field">
							<select name="permission_id">
								<option value="" disabled selected>Choose an option</option>
								@foreach($permissions as $permission)
								<option value="{{ $permission->id }}">{{ $permission->name }}</option>
								@endforeach
							</select>
							<label>Permissions</label>
						</div>
					</div>
					<div class="col s12 m8" style="height: 100%;">
						<button class="btn waves-effect waves-light">Add</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row hide-on-med-and-up">
			<form action="{{ route('admin.role.permission.add', $role->id) }}" method="post">
				{{ csrf_field() }}
				<div class="row">
					<div class="col s12 m4">
						<div class="input-field">
							<select name="permission_id">
                                <option value=""></option>
                                @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <label>Permissions</label>
						</div>
					</div>
					<div class="col s12 m8 center-align" style="height: 100%;">
						<button class="btn waves-effect waves-light">Add</button>
					</div>
				</div>
			</form>
		</div>
    <div class="row hide-on-small-only">
        <table class="table striped">
            <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 60%;">Description</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($role->permissions as $permission)
                <tr>
                    <td>{{ strtoupper($permission->name) }}</td>
                    <td>{{ ucfirst($permission->description) }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.role.permission.remove', [$role->id, $permission->id]) }}" title="remove"><i class="small material-icons">delete</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row hide-on-med-and-up">
        @foreach($role->permissions as $permission)
            <div class="col s12 m6">
                <div class="card card-table">
                    <div class="card-content" style="min-height: 80px;">
                        <p><b>Name: </b><span>{{ strtoupper($permission->name) }}</span></p>
                        <p><b>Description: </b><span>{{ ucfirst($permission->description) }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.role.permission.remove', [$role->id, $permission->id]) }}" title="remove"><i class="small material-icons">delete</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($role->permissions->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
</div>
<div class="row"></div>
@endsection