@extends('layout.abstract')
@section('content')
	<div class="container">
		<div class="content">
			<div class="title">Your wall here, {{ $user->getFullName() }}</div>
			<img src="{{ $user->getProfilePicture() }}">
		</div>

	</div>
@stop