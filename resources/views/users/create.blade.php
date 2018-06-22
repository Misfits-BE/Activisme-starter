@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> {{ __('starter-translations::breadcrumb.dashboard') }} </a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('starter-translations::users.titles.create') }}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-9"> {{-- Content --}}
                <div class="card card-body">
                    <h6 class="border-bottom border-gray pb-2 mb-3">{{ __('starter-translations::users.titles.create') }}</h6>
                
                    <form method="POST" action="">
                        @csrf {{-- Form field protection --}}

                        <div class="form-group row">
                            <label for="inputFirstname" class="col-sm-3 col-form-label-sm col-form-label">
                                {{ __('starter-translations::users.labels.name') }} <span class="text-danger">*</span>
                            </label>
                            
                            <div class="col-4">
                                <input type="text" class="form-control form-control-sm @error('firstname', 'is-invalid')" @input('lastname') id="inputFirstname" placeholder="{{ __('starter-translations::users.placeholders.firstname') }}">
                                @error('firstname')
                            </div>

                            <div class="col-5">
                                <input type="text" class="form-control form-control-sm @error('lastname', 'is-invalid')" @input('lastname') id="inputLastname" placeholder="{{ __('starter-translations::users.placeholders.lastname') }}">
                                @error('lastname')
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-3 col-form-label-sm col-form-label">
                                {{ __('starter-translations::users.labels.email') }} <span class="text-danger">*</span>
                            </label>
                        
                            <div class="col-9">
                                <input type="email" class="form-control form-control-sm @error('email', 'is-invalid')" @input('email') id="inputEmail" placeholder="{{ __('starter-translations::users.placeholders.email') }}">
                                @error('email')
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <div class="offset-3 col-9">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-fw fa-save"></i> {{ __('starter-translations::users.buttons.create') }}
                                </button>

                                <button typ="reset" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-fw fa-undo-alt"></i> {{ __('starter-translations::users.buttons.undo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> {{-- /// END content --}}

            <div class="col-3"> {{-- Side navigation --}}
                @include ('users.partials.navigation')
            </div> {{-- /// End side navigation --}}
        </div>
    </div>
@endsection