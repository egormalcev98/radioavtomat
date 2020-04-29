<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
	<i class="far fa-bell"></i>
	@if($dataNotifications->isNotEmpty())
		<span class="badge badge-warning navbar-badge">{{ $dataNotifications->count() }}</span>
	@endif
</a>
@if($dataNotifications->isNotEmpty())
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px; min-width: 400px;">
		<span class="dropdown-item dropdown-header"></span>
		@foreach($dataNotifications as $not)
			<div class="dropdown-divider"></div>
			<a href="{{ $not['url'] }}" class="dropdown-item">
				{{ Str::limit($not['title_notification'], 30) }}
				<span class="float-right text-muted text-sm">{{ $not['date'] }}</span>
			</a>
		@endforeach
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item dropdown-footer"></a>
	</div>
@endif