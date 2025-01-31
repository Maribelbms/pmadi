<x-filament::page>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Subir Archivo Excel</h2>

        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-red-700 bg-red-200 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('upload-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="block w-full p-2 border rounded-lg mb-4" required>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Subir Archivo
            </button>
        </form>
    </div>
</x-filament::page>
