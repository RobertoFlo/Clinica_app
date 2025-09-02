<div x-data="{ sidebarIsOpen: @entangle('sidebarIsOpen') }" class="">
    <button class="fixed left-25  top-[6px] z-20 rounded-full  p-4 md:hidden" wire:click="toggleSidebar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
            aria-hidden="true">
            <path
                d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>
    <!-- Barra lateral -->
    <nav x-cloak x-show="sidebarIsOpen" x-trap="sidebarIsOpen"
        class="fixed left-0 z-20 flex h-svh w-80 shrink-0 flex-col  border-outline bg-white bg-surface-alt p-4 transition-transform duration-300 shadow-xl border-r-1 border-gray-100"
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 "
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="flex flex-col gap-2 overflow-y-auto pb-6 ">

            <div class="flex items-center justify-between ">
                <h3 class="text-2xl font-medium ">Menu</h3>
                <!-- Botón para cerrar la barra lateral -->
                <div class="flex justify-center bg-red-300 rounded-full px-2 py-2">
                    <button class="hover:cursor-pointer  bg-red-600  text-white rounded-full px-1 py-1"
                        wire:click="toggleSidebar">
                        <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                            <path
                                d="M8,19a3,3,0,0,1-3-3V8A3,3,0,0,1,8,5,1,1,0,0,0,8,3,5,5,0,0,0,3,8v8a5,5,0,0,0,5,5,1,1,0,0,0,0-2Zm7.71-3.29a1,1,0,0,0,0-1.42L13.41,12l2.3-2.29a1,1,0,0,0-1.42-1.42L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0ZM16,3a1,1,0,0,0,0,2,3,3,0,0,1,3,3v8a3,3,0,0,1-3,3,1,1,0,0,0,0,2,5,5,0,0,0,5-5V8A5,5,0,0,0,16,3Z" />
                        </svg>
                    </button>
                </div>

            </div>
            <div type="button" x-data="{ isExpanded: false }">
                <div class="flex flex-row items-center gap-2 hover:cursor-pointer"
                    x-on:click="isExpanded = ! isExpanded">
                    <svg fill="#000000" height="20px" width="20px" version="1.1" id="Icons"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 32 32" xml:space="preserve">
                        <g>
                            <path
                                d="M16,9c-2.2,0-4,1.8-4,4c0,1.9,1.3,3.4,3,3.9V29c0,0.6,0.4,1,1,1s1-0.4,1-1V16.9c1.7-0.4,3-2,3-3.9C20,10.8,18.2,9,16,9z" />
                            <path
                                d="M6,18c-2.2,0-4,1.8-4,4c0,1.9,1.3,3.4,3,3.9V29c0,0.6,0.4,1,1,1s1-0.4,1-1v-3.1c1.7-0.4,3-2,3-3.9C10,19.8,8.2,18,6,18z" />
                            <path
                                d="M30,16c0-2.2-1.8-4-4-4s-4,1.8-4,4c0,1.9,1.3,3.4,3,3.9V29c0,0.6,0.4,1,1,1s1-0.4,1-1v-9.1C28.7,19.4,30,17.9,30,16z" />
                            <path d="M6,17c0.6,0,1-0.4,1-1V3c0-0.6-0.4-1-1-1S5,2.4,5,3v13C5,16.6,5.4,17,6,17z" />
                            <path d="M16,8c0.6,0,1-0.4,1-1V3c0-0.6-0.4-1-1-1s-1,0.4-1,1v4C15,7.6,15.4,8,16,8z" />
                            <path d="M26,11c0.6,0,1-0.4,1-1V3c0-0.6-0.4-1-1-1s-1,0.4-1,1v7C25,10.6,25.4,11,26,11z" />
                        </g>
                    </svg>
                    <span class="text-lg font-medium hover:text-shadow-lg/20">Mantenimiento</span>
                </div>
                <ul type="button" x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn"
                    id="user-management">
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/alergias" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 hover:text-shadow-lg/20">Alergias</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/tipo-examenes" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 hover:text-shadow-lg/20">Tipos de Examen</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2  hover:text-shadow-lg/20">ActivityLog</a>
                    </li>
                </ul>
            </div>
        </div>


    </nav>
</div>