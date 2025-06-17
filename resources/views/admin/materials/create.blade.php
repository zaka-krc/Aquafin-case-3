@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nieuw Materiaal Toevoegen</h1>
            <p class="text-gray-600 mt-1">Voeg een nieuw materiaal toe aan de voorraad</p>
        </div>
        <a href="{{ route('admin.materials') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Terug naar overzicht
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Linker kolom -->
                <div class="space-y-6">
                    <!-- Basis informatie -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">📋 Basis Informatie</h3>
                        
                        <!-- Materiaal naam -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Materiaal Naam <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="bv. Bouten M8 inox A2"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categorie -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Categorie <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Selecteer een categorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Beschrijving -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Beschrijving
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                      placeholder="Optionele beschrijving van het materiaal">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🏷️ Product Details</h3>
                        
                        <!-- Unit -->
                        <div class="mb-4">
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">
                                Eenheid <span class="text-red-500">*</span>
                            </label>
                            <select id="unit" 
                                    name="unit" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('unit') border-red-500 @enderror"
                                    required>
                                <option value="">Selecteer eenheid</option>
                                <option value="stuk" {{ old('unit') == 'stuk' ? 'selected' : '' }}>stuk</option>
                                <option value="meter" {{ old('unit') == 'meter' ? 'selected' : '' }}>meter</option>
                                <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>liter</option>
                                <option value="pak" {{ old('unit') == 'pak' ? 'selected' : '' }}>pak</option>
                                <option value="doos" {{ old('unit') == 'doos' ? 'selected' : '' }}>doos</option>
                                <option value="rol" {{ old('unit') == 'rol' ? 'selected' : '' }}>rol</option>
                                <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>set</option>
                                <option value="paar" {{ old('unit') == 'paar' ? 'selected' : '' }}>paar</option>
                                <option value="fles" {{ old('unit') == 'fles' ? 'selected' : '' }}>fles</option>
                            </select>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Number -->
                        <div class="mb-4">
                            <label for="article_number" class="block text-sm font-medium text-gray-700 mb-1">
                                Artikelnummer
                            </label>
                            <input type="text" 
                                   id="article_number" 
                                   name="article_number" 
                                   value="{{ old('article_number') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('article_number') border-red-500 @enderror"
                                   placeholder="bv. ART-123456">
                            @error('article_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div class="mb-4">
                            <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">
                                Leverancier
                            </label>
                            <select id="supplier" 
                                    name="supplier" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('supplier') border-red-500 @enderror">
                                <option value="">Selecteer leverancier</option>
                                <option value="Fabory" {{ old('supplier') == 'Fabory' ? 'selected' : '' }}>Fabory</option>
                                <option value="Eriks" {{ old('supplier') == 'Eriks' ? 'selected' : '' }}>Eriks</option>
                                <option value="RS Components" {{ old('supplier') == 'RS Components' ? 'selected' : '' }}>RS Components</option>
                                <option value="Rexel" {{ old('supplier') == 'Rexel' ? 'selected' : '' }}>Rexel</option>
                                <option value="Solar" {{ old('supplier') == 'Solar' ? 'selected' : '' }}>Solar</option>
                                <option value="Hilti" {{ old('supplier') == 'Hilti' ? 'selected' : '' }}>Hilti</option>
                                <option value="Makita" {{ old('supplier') == 'Makita' ? 'selected' : '' }}>Makita</option>
                                <option value="Anders" {{ old('supplier') == 'Anders' ? 'selected' : '' }}>Anders</option>
                            </select>
                            @error('supplier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Rechter kolom -->
                <div class="space-y-6">
                    <!-- Afbeelding Preview -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🖼️ Materiaal Afbeelding</h3>
                        
                        <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-6">
                            <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 overflow-hidden flex items-center justify-center" id="image-preview">
                                <div class="text-center" id="placeholder-content">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Afbeelding wordt automatisch geladen op basis van materiaal naam</p>
                                </div>
                                <img id="preview-image" class="w-full h-full object-cover" style="display: none;">
                            </div>
                            
                            <div class="text-center">
                                <button type="button" 
                                        onclick="loadPreviewImage()" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    🔄 Afbeelding Laden
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Voorraad informatie -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Voorraad Informatie</h3>
                        
                        <!-- Current Stock -->
                        <div class="mb-4">
                            <label for="current_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Huidige Voorraad <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="current_stock" 
                                   name="current_stock" 
                                   value="{{ old('current_stock', 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('current_stock') border-red-500 @enderror"
                                   required>
                            @error('current_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Minimum Stock -->
                        <div class="mb-4">
                            <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Minimum Voorraad <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="minimum_stock" 
                                   name="minimum_stock" 
                                   value="{{ old('minimum_stock', 5) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('minimum_stock') border-red-500 @enderror"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Waarschuwing wordt getoond wanneer voorraad onder dit niveau komt</p>
                            @error('minimum_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                Prijs per eenheid (€)
                            </label>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                                   placeholder="0.00">
                            <p class="mt-1 text-xs text-gray-500">Optioneel - voor kostenbeheer</p>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">⚙️ Status</h3>
                        
                        <!-- Is Available -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_available" 
                                       name="is_available" 
                                       value="1"
                                       {{ old('is_available', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 block text-sm text-gray-900">
                                    Materiaal is beschikbaar voor bestelling
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Uitgeschakeld materiaal is niet zichtbaar voor gebruikers</p>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-blue-900 mb-4">👁️ Preview</h3>
                        <div class="bg-white rounded-lg border border-blue-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium" id="preview-name">Materiaal naam</h4>
                                <span class="text-xs text-gray-500" id="preview-stock">0 stuks</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2" id="preview-category">📦 Categorie</p>
                            <p class="text-xs text-gray-500" id="preview-description">Beschrijving...</p>
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <button type="button" class="w-full bg-blue-500 text-white py-1 px-4 rounded text-sm">
                                    Toevoegen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.materials') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Annuleren
                </a>
                <button type="submit" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    💾 Materiaal Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Live Preview JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const categorySelect = document.getElementById('category_id');
    const descriptionInput = document.getElementById('description');
    const currentStockInput = document.getElementById('current_stock');
    const unitSelect = document.getElementById('unit');
    
    const previewName = document.getElementById('preview-name');
    const previewCategory = document.getElementById('preview-category');
    const previewDescription = document.getElementById('preview-description');
    const previewStock = document.getElementById('preview-stock');
    
    function updatePreview() {
        // Update name
        previewName.textContent = nameInput.value || 'Materiaal naam';
        
        // Update category
        const selectedCategory = categorySelect.selectedOptions[0];
        if (selectedCategory && selectedCategory.value) {
            previewCategory.textContent = selectedCategory.textContent;
        } else {
            previewCategory.textContent = '📦 Categorie';
        }
        
        // Update description
        previewDescription.textContent = descriptionInput.value || 'Beschrijving...';
        
        // Update stock
        const stock = currentStockInput.value || '0';
        const unit = unitSelect.value || 'stuks';
        previewStock.textContent = `${stock} ${unit}`;
    }
    
    // Add event listeners
    nameInput.addEventListener('input', updatePreview);
    categorySelect.addEventListener('change', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    currentStockInput.addEventListener('input', updatePreview);
    unitSelect.addEventListener('change', updatePreview);
    
    // Auto-load image when name changes
    nameInput.addEventListener('input', function() {
        if (this.value.length > 3) {
            setTimeout(loadPreviewImage, 500); // Debounce
        }
    });
    
    // Initial preview update
    updatePreview();
    
    // Auto-generate article number suggestion
    nameInput.addEventListener('blur', function() {
        const articleInput = document.getElementById('article_number');
        if (!articleInput.value && this.value) {
            const suggestion = 'ART-' + this.value.substring(0, 3).toUpperCase() + Math.floor(Math.random() * 1000);
            articleInput.value = suggestion;
        }
    });
});

// Load preview image function
function loadPreviewImage() {
    const materialName = document.getElementById('name').value;
    if (!materialName) {
        alert('Voer eerst een materiaal naam in');
        return;
    }
    
    // Create a temporary image to test if it loads
    const testImg = new Image();
    const previewImg = document.getElementById('preview-image');
    const placeholder = document.getElementById('placeholder-content');
    
    testImg.onload = function() {
        previewImg.src = testImg.src;
        previewImg.style.display = 'block';
        placeholder.style.display = 'none';
    };
    
    testImg.onerror = function() {
        placeholder.innerHTML = `
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p class="mt-2 text-sm text-red-500">Geen afbeelding gevonden voor "${materialName}"</p>
            <p class="text-xs text-gray-500">Er wordt een placeholder gebruikt voor gebruikers</p>
        `;
        previewImg.style.display = 'none';
        placeholder.style.display = 'block';
    };
    
    // Use the MaterialImageHelper to get the URL
    testImg.src = getImageUrlForMaterial(materialName);
}

// Simple client-side version of the image helper for preview
function getImageUrlForMaterial(materialName) {
    // This would normally use the PHP helper, but for preview we'll use a simple approximation
    const name = materialName.toLowerCase();
    
    // Add some basic matching
    if (name.includes('bout') && name.includes('m6')) {
        return 'https://media.s-bol.com/311L0wKzkjQR/550x505.jpg';
    } else if (name.includes('bout') && name.includes('m8')) {
        return 'https://media.s-bol.com/R48OYV4EovO/550x505.jpg';
    } else if (name.includes('moer') && name.includes('m6')) {
        return 'https://cdn.toolstation.be/images/160916-BE/800/20204.jpg';
    } else if (name.includes('helm')) {
        return 'https://www.gereedschap.rotopino.be/photo/product/neo-97-222-2-137060-f-sk7-w780-h554_1.png';
    }
    
    // Fallback
    return `https://via.placeholder.com/300x300/e5e7eb/6b7280?text=${encodeURIComponent(materialName)}`;
}
</script>
@endsection