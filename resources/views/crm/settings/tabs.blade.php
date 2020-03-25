@extends('adminlte::page')

@section('title', __('adminlte::menu.settings'))

@section('content_header')
    <h1>{{ __('adminlte::menu.settings') }}</h1>
@stop

@section('content')

	<div class="card card-primary card-outline card-outline-tabs">
		<div class="card-header p-0 border-bottom-0">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link @if($routeName == 'settings') active @endif" href="{{ route('settings.index') }}">Общие</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#custom-tabs-three-profile">Пользователи</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content" >
				<div class="tab-pane fade show active" role="tabpanel">
				
					@yield('tab_content')
				
				</div>
			</div>
		</div>
	</div>
@stop