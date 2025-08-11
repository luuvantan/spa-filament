<div class="space-y-4 p-3">
    <!-- Stats Squares -->

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
                placeholder="Tìm kiếm"
                class="filament-input w-full min-w-[250px] pr-12 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
            />
        </div>
        <div class="w-full">
            <div class="flex flex-wrap gap-2 items-center justify-start md:w-auto relative max-w-fit"
                 x-data="{ open: @entangle('showFilters').defer }"
                 @click.away="open = false"
            >
                <x-filament::button
                    color="gray"
                    icon="heroicon-o-adjustments-horizontal"
                    type="button"
                    @click="open = !open"
                    aria-haspopup="true"
                    aria-expanded="false"
                    class="self-start"
                    wire:click="$dispatch('openRelationManagerFilters')"
                >
                    Lọc

                </x-filament::button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="origin-top-left absolute w-max left-0 mt-2 w-80 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                    style="display: none; top: 40px"
                    wire:key="filters-form"
                >
                    <div class="p-4">
                        {{ $filters }}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row gap-3 w-fit mx-auto">
            <div class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600"
                 style="border-style: dashed;"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate">Tổng chi tiêu</h3>
                <p class="text-sm font-bold text-gray-700 truncate">{{$totalAmount}}</p>
            </div>

            <div class=" w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600"
                 style="border-style: dashed;"
            >
                <h3 class="text-xs font-medium text-gray-500 truncate">Đã hoàn thành</h3>
                <p class="text-sm font-bold text-gray-700 truncate">{{$totalPaid}}</p>
            </div>

            <div class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600"
                 style="border-style: dashed; "
            >
                <h3 class="text-xs font-medium text-gray-500 truncate">Còn nợ</h3>
                <p class="text-sm font-bold text-gray-700 truncate">{{$totalDue}}</p>
            </div>

            <div class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600"
                 style="border-style: dashed; "
            >
                <h3 class="text-xs font-medium text-gray-500 truncate">Lần thanh toán</h3>
                <p class="text-sm font-bold text-gray-700 truncate">{{$paymentTimes}}</p>
            </div>

            <div class="w-28 h-28 flex flex-col justify-center p-1 bg-white rounded-xl shadow-sm border border-primary-600"
                 style="border-style: dashed; "
            >
                <h3 class="text-xs font-medium text-gray-500 truncate">Số hoá đơn</h3>
                <p class="text-sm font-bold text-gray-700 truncate">{{$totalInvoice}}</p>
            </div>
        </div>
    </div>

</div>
