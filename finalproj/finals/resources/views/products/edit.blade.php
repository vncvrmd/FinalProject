@extends('layouts.app')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Products
        </a>

        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-100 dark:border-dark-border bg-gradient-to-r from-[#0f2744] via-[#0a1628] to-[#0e7490]">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 overflow-hidden">
                        @if($product->product_image)
                            <img src="{{ asset('storage/' . $product->product_image) }}" class="w-full h-full object-cover" alt="">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $product->product_name }}</h2>
                        <p class="text-primary-100 text-sm">Update product information</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-red-700 dark:text-red-400">Please correct the errors below:</p>
                                <ul class="mt-2 text-sm text-red-600 dark:text-red-300 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="product_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Price</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="quantity_available" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Quantity Available</label>
                            <input type="number" name="quantity_available" id="quantity_available" value="{{ old('quantity_available', $product->quantity_available) }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                        </div>
                    </div>

                    <div class="space-y-2" x-data="imageUpload('{{ $product->product_image ? asset('storage/' . $product->product_image) : '' }}', '{{ $product->product_image ? basename($product->product_image) : '' }}')">
                        <label for="product_image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Product Image</label>
                        
                        {{-- Upload Area - shown when no image --}}
                        <div x-show="!imagePreview" 
                             class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 dark:border-dark-border border-dashed rounded-xl hover:border-primary-400 dark:hover:border-primary-500 transition-colors cursor-pointer"
                             @click="$refs.fileInput.click()"
                             @dragover.prevent="isDragging = true"
                             @dragleave.prevent="isDragging = false"
                             @drop.prevent="handleDrop($event)"
                             :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/10': isDragging }">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">Upload a file</span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        
                        {{-- Image Preview - shown when image exists --}}
                        <div x-show="imagePreview" x-cloak class="mt-1 relative">
                            <div class="relative rounded-xl overflow-hidden border-2 border-primary-500 bg-gray-50 dark:bg-dark-bg">
                                {{-- Status Badge --}}
                                <div class="absolute top-3 left-3 z-10">
                                    <div class="flex items-center gap-2 px-3 py-1.5 text-white text-sm font-medium rounded-lg shadow-lg"
                                         :class="isNewUpload ? 'bg-green-500' : 'bg-primary-600'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span x-text="isNewUpload ? 'New image uploaded' : 'Current image'"></span>
                                    </div>
                                </div>
                                
                                {{-- Remove Button --}}
                                <button type="button" @click="removeImage()" 
                                        class="absolute top-3 right-3 z-10 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                
                                {{-- Image Preview --}}
                                <div class="flex justify-center p-4">
                                    <img :src="imagePreview" alt="Preview" class="max-h-64 rounded-lg object-contain shadow-md">
                                </div>
                                
                                {{-- File Info --}}
                                <div class="px-4 py-3 bg-gray-100 dark:bg-dark-border border-t border-gray-200 dark:border-dark-border">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-xs" x-text="fileName"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="fileSize || 'Current product image'"></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="$refs.fileInput.click()" 
                                                class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                            Change
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Hidden File Input --}}
                        <input type="file" 
                               id="product_image" 
                               name="product_image" 
                               x-ref="fileInput"
                               @change="handleFileSelect($event)"
                               accept="image/png,image/jpeg,image/gif"
                               class="sr-only">
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#0f2744] to-[#0e7490] text-white font-semibold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function imageUpload(existingImage = '', existingFileName = '') {
            return {
                imagePreview: existingImage || null,
                fileName: existingFileName || '',
                fileSize: '',
                isDragging: false,
                isNewUpload: false,
                
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processFile(file);
                    }
                },
                
                handleDrop(event) {
                    this.isDragging = false;
                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        this.$refs.fileInput.files = event.dataTransfer.files;
                        this.processFile(file);
                    }
                },
                
                processFile(file) {
                    this.fileName = file.name;
                    this.fileSize = this.formatFileSize(file.size);
                    this.isNewUpload = true;
                    
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                
                removeImage() {
                    this.imagePreview = null;
                    this.fileName = '';
                    this.fileSize = '';
                    this.isNewUpload = false;
                    this.$refs.fileInput.value = '';
                },
                
                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }
            }
        }
    </script>
@endsection