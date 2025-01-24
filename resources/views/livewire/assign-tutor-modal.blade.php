<div>
    <!-- Fondo oscuro del modal -->
    <div 
        x-data="{ open: @entangle('open') }" 
        x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
        x-transition
        style="display: none;"
    >
        <!-- Contenedor del modal -->
        <div class="bg-white w-3/4 max-w-4xl rounded-lg shadow-lg p-6">
            <!-- Encabezado -->
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">Asignar Tutor</h2>
                <button 
                    class="text-gray-500 hover:text-gray-700"
                    @click="open = false"
                >
                    ✖
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mt-4">
                <!-- Botón para agregar tutor -->
                <button 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                    wire:click="toggleAddTutorForm"
                >
                    + Agregar Tutor
                </button>

                <!-- Aquí iría el formulario de agregar tutor -->
                @if ($showAddTutorForm)
                    <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                        <form wire:submit.prevent="saveTutor">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" wire:model="nuevoTutor.ci" placeholder="CI del Tutor" class="form-input w-full">
                                <input type="text" wire:model="nuevoTutor.primer_nombre" placeholder="Primer Nombre" class="form-input w-full">
                                <input type="text" wire:model="nuevoTutor.primer_apellido" placeholder="Primer Apellido" class="form-input w-full">
                                <select wire:model="nuevoTutor.expedido" class="form-select w-full">
                                    <option value="LP">La Paz</option>
                                    <option value="CB">Cochabamba</option>
                                    <option value="SC">Santa Cruz</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Tabla de tutores -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-2">Tutores Asignados</h3>
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">CI</th>
                                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                                <th class="border border-gray-300 px-4 py-2">Activo</th>
                                <th class="border border-gray-300 px-4 py-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tutores as $tutor)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $tutor->ci }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $tutor->primer_nombre }} {{ $tutor->primer_apellido }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <input type="radio" name="activo" {{ $tutor->pivot->activo ? 'checked' : '' }} wire:click="toggleTutorActivo({{ $tutor->id }})">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
