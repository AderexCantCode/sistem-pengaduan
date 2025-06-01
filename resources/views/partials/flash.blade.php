@if (session('success') || session('error') || session('info') || session('warning'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-4 right-4 z-50">

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-700 hover:text-green-900 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-700 hover:text-red-900 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <p>{{ session('info') }}</p>
                </div>
                <button @click="show = false" class="text-blue-700 hover:text-blue-900 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <p>{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-yellow-700 hover:text-yellow-900 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>
@endif
