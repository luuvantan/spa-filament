<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
    <div class="flex flex-wrap gap-2 items-center">
        <input
            type="text"
            wire:model.debounce.500ms="tableSearchQuery"
            placeholder="Tìm kiếm khách hàng theo tên, sđt"
            class="filament-input w-64 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
        />

        {{-- Button lọc --}}
        <x-filament::button
            color="gray"
            icon="heroicon-o-adjustments-horizontal"
            wire:click="$toggle('isTableFiltersMenuOpen')"
        >
            Lọc
        </x-filament::button>

        {{-- Xuất dữ liệu --}}
        <x-filament::button
            color="gray"
            icon="heroicon-o-arrow-down-tray"
            wire:click="exportTable"
        >
            Xuất dữ liệu
        </x-filament::button>

        {{-- Thêm KH --}}
        <x-filament::button
            tag="a"
            href="{{ \App\Filament\Admin\Resources\CustomerResource::getUrl('create') }}"
            icon="heroicon-o-plus"
        >
            Thêm KH
        </x-filament::button>
    </div>
</div>
