<x-filament-widgets::widget>
    <div class="space-y-4">
        <!-- Stats Squares -->
        <div class="flex flex-row gap-3 w-fit mx-auto">
            <div wire:click="loadCustomer('all')" class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'all' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Tổng số khách hàng</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $totalCustomers }}</p>
            </div>

            <div wire:click="loadCustomer('new_today')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'new_today' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Khách hàng mới hôm nay</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $newCustomers }}</p>
            </div>

            <div wire:click="loadCustomer('today_birthdays')" class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'today_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Khách hàng sinh nhật hôm nay</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $todayBirthdays }}</p>
            </div>

            <div wire:click="loadCustomer('week_birthdays')" class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'week_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Khách hàng sinh nhật tuần này</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $weekBirthdays }}</p>
            </div>

            <div wire:click="loadCustomer('month_birthdays')" class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'month_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Khách hàng sinh nhật tháng này</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $monthBirthdays }}</p>
            </div>
        </div>

        <!-- Existing Search and Action Buttons -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 bg-white rounded-lg">
            <div class="w-full md:w-auto relative">
                <span class="absolute inset-y-0 flex items-center pointer-events-none text-gray-400" style="right: 14px">
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
                <x-filament::button
                    color="gray"
                    icon="heroicon-o-adjustments-horizontal"
                    wire:click="toggleTableFilters"
                >
                    Lọc
                </x-filament::button>

                <x-filament::button
                    color="gray"
                    icon="heroicon-o-arrow-down-tray"
                    wire:click="$dispatch('exportTable')"
                >
                    Xuất dữ liệu
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ \App\Filament\Admin\Resources\CustomerResource::getUrl('create') }}"
                    icon="heroicon-o-plus"
                >
                    Thêm KH
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
