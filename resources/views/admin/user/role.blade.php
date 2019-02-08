@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
    <div class="row">
        <h3 class="center-align hide-on-small-only">List of Roles for {{ ucfirst($user->name) }}</h3>
        <h5 class="center-align hide-on-med-and-up">List of Roles for {{ ucfirst($user->name) }}</h3>
        <div class="divider"></div>
    </div>
    <div class="row hide-on-small-only">
			<form action="{{ route('admin.user.role.add', $user->id) }}" method="post">
				{{ csrf_field() }}
				<div class="row valign-wrapper">
					<div class="col s12 m4">
						<div class="input-field">
							<select name="role_id">
								<option value=""></option>
								@foreach($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endforeach
							</select>
							<label>Roles</label>
						</div>
					</div>
					<div class="col s12 m8" style="height: 100%;">
						<button class="btn waves-effect waves-light">Add</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row hide-on-med-and-up">
			<form action="{{ route('admin.user.role.add', $user->id) }}" method="post">
				{{ csrf_field() }}
				<div class="row">
					<div class="col s12 m4">
						<div class="input-field">
							<select name="role_id">
								<option value=""></option>
								@foreach($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endforeach
							</select>
							<label>Roles</label>
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
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($user->roles as $role)
                <tr>
                    <td>{{ ucfirst($role->name) }}</td>
                    <td>
                        <a class="btn-icon" href="{{ route('admin.user.role.remove', [$user->id, $role->id]) }}" title="remove"><i class="small material-icons">delete</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row hide-on-med-and-up">
        @foreach($user->roles as $role)
            <div class="col s12 m6">
                <div class="card card-table">
                    <div class="card-content" style="min-height: 80px;">
                        <p><b>Name: </b><span>{{ ucfirst($role->name) }}</span></p>
                    </div>
                    <div class="card-action right-align" style="min-height: 70px;">
                        <a class="btn-icon" href="{{ route('admin.user.role.remove', [$user->id, $role->id]) }}" title="remove"><i class="small material-icons">delete</i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($user->roles->count() == 0)
    <div class="row center-align" style="font-family: BarterExchange-Regular;">No records found.</div>
    @endif
</div>
<div class="row"></div>
@endsection