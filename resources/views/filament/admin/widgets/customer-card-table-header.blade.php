<x-filament-widgets::widget>
    <div class="space-y-4">
        <!-- Stats Squares -->
        <div class="flex flex-row gap-3 w-fit mx-auto">
            <div wire:click="loadCustomer('all')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'all' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Số khách hàng dùng thẻ</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $totalCustomers }}</p>
            </div>

            <div wire:click="loadCustomer('new_today')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'new_today' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Tổng giá trị trong thẻ tiền</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $totalPriceTheTien }}</p>
            </div>

            <div wire:click="loadCustomer('today_birthdays')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'today_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Tổng giá trị trong thẻ lần</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $totalPriceTheLieuTrinh }}</p>
            </div>

            <div wire:click="loadCustomer('week_birthdays')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'week_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Thẻ sắp hết hạn trong hôm nay</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $expiringToday }}</p>
            </div>

            <div wire:click="loadCustomer('month_birthdays')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'month_birthdays' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Thẻ sắp hết hạn trong 7 ngày tới</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $expiring7Day }}</p>
            </div>
            <div wire:click="loadCustomer('expiring_3_month')" class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600 cursor-pointer"
                 style="border-style: dashed; {{ $selectedStat === 'expiring_3_month' ? 'background-color: #BCF328; color: #454545;' : '' }}"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate text-center">Thẻ sắp hết hạn trong 3 tháng tới</h3>
                <p class="text-lg font-bold text-gray-900 truncate">{{ $expiring3Month }}</p>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
