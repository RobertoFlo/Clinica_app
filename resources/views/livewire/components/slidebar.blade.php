<div x-data="{ sidebarIsOpen: @entangle('sidebarIsOpen') }" x-on:click.outside="sidebarIsOpen = false">
    <button class="fixed left-25  top-[6px] z-20 rounded-full  p-4 md:hidden text-white "
        x-on:click="sidebarIsOpen = !sidebarIsOpen">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path
                d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>
    <!-- Barra lateral -->
    <nav x-cloak x-show="sidebarIsOpen" x-trap="sidebarIsOpen"
        class="fixed left-0 z-20 flex h-svh w-80 shrink-0 flex-col  border-outline bg-neutral-800 bg-surface-alt p-4 transition-transform duration-300 text-white"
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 "
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="flex flex-col gap-2 overflow-y-auto pb-6">

            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-medium ">Menu</h3>
                <!-- Botón para cerrar la barra lateral -->
                <button class=" " x-on:click="sidebarIsOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
                        aria-hidden="true">
                        <path
                            d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
                    </svg>
                    <span class="sr-only">close sidebar</span>
                </button>

            </div>
            <div type="button" x-data="{ isExpanded: false }">
                <div class="flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="size-5 shrink-0" aria-hidden="true">
                        <path
                            d="M15.5 2A1.5 1.5 0 0 0 14 3.5v13a1.5 1.5 0 0 0 1.5 1.5h1a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 16.5 2h-1ZM9.5 6A1.5 1.5 0 0 0 8 7.5v9A1.5 1.5 0 0 0 9.5 18h1a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 10.5 6h-1ZM3.5 10A1.5 1.5 0 0 0 2 11.5v5A1.5 1.5 0 0 0 3.5 18h1A1.5 1.5 0 0 0 6 16.5v-5A1.5 1.5 0 0 0 4.5 10h-1Z" />
                    </svg>
                    <span class="text-lg font-medium " x-on:click="isExpanded = ! isExpanded">Mantenimiento</span>
                </div>
                <ul type="button" x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn"
                    id="user-management">
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 ">Alergias</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 ">Permissions</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2  ">ActivityLog</a>
                    </li>
                </ul>
            </div>
        </div>


    </nav>
</div>
