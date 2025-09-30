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
        <div class="flex flex-col gap-2 overflow-y-auto pb-6  space-y-3">

            <div class="flex items-center justify-between ">
                <h3 class="text-2xl font-medium ">Menu</h3>
                <!-- Botón para cerrar la barra lateral -->
                <div class="flex justify-center bg-red-300 rounded-full px-2 py-2">
                    <button class="hover:cursor-pointer  bg-red-600  text-white rounded-full border-red-600 px-1 py-1"
                        wire:click="toggleSidebar">
                        <svg fill="#ffff" width="20px" height="20px" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                            <path
                                d="M8,19a3,3,0,0,1-3-3V8A3,3,0,0,1,8,5,1,1,0,0,0,8,3,5,5,0,0,0,3,8v8a5,5,0,0,0,5,5,1,1,0,0,0,0-2Zm7.71-3.29a1,1,0,0,0,0-1.42L13.41,12l2.3-2.29a1,1,0,0,0-1.42-1.42L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0ZM16,3a1,1,0,0,0,0,2,3,3,0,0,1,3,3v8a3,3,0,0,1-3,3,1,1,0,0,0,0,2,5,5,0,0,0,5-5V8A5,5,0,0,0,16,3Z" />
                        </svg>
                    </button>
                </div>

            </div>
            <div class="flex flex-row items-center gap-2 hover:cursor-pointer" href="/usuarios" wire:navigate>
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M111.13672,158.97681a56.00028,56.00028,0,1,0-46.27246-.00025,92.23328,92.23328,0,0,0-52.13867,36.11719,3.99985,3.99985,0,1,0,6.541,4.60547A84.01746,84.01746,0,0,1,156.73,199.69434a4.00014,4.00014,0,0,0,6.541-4.60645A92.23237,92.23237,0,0,0,111.13672,158.97681ZM40.00049,108a48,48,0,1,1,48,48A48.05436,48.05436,0,0,1,40.00049,108Zm203.82519,92.66162a3.99923,3.99923,0,0,1-5.57373-.96728A84.17363,84.17363,0,0,0,169.522,164a4,4,0,0,1,0-8,48,48,0,1,0-13.02636-94.2124,4,4,0,1,1-2.166-7.70117A55.99661,55.99661,0,0,1,192.6582,158.97681,92.23507,92.23507,0,0,1,244.793,195.08789,4.0002,4.0002,0,0,1,243.82568,200.66162Z" />
                </svg>
                <span class="text-lg font-medium ">Usuarios</span>
            </div>
            <div type="button" x-data="{ isExpanded: false }">
                <div class="flex flex-row items-center gap-2 hover:cursor-pointer"
                    x-on:click="isExpanded = ! isExpanded">
                    <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256.00098 256.00098" id="Flat" xmlns="http://www.w3.org/2000/svg">
                        <path d="M132,64.3396V39.99988a4,4,0,1,0-8,0V64.3396a23.99522,23.99522,0,0,0,0,47.32056V215.99988a4,4,0,0,0,8,0V111.66016a23.99522,23.99522,0,0,0,0-47.32056Zm-4,39.66028a16,16,0,1,1,16-16A16.01833,16.01833,0,0,1,128,103.99988Zm96,64a24.03441,24.03441,0,0,0-20-23.66028l.001-104.33972a4,4,0,1,0-8,0L196,144.3396a23.99529,23.99529,0,0,0,0,47.32068l.001,24.3396a4,4,0,0,0,8,0L204,191.66016A24.03443,24.03443,0,0,0,224,167.99988Zm-24,16a16,16,0,1,1,16-16A16.01833,16.01833,0,0,1,200,183.99988ZM60,112.3396l-.00049-72.33972a4,4,0,0,0-8,0L52,112.3396a23.99522,23.99522,0,0,0,0,47.32056l-.00049,56.33972a4,4,0,0,0,8,0L60,159.66016a23.99522,23.99522,0,0,0,0-47.32056Zm-4,39.66028a16,16,0,1,1,16-16A16.01833,16.01833,0,0,1,56,151.99988Z" />
                    </svg>
                    <span class="text-lg font-medium ">Mantenimiento</span>
                </div>
                <ul type="button" x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn"
                    id="user-management">
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/alergias" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 ">Alergias</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/tipo-examenes" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2 ">Tipos
                            de Examen</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/tipo-consultas" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2  ">Tipos
                            de Consultas</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="/medicos" wire:navigate
                            class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-md  underline-offset-2  ">Médicos</a>
                    </li>
                </ul>

            </div>
            <div class="flex flex-row items-center gap-2 hover:cursor-pointer" href="/expediente" wire:navigate>
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M216,76H129.3335L100.5332,54.40015A12.07358,12.07358,0,0,0,93.3335,52H40A12.01359,12.01359,0,0,0,28,64V200a12.01375,12.01375,0,0,0,12,12H216a12.01375,12.01375,0,0,0,12-12V88A12.01359,12.01359,0,0,0,216,76ZM36,64a4.00458,4.00458,0,0,1,4-4H93.3335a4.0251,4.0251,0,0,1,2.3999.8L121.333,80,95.7334,99.2a4.0251,4.0251,0,0,1-2.3999.8H36ZM220,200a4.00458,4.00458,0,0,1-4,4H40a4.00458,4.00458,0,0,1-4-4V108H93.3335a12.07358,12.07358,0,0,0,7.1997-2.40015L129.3335,84H216a4.00458,4.00458,0,0,1,4,4Z" />
                </svg>
                <span class="text-lg font-medium ">Expediente</span>
            </div>
            <div class="flex flex-row items-center gap-2 hover:cursor-pointer" href="/citas" wire:navigate>
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M181.12207,108l46.001-57.501A3.99977,3.99977,0,0,0,224,44H40a4.0002,4.0002,0,0,0-4,4V216a4,4,0,0,0,8,0V172H224a3.99977,3.99977,0,0,0,3.12305-6.499ZM44,164V52H215.67773L172.877,105.501a4,4,0,0,0,0,4.998L215.67773,164Z" />
                </svg>
                <span class="text-lg font-medium ">Citas</span>
            </div>
            <div class="flex flex-row items-center gap-2 hover:cursor-pointer" href="/clinica" wire:navigate>
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M210.82861,69.17139l-40-40A4.00116,4.00116,0,0,0,168,28H88A12.01375,12.01375,0,0,0,76,40V60H56A12.01375,12.01375,0,0,0,44,72V216a12.01375,12.01375,0,0,0,12,12H168a12.01375,12.01375,0,0,0,12-12V196h20a12.01375,12.01375,0,0,0,12-12V72A4.00116,4.00116,0,0,0,210.82861,69.17139ZM172,216a4.00458,4.00458,0,0,1-4,4H56a4.00458,4.00458,0,0,1-4-4V72a4.00458,4.00458,0,0,1,4-4h78.34326L172,105.65674Zm32-32a4.00458,4.00458,0,0,1-4,4H180V104a4.00116,4.00116,0,0,0-1.17139-2.82861l-40-40A4.00116,4.00116,0,0,0,136,60H84V40a4.00458,4.00458,0,0,1,4-4h78.34326L204,73.65674Zm-64-32a4.0002,4.0002,0,0,1-4,4H88a4,4,0,0,1,0-8h48A4.0002,4.0002,0,0,1,140,152Zm0,32a4.0002,4.0002,0,0,1-4,4H88a4,4,0,0,1,0-8h48A4.0002,4.0002,0,0,1,140,184Z" />
                </svg>
                <span class="text-lg font-medium">Examenes Clinicos</span>
            </div>
            <div class="flex flex-row items-center gap-2 hover:cursor-pointer" href="/consultas" wire:navigate>
                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                    <path d="M160,144a4.0002,4.0002,0,0,1-4,4H132v24a4,4,0,0,1-8,0V148H100a4,4,0,0,1,0-8h24V116a4,4,0,0,1,8,0v24h24A4.0002,4.0002,0,0,1,160,144Zm68.00781-64V208a12.01343,12.01343,0,0,1-12,12h-176a12.01343,12.01343,0,0,1-12-12V80a12.01343,12.01343,0,0,1,12-12H84V56a20.02229,20.02229,0,0,1,20-20h48a20.02229,20.02229,0,0,1,20,20V68h44.00781A12.01343,12.01343,0,0,1,228.00781,80ZM92,68h72V56a12.01375,12.01375,0,0,0-12-12H104A12.01375,12.01375,0,0,0,92,56ZM220.00781,80a4.00458,4.00458,0,0,0-4-4h-176a4.00458,4.00458,0,0,0-4,4V208a4.00458,4.00458,0,0,0,4,4h176a4.00458,4.00458,0,0,0,4-4Z" />
                </svg>
                <span class="text-lg font-medium ">Consultas</span>
            </div>
        </div>
    </nav>
</div>