<div>
    <div x-data="{ abierto: false }" @abrir-modal-asignar-tutor.window="abierto = true" @cerrar-modal-asignar-tutor.window="abierto = false">
        <div x-show="abierto" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="abierto" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold">Asignar Tutor</h2>

                <form wire:submit.prevent="guardarTutor">
                    <div class="mt-4">
                        <label for="primer_nombre" class="block text-sm font-medium text-gray-700">Primer Nombre</label>
                        <input type="text" id="primer_nombre" wire:model="primer_nombre" class="form-input w-full">
                        @error('primer_nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                        <input type="text" id="primer_apellido" wire:model="primer_apellido" class="form-input w-full">
                        @error('primer_apellido') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <!-- Otros campos para el tutor -->

                    <div class="mt-6 flex justify-end">
                        <button type="button" @click="abierto = false" class="btn btn-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
