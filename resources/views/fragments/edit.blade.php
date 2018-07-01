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

                    <form action="{{ route('admin.fragments.update', ['slug' => $fragment->slug]) }}" method="POST">
                        @csrf               {{-- Form field protection --}}
                        @method('PATCH')    {{-- HTTP method spoofing --}}

                        <div class="form-group row">
                            <label for="fragmentTitle" class="col-sm-3 col-form-label">
                                {{ __('starter-translations::fragments.form.labels.title') }} <span class="text-danger">*</span>
                            </label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="fragmentTitle" input="title" value="{{ $fragment->title ?? old('title') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editor1" class="col-sm-3 col-form-label">
                                {{ __('starter-translations::fragments.form.labels.content') }} <span class="text-danger">*</span>
                            </label>

                            <div class="col-md-9">
                                <textarea name="editor1" id="editor1" @input('content') class="form-control" rows="10" cols="80">{{ $fragment->content ?? old('content') }}</textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row mb-0">
                            <div class="offset-3 col-9">
                                <button type="submit" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-fw fa-save"></i> {{ __('starter-translations::fragments.form.buttons.submit') }}
                                </button>

                                <button type="reset" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-fw fa-undo-alt"></i> {{ __('starter-translations::fragments.form.buttons.reset') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div> {{-- /// Edit form --}}
        </div>
    </div>
@endsection

@push('stylesheets')
    
@endpush

@push('javascript')
    <script defer src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
    <script> 
        $(function () { 
            CKEDITOR.replace( 'editor1' ); 
            CKEDITOR.config.height = 250; 
            CKEDITOR.config.resize_enabled = false;
            CKEDITOR.config.defaultLanguage = '{{ config('app.locale') }}';
            CKEDITOR.config.toolbar = [
                ['Styles','Format','Font','FontSize'],
                ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
                ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
            ];
        });
    </script>
@endpush