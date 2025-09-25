<div>
    @livewire('components.titulo', ['titulo'=> 'Dashboard'])
    <div wire:poll.1s>
        <h1 class="text-[60px] text-center">{{ now()->tz('America/El_Salvador')->format('h:i:s A') }}</h1>
    </div>
</div>