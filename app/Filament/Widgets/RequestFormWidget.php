<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class RequestFormWidget extends Widget
{
    protected static string $view = 'filament.widgets.request-form-widget';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = request()->user()?->role;
        return in_array($user, ['admin', 'user']);
    }
}
