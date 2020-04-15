@if($element->users->isNotEmpty())
	@foreach($element->users as $user)
		{{ $user->user->fullName }}
	@endforeach
@endif