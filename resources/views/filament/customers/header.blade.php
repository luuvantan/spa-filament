<div class="flex items-center justify-between w-full px-2 py-2">
    {{-- Search box --}}
    <div class="flex-1 max-w-md">
        <x-filament::input.wrapper>
            <x-filament::input
                wire:model.debounce.500ms="tableSearch"
                placeholder="Tìm kiếm khách hàng theo tên, sđt"
                type="search"
            />
        </x-filament::input.wrapper>
    </div>

    {{-- Buttons --}}
    <div class="flex items-center gap-2">
        <x-filament::button color="gray">
            Xuất dữ liệu
        </x-filament::button>

        <x-filament::button color="primary" tag="a" href="{{ route('filament.admin.resources.customers.create') }}">
            <x-heroicon-o-plus class="w-4 h-4 mr-1"/>
            Thêm KH
        </x-filament::button>
    </div>
</div>
