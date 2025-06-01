@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="imageUpload()">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden mb-8">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for ($i = 1; $i <= 3; $i++)
                <div class="absolute rounded-full mix-blend-multiply filter blur-xl opacity-70"
                     style="
                        background: #60A5FA;
                        width: {{ rand(200, 300) }}px;
                        height: {{ rand(200, 300) }}px;
                        left: {{ rand(-20, 120) }}%;
                        top: {{ rand(-20, 120) }}%;
                        animation: float{{ $i }} {{ rand(10, 20) }}s infinite ease-in-out;">
                </div>
            @endfor
        </div>

        <div class="relative max-w-4xl mx-auto px-4 py-12">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-blue-100 hover:text-white transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
            <div class="mt-4 text-white" data-aos="fade-up">
                <h1 class="text-3xl font-bold mb-2">Buat Pengaduan Baru</h1>
                <p class="text-blue-100">Sampaikan pengaduan Anda dengan jelas dan lengkap</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-6" data-aos="fade-up">
            <form action="{{ route('pengaduan.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  @submit.prevent="submitForm($event) && $el.submit()">
                @csrf

                <!-- Kategori -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="100">
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Pengaduan
                    </label>
                    <select name="kategori_id" id="kategori_id"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200
                                   transition-colors duration-200 @error('kategori_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="200">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Pengaduan
                    </label>
                    <input type="text" name="judul" id="judul"
                           class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200
                                  transition-colors duration-200 @error('judul') border-red-500 @enderror"
                           value="{{ old('judul') }}"
                           placeholder="Masukkan judul pengaduan"
                           required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="300">
                    <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                        Isi Pengaduan
                    </label>
                    <textarea name="isi" id="isi" rows="6"
                              class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200
                                     transition-colors duration-200 @error('isi') border-red-500 @enderror"
                              placeholder="Jelaskan detail pengaduan Anda..."
                              required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Enhanced Image Upload -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="400">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lampiran Gambar (Opsional)
                    </label>
                    <div class="relative">
                        <!-- Drop Zone -->
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl
                                  transition-all duration-300 cursor-pointer"
                             :class="{'border-blue-500 bg-blue-50': isDragging}"
                             x-on:dragover.prevent="isDragging = true"
                             x-on:dragleave.prevent="isDragging = false"
                             x-on:drop.prevent="handleDrop($event)"
                             @click="$refs.fileInput.click()">

                            <!-- Preview Area -->
                            <div class="space-y-1 text-center" x-show="!imageUrl">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload gambar</span>
                                        <input type="file"
                                               name="gambar"
                                               x-ref="fileInput"
                                               class="sr-only"
                                               accept="image/*"
                                               @change="handleFileSelect">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF maksimal 10MB
                                </p>
                            </div>

                            <!-- Image Preview -->
                            <div x-show="imageUrl" class="relative w-full">
                                <img :src="imageUrl"
                                     class="max-h-64 rounded-lg mx-auto"
                                     alt="Preview">
                                <button type="button"
                                        @click.stop="removeImage"
                                        class="absolute top-2 right-2 bg-red-100 text-red-600 rounded-full p-2 hover:bg-red-200 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div x-show="errorMessage"
                             x-text="errorMessage"
                             class="text-red-500 text-xs mt-1"></div>
                        @error('gambar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Enhanced Submit Button -->
                <div class="flex justify-end" data-aos="fade-up" data-aos-delay="500">
                    <button type="submit"
                            class="group relative inline-flex items-center px-8 py-3 text-lg font-medium text-white
                                   bg-blue-600 rounded-xl overflow-hidden transition-all duration-300
                                   hover:bg-blue-700 transform hover:-translate-y-1 hover:shadow-lg"
                            :disabled="isSubmitting"
                            :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }">
                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform rotate-12
                                   translate-x-1 bg-white opacity-10 group-hover:-translate-x-40"></span>
                        <template x-if="!isSubmitting">
                            <i class="fas fa-paper-plane mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        </template>
                        <template x-if="isSubmitting">
                            <i class="fas fa-circle-notch fa-spin mr-2"></i>
                        </template>
                        <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim Pengaduan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function imageUpload() {
    return {
        isDragging: false,
        isSubmitting: false,
        imageUrl: null,
        errorMessage: null,
        selectedFile: null,

        // Consolidated submit handler
        submitForm(e) {
            console.log("Submit triggered", this.selectedFile);
            this.isSubmitting = true;

            if (!this.$refs.fileInput.files.length && !this.selectedFile) {
                console.log("No file selected");
                return true;
            }

            if (this.selectedFile) {
                try {
                    console.log("Attaching file:", this.selectedFile);
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(this.selectedFile);
                    this.$refs.fileInput.files = dataTransfer.files;
                    console.log("File attached successfully:", this.$refs.fileInput.files);
                } catch (error) {
                    console.error("Error attaching file:", error);
                    return false;
                }
            }

            return true;
        },

        handleFileSelect(event) {
            console.log("File selected:", event.target.files);
            this.handleFiles(event.target.files);
        },

        handleDrop(event) {
            console.log("File dropped");
            this.isDragging = false;
            this.handleFiles(event.dataTransfer.files);
        },

        handleFiles(files) {
            const file = files[0];
            if (!file) return;

            console.log("Processing file:", file);

            // Validate file type
            if (!file.type.match('image.*')) {
                this.errorMessage = 'File harus berupa gambar';
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                this.errorMessage = 'Ukuran file maksimal 10MB';
                return;
            }

            // Store the file
            this.selectedFile = file;
            this.errorMessage = null;

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl = e.target.result;
                console.log("Preview created");
            };
            reader.readAsDataURL(file);
        },

        removeImage() {
            console.log("Removing image");
            this.imageUrl = null;
            this.selectedFile = null;
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endpush

@push('styles')
<style>
@keyframes float1 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(20px, -20px) rotate(5deg); }
}
@keyframes float2 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-20px, 20px) rotate(-5deg); }
}
@keyframes float3 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(15px, 15px) rotate(3deg); }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
@endpush
@endsection
