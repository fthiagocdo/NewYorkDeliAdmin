<input type="hidden" name="menuitem_id" id="menuitem_id" />
<input type="hidden" name="menuextra_action" id="menuextra_action">
<div class="row" style="margin-bottom: 0px">
	<div class="col m12 s12" style="padding: 0px 0px 0px 0px;">
		<div class="input-field card-common">
			<select name="shop_id" onchange="this.form.submit()">
				@foreach($shops as $shop)
					<option value="{{ $shop->id }}">{{ $shop->name }} - {{ $shop->address }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="row hide-on-small-only">
	<ul class="collapsible collapsible-accordion" id="tabs-med">
		@foreach($menutypes as $menutype)
	    <li>
	      <div class="collapsible-header" id="{{ str_slug($menutype->name, '-') }}-tab-med">{{ $menutype->name }}</div>
	      <div class="collapsible-body">
      		@for ($i = 0; $i < $menutype->menuItems->count(); $i++)
      		@if($i % 4 == 0)
	      	<div class="row">
	      	@endif
				<div class="col m3">
					<div class="card">
						<div class="card-image">
							<a href="#"><img src="{{ isset($menutype->menuItems->get($i)->image) ? $menutype->menuItems->get($i)->image : asset('img/menu/'.strtolower($menutype->name).'.jpg') }}"></a>
							@if($menutype->menuItems->get($i)->menuExtras->count())
		                    <a class="btn-floating btn-large halfway-fab modal-trigger waves-effect waves-light" href="#modalExtras-med-{{ str_slug($menutype->menuItems->get($i)->name, '-').$menutype->menuItems->get($i)->id }}" onclick="$('#menuitem_id').val({{ $menutype->menuItems->get($i)->id }});"><i class="large material-icons">add</i></a>
		                    @else
		                    <a class="btn-floating btn-large halfway-fab modal-trigger waves-effect waves-light" href="#{{ str_slug($menutype->name, '-') }}-tab-med" onclick="$('#menuitem_id').val({{ $menutype->menuItems->get($i)->id }}); $('#form_menu').submit();"><i class="large material-icons">add</i></a>
		                    @endif
						</div>
						<div class="card-content">
							<p><b class="title">{{ $menutype->menuItems->get($i)->name }}</b></p>
							<p class="description">{{ $menutype->menuItems->get($i)->description }}</p>
							<p><b>£{{ number_format($menutype->menuItems->get($i)->price, 2, '.', ',') }}</b></p>
						</div>
					</div>
				</div>	
			@if(($i+1) % 4 == 0)
			</div>
			@endif
			@endfor
	    </li>
	    @endforeach
	</ul>
</div>
<div class="row section menu hide-on-med-and-up">
	<ul id="tabs-swipe-demo" class="tabs">
		@foreach($menutypes as $menutype)
	    <li class="tab" id="{{ str_slug($menutype->name, '-') }}-tab"><a href="#{{ str_slug($menutype->name, '-') }}-mobile">{{ strtoupper($menutype->name) }}</a></li>
	    <div id="{{ str_slug($menutype->name, '-') }}-tab-mobile"></div>
	    @endforeach
	</ul>
	@foreach($menutypes as $menutype)
	<div id="{{ str_slug($menutype->name, '-') }}-mobile" class="col s12 white">
		@foreach($menutype->menuItems as $menuitem)
		<div class="row">
			<div class="col s12">
				<div class="card" id="{{ str_slug($menuitem->name, '-') }}-mobile">
					<div class="card-image">
						<a href="#"><img src="{{ isset($menuitem->image) ? $menuitem->image : asset('img/menu/'.strtolower($menutype->name).'.jpg') }}"></a>
	                    @if($menuitem->menuExtras->count())
	                    <a class="btn-floating btn-large halfway-fab modal-trigger waves-effect waves-light" href="#modalExtras-mobile-{{ str_slug($menuitem->name, '-').$menuitem->id }}" onclick="$('#menuitem_id').val({{ $menuitem->id }});"><i class="large material-icons">add</i></a>
	                    @else
	                    <a class="btn-floating btn-large halfway-fab modal-trigger waves-effect waves-light" href="#{{ str_slug($menuitem->name, '-') }}-mobile" onclick="$('#menuitem_id').val({{ $menuitem->id }}); $('#form_menu').submit();"><i class="large material-icons">add</i></a>
	                    @endif
					</div>
					<div class="card-content">
						<p><b class="title">{{ $menuitem->name }}</b></p>
						<p class="description">{{ $menuitem->description }}</p>
						<p><b>£{{ number_format($menuitem->price, 2, '.', ',') }}</b></p>
					</div>
				</div>
			</div>	
		</div>
		@endforeach
	</div>
	@endforeach
</div>

@foreach($menutypes as $menutype)
@foreach($menutype->menuItems as $menuitem)
@if($menuitem->menuExtras->count())
<!-- Modal Structure -->
<div id="modalExtras-med-{{ str_slug($menuitem->name, '-').$menuitem->id }}" class="modal">
    <div class="modal-content">
      <h3>Want to add any extras?</h4>
      <table class="table">
	        <tbody>
            	@for ($i = 0; $i < $menuitem->menuExtras->count(); $i++)
	      		@if($i % 3 == 0)
		      	<tr>
		      	@endif
	            	<td class="input-field">
						<input class="filled-in" type="checkbox" name="menuextra_{{ $menuitem->menuExtras->get($i)->id }}">
						<label>{{ $menuitem->menuExtras->get($i)->name }} - £{{ number_format($menuitem->menuExtras->get($i)->price, 2, '.', ',') }}</label>
					</td>
				@if(($i+1) % 3 == 0)
				</tr>
				@endif
				@endfor
	            </tr>
	        </tbody>
	    </table>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn" style="width: 200px;" onclick="$('#menuextra_action').val('noextras')">No Extras</a>
      <a href="#!" class="modal-close waves-effect waves-green btn" style="width: 200px;" onclick="$('#menuextra_action').val('addextras')">Add Extras</a>
    </div>
</div>
@endif
@endforeach
@endforeach

@foreach($menutypes as $menutype)
@foreach($menutype->menuItems as $menuitem)
@if($menuitem->menuExtras->count() > 0)
<!-- Modal Structure -->
<div id="modalExtras-mobile-{{ str_slug($menuitem->name, '-').$menuitem->id }}" class="modal bottom-sheet">
    <div class="modal-content">
      <h5>Want to add any extras?</h4>
      <table class="table">
	        <tbody>
	        	@for ($i = 0; $i < $menuitem->menuExtras->count(); $i++)
	            <tr>
	            	<td class="input-field">
						<input class="filled-in" type="checkbox" name="menuextra_{{ $menuitem->menuExtras->get($i)->id }}">
						<label>{{ $menuitem->menuExtras->get($i)->name }} £{{ number_format($menuitem->menuExtras->get($i)->price, 2, '.', ',') }}</label>
					</td>
	            </tr>
	            @endfor
	        </tbody>
	    </table>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn" style="width: 100px;" onclick="$('#menuextra_action').val('noextras')">No Extras</a>
      <a href="#!" class="modal-close waves-effect waves-green btn" style="width: 100px;" onclick="$('#menuextra_action').val('addextras')">Add Extras</a>
    </div>
</div>
@endif
@endforeach
@endforeach