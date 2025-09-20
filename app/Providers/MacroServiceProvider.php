<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Carbon::macro('frontEndFormat', function () {
            /**
             * @var Carbon $this
             */
            return [
                'value' => $this->toDateTimeString(),
                'human' => $this->diffForHumans(),
            ];
        });
    }
}
