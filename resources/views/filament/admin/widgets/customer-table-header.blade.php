<x-filament-widgets::widget>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div class="w-full md:w-auto relative">
            <span class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                </svg>
            </span>
            <input
                type="text"
                wire:model.live.debounce.500ms="search"
                placeholder="Tìm kiếm khách hàng theo tên, sđt"
                class="filament-input w-full min-w-[250px] pr-12 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
            />
        </div>

        <div class="flex flex-wrap gap-2 items-center justify-end w-full md:w-auto">

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
</x-filament-widgets::widget>
