<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['menu_date', 'meal_type', 'title', 'items', 'notes'])]
class DiningMenu extends Model
{
    protected function casts(): array
    {
        return ['menu_date' => 'date'];
    }
}
