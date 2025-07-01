<div class="flex gap-2 justify-between">
    <!-- LEFT SIDE: Pending Sales -->
    <div class="flex flex-col gap-2 w-1/2" wire:poll.5s>
        @foreach ($sales as $sale)
            <div class="shadow bg-white rounded-lg flex items-center p-2 justify-between">
                <div class="flex flex-col p-3 gap-2">
                    <p class="text-2xl">Sale Id - {{ $sale->id }}</p>
                    <p class="text-lg">Pharmacist: {{ $sale->pharmacist->name ?? 'Unknown' }}</p>
                    <p class="text-lg">{{ $sale->total }} Birr</p>
                </div>
                <button
                    wire:click="displaySale({{ $sale->id }})"
                    class="text-white bg-blue-400 p-3 rounded-lg text-lg"
                >
                    Display
                </button>
            </div>
        @endforeach
    </div>

    <!-- RIGHT SIDE: Sale Details -->
    <div class="p-3 bg-white w-1/3 flex flex-col gap-2 h-max">
        @if ($selectedSale)
            <p class="text-2xl text-center">Sale-{{ $selectedSale->id }}</p>

            @foreach ($selectedSale->items as $item)
                <div class="flex flex-col gap-2">
                    <p class="text-lg font-semibold">{{ $item->product->name ?? 'Unknown Product' }}</p>
                    <span class="ml-4">{{ $item->quantity }} x {{ $item->price }} = {{ $item->quantity * $item->price }}</span>
                </div>
            @endforeach

            <button wire:click="proceedSale" class="bg-blue-500 py-3 px-10 rounded-lg text-white text-lg mt-4 w-max">Proceed</button>
        @else
            <p class="text-lg text-gray-500 text-center">Select a sale to view details</p>
        @endif
    </div>
</div>
