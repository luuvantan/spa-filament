<x-filament-panels::page>
    {{-- Badge thống kê --}}
    <div class="flex gap-4 mb-6">
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-bold">
            Tổng số khách hàng {{ $total }}
        </div>
        <div class="bg-gray-100 px-4 py-2 rounded-lg">
            Khách hàng mới hôm nay {{ $today }}
        </div>
        <div class="bg-gray-100 px-4 py-2 rounded-lg">
            Khách hàng sinh nhật hôm nay {{ $birthday_today }}
        </div>
        <div class="bg-gray-100 px-4 py-2 rounded-lg">
            Khách hàng sinh nhật tuần này {{ $birthday_week }}
        </div>
        <div class="bg-gray-100 px-4 py-2 rounded-lg">
            Khách hàng sinh nhật tháng này {{ $birthday_month }}
        </div>
    </div>

    {{-- Search + Actions trên cùng một dòng --}}
    <div class="flex items-center justify-between gap-4 mb-4">
        <div class="flex-1 max-w-lg">
            <x-filament::input.wrapper>
                <x-filament::input
                    wire:model.debounce.500ms="tableSearch"
                    placeholder="Tìm kiếm khách hàng theo tên, sđt"
                    type="search"
                    class="w-full"
                />
            </x-filament::input.wrapper>
        </div>

        <div class="flex items-center gap-2">
            <x-filament::button color="gray">Lọc</x-filament::button>
            <x-filament::button color="gray">Xuất dữ liệu</x-filament::button>
            <x-filament::button color="primary"
                tag="a"
                href="{{ route('filament.admin.resources.customers.create') }}">
                <x-heroicon-o-plus class="w-4 h-4 mr-1"/>
                Thêm KH
            </x-filament::button>
        </div>
    </div>

    {{-- Table --}}
    {{ $this->table }}
</x-filament-panels::page>
