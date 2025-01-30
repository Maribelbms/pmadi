<div class="p-6 bg-gray-900 text-white rounded-lg shadow-lg border border-gray-700 mx-auto w-full max-w-2xl">
    <!-- 🧑 Datos del Estudiante -->
    <h2 class="text-2xl font-semibold flex items-center border-b border-gray-600 pb-3 mb-4">
        📚 Datos del Estudiante
    </h2>

    <div class="space-y-4 text-gray-300">
        <div><span class="font-semibold text-gray-100">👤 Nombre:</span> {{ $estudiante->primer_nombre ?? 'N/A' }} {{ $estudiante->segundo_nombre ?? '' }}</div>
        <div><span class="font-semibold text-gray-100">📝 Apellidos:</span> {{ $estudiante->primer_apellido ?? 'N/A' }} {{ $estudiante->segundo_apellido ?? '' }}</div>
        <div><span class="font-semibold text-gray-100">📄 CI:</span> {{ $estudiante->ci ?? 'N/A' }}</div>
        <div><span class="font-semibold text-gray-100">📚 Curso:</span> 
            {{ $estudiante->curso == 1 ? 'PRIMERA SECCIÓN' : ($estudiante->curso == 2 ? 'SEGUNDA SECCIÓN' : 'SIN ASIGNACIÓN') }}
        </div>
        <div><span class="font-semibold text-gray-100">🏫 Paralelo:</span> {{ $estudiante->paralelo ?? 'N/A' }}</div>
        <div><span class="font-semibold text-gray-100">📑 RUDE:</span> {{ $estudiante->rude ?? 'N/A' }}</div>
        <div><span class="font-semibold text-gray-100">📊 Asistencia:</span> {{ $estudiante->porcentaje_asistencia ?? 'N/A' }}%</div>
        <div><span class="font-semibold text-gray-100">📍 Expedido en: </span>{{ $estudiante->expedido ?? 'N/A'}}</div>
        <div>
            <span class="font-semibold text-gray-100">✅ Habilitado:</span> 
            <span class="px-3 py-1 text-white text-sm rounded-lg font-bold 
                {{ $estudiante->habilitado == 'si' ? 'bg-green-600' : 'bg-red-600' }}">
                {{ $estudiante->habilitado == 'si' ? 'Sí' : 'No' }}
            </span>
        </div>
        <div><span class="font-semibold text-gray-100">⚧️ Sexo:</span> 
            {{ $estudiante->sexo == 'M' ? 'Masculino' : ($estudiante->sexo == 'F' ? 'Femenino' : 'N/A') }}
        </div>
    </div>

    <!-- 👨‍🏫 Datos del Tutor -->
    <h2 class="text-2xl font-semibold flex items-center border-b border-gray-600 pb-3 mt-6 mb-4">
        🏠 Datos del Tutor
    </h2>

    @if($estudiante->tutor)
        <div class="space-y-4 text-gray-300">
            <div><span class="font-semibold text-gray-100">👤 Nombre Completo:</span> {{ $estudiante->tutor->primer_nombre_tutor ?? 'N/A' }} {{ $estudiante->tutor->segundo_nombre_tutor ?? '' }}</div>
            <div><span class="font-semibold text-gray-100">📝 Apellidos:</span> {{ $estudiante->tutor->primer_apellido_tutor ?? 'N/A' }} {{ $estudiante->tutor->segundo_apellido_tutor ?? '' }} {{ $estudiante->tutor->tercer_apellido_tutor ?? '' }}</div>
            <div><span class="font-semibold text-gray-100">📄 CI:</span> {{ $estudiante->tutor->ci_tutor ?? 'N/A' }}</div>
            <div><span class="font-semibold text-gray-100">📍 Expedido en:</span> {{ $estudiante->tutor->expedido_tutor ?? 'N/A' }}</div>
        </div>
    @else
        <p class="text-gray-400 italic text-center mt-4">🔍 No hay tutor asignado.</p>
    @endif
</div>
