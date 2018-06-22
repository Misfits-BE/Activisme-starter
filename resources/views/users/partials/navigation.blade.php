<div class="list-group">
    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-users fa-fw mr-1"></i> Users Overview
    </a>

    <a href="{{ route('admin.users.create') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-fw mr-1 fa-user-plus"></i> {{ __('starter-translations::users.add-user') }}
    </a>
</div>