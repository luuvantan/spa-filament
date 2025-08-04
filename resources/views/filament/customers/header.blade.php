<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-white p-4 border-b border-gray-200 rounded-t-lg">
    <h2 class="text-lg font-semibold text-gray-800">Khách hàng</h2>

    <div class="flex flex-wrap gap-2 items-center">
        {{-- Tìm kiếm --}}
        <input
            type="text"
            wire:model.debounce.500ms="tableSearchQuery"
            placeholder="Tìm kiếm khách hàng theo tên, sđt"
            class="filament-input block w-full md:w-64 text-sm border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
        />

        {{-- Bộ lọc --}}
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
            wire:click="exportTable"
            icon="heroicon-o-arrow-down-tray"
        >
            Xuất dữ liệu
        </x-filament::button>

        {{-- Thêm KH --}}
        <a
            href="{{ $createUrl }}"
            class="filament-button inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-500 text-white font-semibold text-sm py-2 px-4 rounded-md"
        >
            <x-filament::icon name="heroicon-o-plus" class="h-5 w-5" />
            Thêm KH
        </a>
    </div>
</div>
