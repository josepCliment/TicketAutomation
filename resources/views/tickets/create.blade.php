@extends('layouts.app')

@section('title', 'Upload Ticket - Ticket Processor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Upload Receipt</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Upload a photo of your receipt for automatic processing</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf

            <!-- Image Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Receipt Image *</label>
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer" id="dropZone">
                    <input type="file" name="image" accept="image/*" id="imageInput" class="hidden" required>
                    <div id="uploadPlaceholder">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V16a4 4 0 00-4-4h-8V6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="24" cy="24" r="4" stroke-width="2"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                            PNG, JPG, WebP up to 20MB
                        </p>
                    </div>
                    <div id="uploadedFile" class="hidden">
                        <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2 font-medium text-gray-900 dark:text-white" id="fileName"></p>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Store -->
            <div class="mb-6">
                <label for="store" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name *</label>
                <input type="text" name="store" id="store" value="{{ old('store') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="e.g., Obramat, Home Depot, Lowes"
                    required>
                @error('store')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select a category</option>
                    <option value="tejado" {{ old('category') === 'tejado' ? 'selected' : '' }}>Roof (Tejado)</option>
                    <option value="fontaneria" {{ old('category') === 'fontaneria' ? 'selected' : '' }}>Plumbing (Fontanería)</option>
                    <option value="electricidad" {{ old('category') === 'electricidad' ? 'selected' : '' }}>Electricity (Electricidad)</option>
                    <option value="patio" {{ old('category') === 'patio' ? 'selected' : '' }}>Patio</option>
                    <option value="cuadra" {{ old('category') === 'cuadra' ? 'selected' : '' }}>Stable (Cuadra)</option>
                    <option value="otros" {{ old('category') === 'otros' ? 'selected' : '' }}>Other (Otros)</option>
                </select>
                @error('category')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" id="submitBtn" disabled
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white rounded-lg font-medium transition">
                    Upload & Process
                </button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <strong>Tip:</strong> Make sure the receipt is clear and well-lit for best results. The system uses AI to extract products and totals automatically.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadedFile = document.getElementById('uploadedFile');
    const fileName = document.getElementById('fileName');
    const submitBtn = document.getElementById('submitBtn');

    // Drop zone click
    dropZone.addEventListener('click', () => imageInput.click());

    // Drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        imageInput.files = files;
        updatePreview();
    }

    // File input change
    imageInput.addEventListener('change', updatePreview);

    function updatePreview() {
        if (imageInput.files.length > 0) {
            fileName.textContent = imageInput.files[0].name;
            uploadPlaceholder.classList.add('hidden');
            uploadedFile.classList.remove('hidden');
            submitBtn.disabled = false;
        } else {
            uploadPlaceholder.classList.remove('hidden');
            uploadedFile.classList.add('hidden');
            submitBtn.disabled = true;
        }
    }
});
</script>
@endsection

