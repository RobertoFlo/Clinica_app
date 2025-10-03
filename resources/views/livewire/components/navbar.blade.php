<div>
    <nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false"
        class="flex items-center justify-between px-6 py-4 bg-blue-800 border-b border-gray-100 shadow-lg text-white"
        aria-label="penguin ui menu">
        <!-- Brand Logo -->
        <a  wire:click="$dispatch('despligue')"
            class="text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong  hover:cursor-pointer">
            <span>Clinica</span>
        </a>
        <!-- Desktop Menu -->
        <ul class="hidden items-center gap-4 sm:flex  ">
            <!-- User Pic -->
            <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }"
                x-on:keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false"
                class="relative flex items-center">
                <button x-on:click="userDropDownIsOpen = ! userDropDownIsOpen" x-bind:aria-expanded="userDropDownIsOpen"
                    x-on:keydown.space.prevent="openWithKeyboard = true"
                    x-on:keydown.enter.prevent="openWithKeyboard = true"
                    x-on:keydown.down.prevent="openWithKeyboard = true"
                    class="rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary flex items-center gap-2"
                    aria-controls="userMenu">
                    <span class="text-lg font-bold">{{$user->name}}</span>
                    <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile"
                        class="size-10 rounded-full object-cover" />
                </button>
                <!-- User Dropdown -->
                <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity
                    x-trap="openWithKeyboard" x-on:click.outside="userDropDownIsOpen = false, openWithKeyboard = false"
                    x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()"
                    id="userMenu"
                    class="absolute right-0 top-12 flex w-fit min-w-48 flex-col overflow-hidden rounded-radius border border-outline bg-surface-alt py-1.5 bg-white">
                    <li class="">
                        <div class="flex flex-col px-4 py-2">
                            <span class="text-sm font-medium text-on-surface-strong text-black">{{$user->name}}</span>
                            <p class="text-xs text-on-surface text-black">{{$user->email}}</p>
                        </div>
                    </li>
                    <li><a href="/" wire:navigate
                            class="block bg-surface-alt px-4 py-2 text-sm text-on-surface text-black">Dashboard</a>
                    </li>
                    <li><a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface text-black">Settings</a>
                    </li>
                    <li>
                        <form action="{{ route('cierrar.session') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left bg-surface-alt px-4 py-2 text-sm text-on-surface  hover:cursor-pointer text-black">
                                Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Mobile Menu Button -->
        <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
            class="flex text-on-surface dark:text-on-surface-dark sm:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
            <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Mobile Menu -->
        <ul x-cloak x-show="mobileMenuIsOpen" 
            x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full"
            class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-radius border-b border-outline bg-surface-alt px-8 pb-6 pt-10 bg-white sm:hidden">
            <li class="mb-4 border-none">
                <div class="flex items-center gap-2 py-2">
                    <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile"
                        class="size-12 rounded-full object-cover" />
                    <div>
                        <span class="font-medium text-on-surface-strong  text-black">{{$user->name}}</span>
                        <p class="text-sm text-on-surface  text-black">{{$user->email}}</p>
                    </div>
                </div>
            </li>

            <li class="p-2"><a href="/" wire:navigate class="w-full text-on-surface focus:underline text-black">Dashboard</a></li>
            <li class="p-2"><a href="#" class="w-full text-on-surface focus:underline text-black">Settings</a></li>
            <!-- CTA Button -->
            <li>
                <form action="{{ route('cierrar.session') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left bg-surface-alt px-4 py-2 text-sm text-on-surface  hover:cursor-pointer text-black">
                        Sign Out
                    </button>
                </form>
            </li>
        </ul>
    </nav>


</div>