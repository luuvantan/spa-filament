<div class="flex flex-wrap items-center justify-between gap-2 mb-2">
    <div class="flex flex-1 items-center gap-2">
        <input
            placeholder="Tìm kiếm khách hàng theo tên, sđt"
            class="filament-input rounded-md w-80"
        />
        <x-filament::button icon="heroicon-m-adjustments-horizontal" color="gray" size="sm">
            Lọc
        </x-filament::button>
        <x-filament::button icon="heroicon-m-arrow-down-tray" color="gray" size="sm">
            Xuất dữ liệu
        </x-filament::button>
    </div>

    {{-- <x-filament::button icon="heroicon-m-plus" color="primary" size="sm" tag="a" :href="{{ $createUrl }}">
        Thêm KH
    </x-filament::button> --}}
</div>
