<div>
    @if ($showLoader)
    <div  class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-40">
        <div class="flex flex-row gap-2">
            <div class="w-4 h-4 rounded-full bg-blue-700 animate-bounce"></div>
            <div class="w-4 h-4 rounded-full bg-blue-700 animate-bounce [animation-delay:-.3s]"></div>
            <div class="w-4 h-4 rounded-full bg-blue-700 animate-bounce [animation-delay:-.5s]"></div>
        </div>
    </div>
    @endif
</div>