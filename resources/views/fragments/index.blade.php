@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12"> {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> {{ __('starter-translations::breadcrumb.dashboard') }} </a>
                        <li class="breadcrumb-item active">{{ __('starter-translations::fragments.titles.overview') }}</li>
                    </ol>
                </nav>
            </div> {{-- /// END breadcrumb --}}

            <div class="col-12"> {{-- Fragment content --}}
                <div class="card card-body">
                    <h6 class="border-bottom border-gray pb-2 mb-3">{{ __('starter-translations::fragments.titles.overview') }}</h6>

                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th scope="col" class="border-top-0">{{ __('starter-translations::fragments.table.last-editor') }}</th>
                                <th scope="col" class="border-top-0">{{ __('starter-translations::fragments.table.page') }}</th>
                                <th scope="col" class="border-top-0">{{ __('starter-translations::fragments.table.title') }}</th>
                                <th scope="col" colspan="2" class="border-top-0">{{ __('starter-translations::fragments.table.last-edited') }}</th>
                            </th>
                        </thead>

                        <body>
                            @forelse($fragments as $fragment) {{-- Page fragments are found --}}
                                <tr>
                                    <td>{{ $fragment->editor->name }}</td>
                                    <td>{{ $fragment->page }}</td>
                                    <td>{{ $fragment->title }}</td>
                                    <td>{{ $fragment->updated_at->diffForHumans() }}</td>

                                    <td> {{-- Options --}}
                                        <span class="pull-right">
                                            <a class="text-muted mr-2" href="{{ url($fragment->slug) }}">
                                                <i class="far fa-fw fa-eye"></i> {{ __('starter-translations::fragments.table.buttons.view') }}
                                            </a>

                                            <a class="text-muted" href="">
                                                <i class="far fa-fw fa-edit"></i> {{ __('starter-translations::fragments.table.buttons.edit') }}
                                            </a>
                                        </span>
                                    </td> {{-- /// Options --}}
                                </tr>
                            @empty {{-- Page page fragments are found --}}
                                <tr>
                                    <td colspan="5">
                                        <span class="text-muted">
                                            ({{ __('starter-translations::fragments.table.no-results') }})
                                        </span>
                                    </td>
                                </tr>
                            @endforelse
                        </body>
                    </table>

                    {{ $fragments->links() }} {{-- Page fragment partial view (pagination) --}}
                </div>
            </div>
        </div>
    </div>
@endsection