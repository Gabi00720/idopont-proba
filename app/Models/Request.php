<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\CalendarEvent;

class Request extends Model implements Eventable
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_plates',
        'from_date',
        'to_date',
        'people',
        'location',
        'status',
        'comment',
        'document_path',
    ];

    protected $casts = [
        'license_plates' => 'array',
        'people' => 'array',
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toCalendarEvent(): CalendarEvent
    {
        return CalendarEvent::make($this)
            ->title($this->user->name . ' – ' . $this->location)
            ->start($this->from_date)
            ->end($this->to_date)
            ->action('view');
    }
}
