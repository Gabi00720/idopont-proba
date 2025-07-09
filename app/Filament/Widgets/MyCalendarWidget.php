<?php

namespace App\Filament\Widgets;

use Guava\Calendar\Widgets\CalendarWidget as BaseCalendar;
use App\Models\Request;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Illuminate\Support\Collection;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;

class MyCalendarWidget extends BaseCalendar
{
    protected static ?int $sort = 2;

    protected ?string $locale = 'hu';

    public static function canView(): bool
    {
        $user = request()->user()?->role;
        return in_array($user, ['admin', 'manager']);
    }

    protected function view(): View
    {
        return view('filament.widgets.modals.request-details', [
            'record' => $this->record,
        ]);
    }

    public function getEvents(array $fetchInfo = []): array
    {
        return Request::where('status', 'Elfogadva')->get()->all();
    }
}
