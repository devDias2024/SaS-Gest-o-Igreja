<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

#[Fillable([
    'panel_name',
    'panel_logo',
    'panel_logo_dark',
    'favicon',
    'primary_color',
    'font_family',
    'theme_mode',
    'visual_style',
    'sidebar_width',
    'allow_dark_mode',
    'collapsible_groups',
    'collapsible_sidebar',
    'top_navigation',
])]
class PanelSetting extends Model
{
    public static function current(): self
    {
        if (! Schema::hasTable('panel_settings')) {
            return new self;
        }

        return self::query()->first() ?? new self;
    }

    protected function casts(): array
    {
        return [
            'allow_dark_mode' => 'boolean',
            'collapsible_groups' => 'boolean',
            'collapsible_sidebar' => 'boolean',
            'top_navigation' => 'boolean',
        ];
    }
}
