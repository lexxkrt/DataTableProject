<?php

namespace Modules\DataTable;

use Illuminate\Support\ServiceProvider;
use Modules\DataTable\Console\Commands\MakePage;

class DataTableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'data-table');
        $this->commands([MakePage::class]);
    }

    public function register() {}
}
