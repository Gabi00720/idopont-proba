<div class="space-y-4">
    <div><strong>Rendszám(ok):</strong> {{ is_array($record->license_plates) ? implode(', ', $record->license_plates) : $record->license_plates }}</div>
    <div><strong>Mettől:</strong> {{ $record->from_date?->format('Y-m-d H:i') }}</div>
    <div><strong>Meddig:</strong> {{ $record->to_date?->format('Y-m-d H:i') }}</div>
    <div><strong>Dolgozók:</strong> {{ is_array($record->people) ? implode(', ', $record->people) : $record->people }}</div>
    <div><strong>Helyszín:</strong> {{ $record->location }}</div>
    <div><strong>Megjegyzés:</strong> {{ $record->comment }}</div>
</div>