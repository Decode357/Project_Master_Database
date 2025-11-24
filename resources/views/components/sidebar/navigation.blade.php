@php
    $user = Auth::user();
    $hasFileImport = $user->getDirectPermissions()->pluck('name')->contains('file import');
@endphp

<nav class="flex flex-col gap-1 shadow-sm px-4">
    <x-sidebar.nav-item route="dashboard" icon="home" :label="__('sidebar.dashboard')" />

    <!-- Shape Section -->
    <div class="space-y-1">
        <x-sidebar.nav-item route="shape.index" icon="shapes" :label="__('sidebar.shapes')" />
        <x-sidebar.nav-item route="shape.collection.index" icon="collections_bookmark" 
            :label="__('sidebar.collections')" :isChild="true" />
    </div>

    <!-- Glaze Section -->
    <div class="space-y-1">
        <x-sidebar.nav-item route="glaze.index" icon="water_drop" :label="__('sidebar.glazes')" />
        <x-sidebar.nav-item route="glaze.inside.outer.index" icon="opacity" 
            :label="__('sidebar.glaze_inside_outer')" :isChild="true" />
        <x-sidebar.nav-item route="effect.index" icon="auto_awesome" 
            :label="__('sidebar.effects')" :isChild="true" />
        <x-sidebar.nav-item route="color.index" icon="palette" 
            :label="__('sidebar.colors')" :isChild="true" />
    </div>

    <x-sidebar.nav-item route="pattern.index" icon="border_color" :label="__('sidebar.patterns')" />
    <x-sidebar.nav-item route="backstamp.index" icon="verified" :label="__('sidebar.backstamps')" />

    @role('admin|superadmin')
        <hr class="my-2 border-gray-300 dark:border-gray-600" />
        <span class="text-center text-sm text-gray-400 dark:text-gray-500">{{ __('sidebar.admin_console') }}</span>

        <x-sidebar.nav-item route="item.group.index" icon="workspaces" :label="__('sidebar.shape_groups')" />
        <x-sidebar.nav-item route="customer.index" icon="business" :label="__('sidebar.customers')" />
        <x-sidebar.nav-item route="user" icon="group" :label="__('sidebar.user_management')" />

        @if ($hasFileImport)
            <x-sidebar.nav-item route="csvImport" icon="cloud_upload" :label="__('sidebar.csv_import')" />
        @endif
    @endrole
</nav>