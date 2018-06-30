@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> {{ __('starter-translations::breadcrumb.dashboard') }} </a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('starter-translations::users.titles.overview') }}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-9">
                <div class="card card-body">
                    <h6 class="border-bottom border-gray pb-2 mb-3">{{ __('starter-translations::users.titles.overview') }}</h6>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-top-0">{{ __('starter-translations::users.overview-table.name') }}</th>
                                    <th scope="col" class="border-top-0">{{ __('starter-translations::users.overview-table.email') }}</th>
                                    <th scope="col" class="border-top-0">{{ __('starter-translations::users.overview-table.registered-at') }}</th>
                                    <th scope="col" class="border-top-0">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users) > 0) {{-- Logins with the ACl role permission (user) found --}}
                                    @foreach ($users as $user) {{-- Loop through the users --}}
                                        <tr>
                                            <td scope="row">{{ $user->name }}</td>
                                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>

                                            <td> {{-- User options --}}
                                                <a href="" class="text-danger">
                                                    <i class="fas fa-times-circle"></i>
                                                </a>
                                            </td> {{-- /// END user options --}}
                                        </tr>
                                    @endforeach {{-- /// END loop --}}
                                @else {{-- No logins with the permission 'user' are found--}}
                                    {{-- TODO: Create view partial --}}
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }} {{-- User pagination partial view --}}
                </div>
            </div>

            <div class="col-3">
                @include ('users.partials.navigation')
            </div>
        </div>
    </div>
@endsection