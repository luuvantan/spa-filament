

@if ($paginator->hasPages())
    <div class="flex items-center justify-between px-4 py-3 border-t border-gray-200 text-sm text-gray-700">
        <div class="flex items-center gap-2">
            <span>The page on</span>

            <select wire:model="page"
                    class="border rounded px-2 py-1 text-sm"
                    onchange="Livewire.emit('gotoPage', this.value)">
                @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                    <option value="{{ $page }}">{{ $page }}</option>
                @endfor
            </select>
        </div>

        <div class="flex items-center gap-2">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-2 py-1 text-gray-400 cursor-not-allowed">‹</span>
            @else
                <button wire:click="previousPage" class="px-2 py-1 hover:bg-gray-100 border rounded">‹</button>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="px-2 py-1 hover:bg-gray-100 border rounded">›</button>
            @else
                <span class="px-2 py-1 text-gray-400 cursor-not-allowed">›</span>
            @endif
        </div>
    </div>
@endif
