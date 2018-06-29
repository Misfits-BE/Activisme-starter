@extends('layouts.app')

@section('content')
	<div class="jumbotron">
		<div class="container">
			<h1 class="display-3">{{ $pageData->title }}</h1>
      		<p class="lead">Last update: {{ $pageData->updated_at->format('d F, Y')}}</p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="card card-body mb-4">
					<p class="card-text">{!! $pageData->content !!}</p>
				</div>
			</div>
		</div>
	</div>
@endsection
