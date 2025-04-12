<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- ...existing navigation items... -->
                
                <x-nav-link :href="route('cv.upload')" :active="request()->routeIs('cv.upload')">
                    <i class="fas fa-file-alt mr-2"></i>
                    {{ __('CV Analysis') }}
                </x-nav-link>
            </div>
        </div>
    </div>
</nav>