<?php

namespace App\Listeners;

use App\Events\ProductSold;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log as FacadesLog;

class SendProductSold
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductSold $event): void
    {
        Log::saveLog('green', "A product ". $event->product->name ." is sold.");
    }
}
