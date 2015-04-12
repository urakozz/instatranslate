@extends('layout.promo')
@section('content')
	<div class="promo title">Auth rejected</div>
	<blockquote>
		<p>{{ $desc }}</p>
		<footer>Instagram auth</footer>
	</blockquote>
	<div class="promo quote">
		<a role="button" class="btn btn-success btn-lg it-button" href="/">Maybe try again? Go to the main page</a>
	</div>
@stop
