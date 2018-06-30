@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"> {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> {{ __('starter-translations::breadcrumb.dashboard') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fragments.index') }}">{{ __('starter-translations::fragments.titles.overview-short') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('starter-translations::fragments.titles.edit', ['title' => $fragment->page]) }}</li>
                    </ol>
                </nav>
            </div> {{-- /// END breadcrumb --}}

            <div class="col-md-12"> {{-- Edit form --}}
                <div class="card card-body">
                    <h6 class="border-bottom border-gray pb-2 mb-3">{{ __('starter-translations::fragments.titles.edit', ['title' => $fragment->page]) }}</h6>

                    <form class="">
                        <div id="summernote"></div>
                    </form>
                </div>
            </div> {{-- /// Edit form --}}
        </div>
    </div>
@endsection

@push('stylesheets')
    
@endpush

@push('javascript')
    
@endpush