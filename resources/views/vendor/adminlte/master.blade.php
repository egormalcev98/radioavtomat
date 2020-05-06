<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
@if($settings and $settings->name_sys)
@yield('title', config($settings->name_sys, $settings->name_sys))
@else
@yield('title', config('adminlte.title', 'AdminLTE 3'))
@endif
@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    @if(! config('adminlte.enabled_laravel_mix'))
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @include('adminlte::plugins', ['type' => 'css'])

    @yield('adminlte_css_pre')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    @yield('adminlte_css')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @endif

    @yield('meta_tags')

    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif
</head>
<body class="@yield('classes_body')" @yield('body_data')>

@yield('body')

@include('crm.chat.widget')

@include('crm.modal')

@if(! config('adminlte.enabled_laravel_mix'))
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

@include('adminlte::plugins', ['type' => 'js'])

@if(auth()->check())
	<script>
		// global app configuration object
		var config = {
			token: '{!! csrf_token() !!}',
			route: {
				chat_select_channel: '{{ route("chat.select_channel") }}',
				chat_read_msg: '{{ route("chat.read_msg") }}'
			}
		};
	</script>

	<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
	<script src="{{ asset('/js/plugins/controlmodal/control-modal.js?78') }}"></script>
	<script src="{{ asset('/js/plugins/masked/jquery.maskedinput.min.js') }}"></script>
	<script src="{{ asset('/js/main.js?58910') }}"></script>
	<script src="{{ asset('/js/chat.js?5') }}"></script>
	<script src="{{ asset('/js/date_range_picker.js') }}"></script>
	<script src="{{ asset('/js/task_global.js') }}"></script>

	<script>
		window.Pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
		   wsHost: window.location.hostname,
		   wsPort: {{ config('websockets.dashboard.port') }},
		   disableStats: true,
		   authEndpoint: '/broadcasting/auth',
		   auth: {
			   headers: {
				   'X-CSRF-Token': config['token']
			   }
		   }
		});

		$(document).ready(function(){
			$('#chat_users').change(function() {
				Chat.changeUser($(this), Pusher, {{ auth()->user()->id }});
			});

			$('#chat_structural_units').change(function() {
				Chat.changeStructuralUnit($(this), Pusher, {{ auth()->user()->id }});
			});

			Chat.selectedChannelAuthUser(Pusher, @if(auth()->user()->chat_channel) {!! auth()->user()->chat_channel !!} @else null @endif, {{ auth()->user()->id }});

		});

		var channel = Pusher.subscribe('private-user.{{ auth()->user()->id }}');

		channel.bind('notifyNewMessage', function (data) {
			Chat.notifyNewMessage(data);
		});

		channel.bind('updateCountNewMessages', function (data) {
			Chat.updateCountNewMessages(data);
		});

		channel.bind('updateBell', function (data) {
			$('#notifications_bell').html(data['html']);
		});

	</script>
@endif

@yield('adminlte_js')
@else
<script src="{{ mix('js/app.js') }}"></script>
@endif

</body>
</html>
