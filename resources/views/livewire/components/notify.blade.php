<div class="fixed top-4 right-4 z-50 flex flex-col gap-2">
    @foreach($notifications as $notification)
        <div x-data="{isVisible:{{ $notification['open'] }},timeout: null,}" x-init="timeout = setTimeout(() => {
                                $wire.removeNotification('{{ $notification['id'] }}');}, 5000);"
            x-show="isVisible" x-transition:enter="transition duration-300 ease-out" x-transition:enter-end="translate-y-0"
            x-transition:enter-start="translate-y-8" x-transition:leave="transition duration-300 ease-in"
            x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
            x-transition:leave-start="translate-x-0 opacity-100"
            class="pointer-events-auto relative rounded-xl text-on-surface
                                                            @if($notification['variant'] === 'success') border-green-300 bg-green-400/50 @endif
                                                            @if($notification['variant'] === 'danger') border-red-400 bg-red-400/80 @endif
                                                            @if($notification['variant'] === 'info') border-blue-400 bg-blue-400/80 @endif
                                                            @if($notification['variant'] === 'warning') border-yellow-400 bg-yellow-400/80 @endif " role="alert">
            <div class="flex w-full items-center gap-2.5   p-4 transition-all duration-300">
                <!-- Icon -->
                @if ($notification['variant'] === 'success')
                    <div class="rounded-full  p-0.5 bg-amber-50/20 text-green-700" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-8"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
                @if ($notification['variant'] === 'info')
                    <svg fill="#000000" width="35px" height="35px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 Z M12,4 C7.581722,4 4,7.581722 4,12 C4,16.418278 7.581722,20 12,20 C16.418278,20 20,16.418278 20,12 C20,7.581722 16.418278,4 12,4 Z M12,10 C12.5522847,10 13,10.4477153 13,11 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,11 C11,10.4477153 11.4477153,10 12,10 Z M12,6 C12.5522847,6 13,6.44771525 13,7 C13,7.55228475 12.5522847,8 12,8 C11.4477153,8 11,7.55228475 11,7 C11,6.44771525 11.4477153,6 12,6 Z" />
                    </svg>
                @endif
                @if ($notification['variant'] === 'danger')
                    <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.95206 16.048L16.0769 7.92297" stroke="#000000" stroke-width="2" />
                        <path d="M16.0914 16.0336L7.90884 7.85101" stroke="#000000" stroke-width="2" />
                        <path
                            d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                            stroke="#000000" stroke-width="2" />
                    </svg>
                @endif
                @if ($notification['variant'] === 'warning')
                    <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 14a1 1 0 0 1-1-1v-3a1 1 0 1 1 2 0v3a1 1 0 0 1-1 1zm-1.5 2.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"
                            fill="#0D0D0D" />
                        <path
                            d="M10.23 3.216c.75-1.425 2.79-1.425 3.54 0l8.343 15.852C22.814 20.4 21.85 22 20.343 22H3.657c-1.505 0-2.47-1.6-1.77-2.931L10.23 3.216zM20.344 20L12 4.147 3.656 20h16.688z"
                            fill="#0D0D0D" />
                    </svg>
                @endif
                <!-- Title & Message -->
                <div class="flex flex-col gap-2">
                    @if($notification['title'])
                        <h3 class="text-sm font-semibold ">{{ $notification['title'] }}</h3>
                    @endif
                    @if($notification['message'])
                        <p class="text-pretty text-sm">{{ $notification['message'] }}</p>
                    @endif
                </div>
                <!--Dismiss Button -->
                <button type="button" class="ml-auto" aria-label="dismiss notification"
                    @click="$wire.removeNotification('{{ $notification['id'] }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none"
                        stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>