<x-filament-widgets::widget>
    <x-filament::section>
        <form action="{{ url('/requests') }}" method="POST" enctype="multipart/form-data" class="space-y-4 p-4">
            @csrf

            <div>
                <label>Rendszám(ok)</label>
                <input type="text" name="license_plates[]" required class="w-full border rounded p-2">
            </div>

            <div>
                <label >Mettől</label>
                <input type="datetime-local" name="from_date" required class="w-full border rounded p-2">
            </div>

            <div>
                <label>Meddig</label>
                <input type="datetime-local" name="to_date" required class="w-full border rounded p-2">
            </div>

            <div>
                <label>Dolgozók nevei</label>
                <input type="text" name="people[]" required class="w-full border rounded p-2">
            </div>

            <div>
                <label>Helyszín</label>
                <input type="text" name="location" required class="w-full border rounded p-2">
            </div>

            <input type="hidden" name="status" value="Feldolgozás" />

            <div>
                <label>Megjegyzés</label>
                <textarea name="comment" class="w-full border rounded p-2"></textarea>
            </div>

            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded">Beküldés</button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>