<?php

namespace App\Pages\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::admin')]
class HomePage extends Component
{
    public function render()
    {
        return view('pages::admin.home-page');
    }
}
