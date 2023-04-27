<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StudentsComponent extends Component
{
    public $student_id, $name, $email, $phone;

    // Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'student_id' => 'required|unique:students',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ]);
    }
    public function storeStudentData()
    {
        $this->validate([
            'student_id' => 'required|unique:students',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ]);
    }
    public function render()
    {
        return view('livewire.students-component')->layout('livewire.layouts.base');
    }
}
