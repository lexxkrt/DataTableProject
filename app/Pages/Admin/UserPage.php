<?php

namespace App\Pages\Admin;

use App\Models\User;
use Modules\DataTable\DataTable;

class UserPage extends DataTable
{
    protected $class = User::class;
}
