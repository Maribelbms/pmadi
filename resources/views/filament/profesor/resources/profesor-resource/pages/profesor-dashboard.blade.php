<x-filament::page>
    <div class="grid grid-cols-2 gap-4">
        <x-filament::card>
            <h2 class="text-xl font-bold">Estudiantes Registrados</h2>
            <p class="text-lg font-semibold">{{ $this->getStats()['totalEstudiantes'] }}</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-xl font-bold">Estudiantes con Tutor</h2>
            <p class="text-lg font-semibold">{{ $this->getStats()['estudiantesConTutor'] }}</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-xl font-bold">Estudiantes sin Tutor</h2>
            <p class="text-lg font-semibold">{{ $this->getStats()['estudiantesSinTutor'] }}</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-xl font-bold">Niños Registrados</h2>
            <p class="text-lg font-semibold">{{ $this->getStats()['totalNiños'] }}</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-xl font-bold">Niñas Registradas</h2>
            <p class="text-lg font-semibold">{{ $this->getStats()['totalNiñas'] }}</p>
        </x-filament::card>
    </div>
</x-filament::page>
