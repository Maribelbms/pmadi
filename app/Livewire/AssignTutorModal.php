<?php

namespace App\Livewire;

use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\EstudianteTutor;
use Livewire\Component;

class AssignTutorModal extends Component
{
    public $open = false;
    public $estudiante;
    public $tutores; // Lista de tutores asignados al estudiante
    protected $listeners = ['showAssignTutorModal' => 'openModal'];
    public $nuevoTutor = [
        'ci' => '',
        'primer_nombre' => '',
        'primer_apellido' => '',
        'expedido' => '',
    ];
    public $showAddTutorForm = false;
    public function mount(Estudiante $estudiante)
    {
        $this->estudiante = $estudiante;
        $this->tutores = $this->estudiante->tutores()->withPivot('activo')->get();
    }
    public function openModal($estudianteId)
    {
        $this->estudiante = Estudiante::findOrFail($estudianteId);
        $this->tutores = $this->estudiante->tutores()->withPivot('activo')->get();
        $this->open = true;
    }
    public function closeModal()
    {
        $this->open = false; // Cierra el modal
    }

    public function toggleAddTutorForm()
    {
        $this->showAddTutorForm = !$this->showAddTutorForm;
    }

    public function saveTutor()
    {
        $validated = $this->validate([
            'nuevoTutor.ci' => 'required|max:20',
            'nuevoTutor.primer_nombre' => 'required|max:50',
            'nuevoTutor.primer_apellido' => 'required|max:50',
            'nuevoTutor.expedido' => 'required|max:5',
        ]);

        // Crear tutor
        $tutor = Tutor::create($validated['nuevoTutor']);

        // Asignar tutor al estudiante con estado inactivo
        $this->estudiante->tutores()->attach($tutor->id, ['activo' => false]);

        $this->tutores = $this->estudiante->tutores()->withPivot('activo')->get();
        $this->nuevoTutor = [];
        $this->showAddTutorForm = false;

        session()->flash('message', 'Tutor agregado exitosamente.');
    }

    public function toggleTutorActivo($tutorId)
    {
        foreach ($this->tutores as $tutor) {
            $this->estudiante->tutores()->updateExistingPivot($tutor->id, [
                'activo' => $tutor->id == $tutorId,
            ]);
        }

        $this->tutores = $this->estudiante->tutores()->withPivot('activo')->get();
    }

    public function render()
    {
        return view('livewire.assign-tutor-modal');
    }
}
