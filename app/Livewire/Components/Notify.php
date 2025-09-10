<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Notify extends Component
{
    public $notifications = [];

    #[On('notify')]
    public function addNotification($data)
    {
        $this->notifications[] = [
            'open'=> true,
            'id' => uniqid(),
            'title' => $data['title'] ?? '',
            'message' => $data['message'] ?? '',
            'variant' => $data['variant'] ?? 'info',
        ];
    }
    
    public function removeNotification($id)
    {
        $this->notifications = array_filter($this->notifications, fn($n) => $n['id'] !== $id);
    }
    public function render()
    {
        return view('livewire.components.notify');
    }
}
