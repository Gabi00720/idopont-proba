<div class="space-y-2 text-sm text-gray-700">
    <p><strong>Felhasználó:</strong> {{ optional($request->user)->name }}</p>
    <p><strong>Helyszín:</strong> {{ $request->location }}</p>
    <p><strong>Mettől:</strong> {{ $request->from_date->format('Y-m-d H:i') }}</p>
    <p><strong>Meddig:</strong> {{ $request->to_date->format('Y-m-d H:i') }}</p>
    <p><strong>Rendszám(ok):</strong> {{ is_array($request->license_plates) ? implode(', ', $request->license_plates) : $request->license_plates }}</p>
    <p><strong>Dolgozók neve:</strong> {{ is_array($request->people) ? implode(', ', $request->people) : $request->people }}</p>
    <p><strong>Megjegyzés:</strong> {{ $request->comment ?? '—' }}</p>
    <p><strong>Dokumentum:</strong>
        @if ($request->document_path)
            <a href="{{ Storage::url($request->document_path) }}" target="_blank" class="text-blue-600 underline">Megtekintés</a>
        @else
            Nincs feltöltve
        @endif
    </p>
</div>