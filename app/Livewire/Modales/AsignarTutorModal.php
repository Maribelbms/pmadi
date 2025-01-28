<?php

namespace App\Livewire\Modales;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\EstudianteTutor;
use App\Models\Gestion;
use Livewire\Component;


class AsignarTutorModal extends Component
{
    public $estudianteId;
    public $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $ci_tutor, $expedido_tutor;

    protected $listeners = ['abrirModalAsignarTutor'];

    public $abrirModal = false;

    public function abrirModalAsignarTutor($estudianteId)
    {
        $this->estudianteId = $estudianteId;

        // Lanza el evento con un detalle claro
        $this->dispatchBrowserEvent('openModal', [
            'estudianteId' => $estudianteId,
        ]);
    }



    public function guardarTutor()
    {
        $this->validate([
            'primer_nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'ci_tutor' => 'required|string|max:20',
            'expedido_tutor' => 'required|string',
        ]);

        // Crear el tutor
        $tutor = Tutor::create([
            'primer_nombre_tutor' => $this->primer_nombre,
            'segundo_nombre_tutor' => $this->segundo_nombre,
            'primer_apellido_tutor' => $this->primer_apellido,
            'segundo_apellido_tutor' => $this->segundo_apellido,
            'ci_tutor' => $this->ci_tutor,
            'expedido_tutor' => $this->expedido_tutor,
        ]);

        // Asignar el tutor al estudiante
        EstudianteTutor::create([
            'estudiante_id' => $this->estudianteId,
            'tutor_id' => $tutor->id_tutor,
            'gestion_id' => Gestion::where('estado', 'Activa')->first()->id_gestion,
            'activo' => true,
        ]);

        // Cerrar el modal y mostrar un mensaje de éxito
        $this->dispatchBrowserEvent('cerrar-modal-asignar-tutor'); // Evento JS para cerrar el modal
        session()->flash('success', '¡Tutor asignado correctamente!');
        $this->emit('refreshTable'); // Refrescar la tabla en el recurso
    }

    public function render()
    {
        return view('livewire.modales.asignar-tutor-modal');
    }
}
