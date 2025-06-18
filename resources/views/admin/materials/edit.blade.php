@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Materiaal Bewerken</h1>
            <p class="text-gray-600 mt-1">{{ $material->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.materials') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Terug naar overzicht
            </a>
            <a href="{{ route('admin.materials.show', $material) }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Bekijk Details
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.materials.edit', $material) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Geen @method directive nodig, we gebruiken gewoon POST --}}
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Linker kolom -->
                <div class="space-y-6">
                    <!-- Huidige afbeelding -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🖼️ Huidige Afbeelding</h3>
                        
                        <div class="bg-white rounded-lg border p-4">
                            <div class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img id="current-material-image" src="{{ \App\Helpers\MaterialImageHelper::getImageUrl($material->name) }}"
                                     alt="{{ $material->name }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full flex items-center justify-center text-gray-400" style="display: none;">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="mt-2 text-sm">Geen afbeelding</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button type="button" 
                                    onclick="refreshImage()" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔄 Afbeelding Verversen
                                </button> 
                            </div>

                            <div class="mt-4 text-center">
                                <button type="button" 
                                    onclick="resetImage()" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                ↩️ Origineel Herstellen
                                </button>
                            </div>
                        </div>
                    </div>
                    
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
                                   value="{{ old('name', $material->name) }}"
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
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $material->category_id) == $category->id ? 'selected' : '' }}>
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
                                      placeholder="Optionele beschrijving van het materiaal">{{ old('description', $material->description) }}</textarea>
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
                                @foreach(['stuk', 'meter', 'kg', 'liter', 'pak', 'doos', 'rol', 'set', 'paar', 'fles', 'koker', 'zak', 'patroon'] as $unit)
                                    <option value="{{ $unit }}" {{ old('unit', $material->unit) == $unit ? 'selected' : '' }}>
                                        {{ $unit }}
                                    </option>
                                @endforeach
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
                                   value="{{ old('article_number', $material->article_number) }}"
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
                                @foreach(['Fabory', 'Eriks', 'RS Components', 'Rexel', 'Solar', 'Hilti', 'Makita', 'Bosch', 'DeWalt', 'Anders'] as $supplier)
                                    <option value="{{ $supplier }}" {{ old('supplier', $material->supplier) == $supplier ? 'selected' : '' }}>
                                        {{ $supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Rechter kolom -->
                <div class="space-y-6">
                    <!-- Voorraad informatie -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Voorraad Informatie</h3>
                        
                        <!-- Huidige voorraad info -->
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-900">Huidige Voorraad:</span>
                                <span class="text-lg font-bold text-blue-900">
                                    {{ $material->current_stock }} {{ $material->unit }}
                                </span>
                            </div>
                            @if($material->current_stock <= $material->minimum_stock)
                                <div class="mt-2 text-xs text-yellow-700 bg-yellow-100 px-2 py-1 rounded">
                                    ⚠️ Voorraad is laag (onder minimum van {{ $material->minimum_stock }})
                                </div>
                            @endif
                        </div>
                        
                        <!-- Current Stock Update -->
                        <div class="mb-4">
                            <label for="current_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Nieuwe Voorraad <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="current_stock" 
                                   name="current_stock" 
                                   value="{{ old('current_stock', $material->current_stock) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('current_stock') border-red-500 @enderror"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">
                                Voer de nieuwe totale voorraad in
                            </p>
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
                                   value="{{ old('minimum_stock', $material->minimum_stock) }}"
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
                                   value="{{ old('price', $material->price) }}"
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
                        <h3 class="text-lg font-medium text-gray-900 mb-4">⚙️ Status & Beschikbaarheid</h3>
                        
                        <!-- Is Available -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="hidden" name="is_available" value="0">
                                <input type="checkbox" 
                                       id="is_available" 
                                       name="is_available" 
                                       value="1"
                                       {{ old('is_available', $material->is_available) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 block text-sm text-gray-900">
                                    Materiaal is beschikbaar voor bestelling
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Uitgeschakeld materiaal is niet zichtbaar voor gebruikers
                            </p>
                            
                            @if(!$material->is_available)
                                <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                                    ⚠️ Dit materiaal is momenteel NIET beschikbaar voor gebruikers
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">⚡ Snelle Acties</h3>
                        
                        <div class="space-y-3">
                            <!-- Quick stock adjustments -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Voorraad Aanpassing:</label>
                                <div class="flex space-x-2">
                                    <button type="button" 
                                            onclick="adjustStock(-10)" 
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                        -10
                                    </button>
                                    <button type="button" 
                                            onclick="adjustStock(-5)" 
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                        -5
                                    </button>
                                    <button type="button" 
                                            onclick="adjustStock(-1)" 
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                        -1
                                    </button>
                                    <button type="button" 
                                            onclick="adjustStock(1)" 
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                        +1
                                    </button>
                                    <button type="button" 
                                            onclick="adjustStock(5)" 
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                        +5
                                    </button>
                                    <button type="button" 
                                            onclick="adjustStock(10)" 
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                        +10
                                    </button>
                                </div>
                            </div>

                            <!-- Reset to minimum -->
                            <button type="button" 
                                    onclick="setStockToMinimum()" 
                                    class="w-full px-3 py-2 bg-yellow-100 text-yellow-700 rounded text-sm hover:bg-yellow-200">
                                📊 Zet voorraad op minimum niveau
                            </button>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-blue-900 mb-4">👁️ Preview Gebruikersweergave</h3>
                        <div class="bg-white rounded-lg border border-blue-200 p-4">
                            <!-- Preview Image -->
                            <div class="w-full h-32 bg-gray-100 rounded mb-4 overflow-hidden">
                                <img id="preview-image" 
                                     src="{{ \App\Helpers\MaterialImageHelper::getImageUrl($material->name) }}" 
                                     alt="{{ $material->name }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full flex items-center justify-center text-4xl text-gray-400" style="display: none;">
                                    📦
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium" id="preview-name">{{ $material->name }}</h4>
                                <span class="text-xs text-gray-500" id="preview-stock">{{ $material->current_stock }} {{ $material->unit }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2" id="preview-category">{{ $material->category->icon }} {{ $material->category->name }}</p>
                            <p class="text-xs text-gray-500" id="preview-description">{{ $material->description ?: 'Geen beschrijving' }}</p>
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <button type="button" 
                                        id="preview-button"
                                        class="w-full py-1 px-4 rounded text-sm {{ $material->current_stock > 0 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                    {{ $material->current_stock > 0 ? 'Toevoegen' : 'Niet beschikbaar' }}
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
                    💾 Wijzigingen Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const categorySelect = document.getElementById('category_id');
    const descriptionInput = document.getElementById('description');
    const currentStockInput = document.getElementById('current_stock');
    const unitSelect = document.getElementById('unit');
    const isAvailableCheckbox = document.getElementById('is_available');
    
    const previewName = document.getElementById('preview-name');
    const previewCategory = document.getElementById('preview-category');
    const previewDescription = document.getElementById('preview-description');
    const previewStock = document.getElementById('preview-stock');
    const previewButton = document.getElementById('preview-button');
    const previewImage = document.getElementById('preview-image');
    
    function updatePreview() {
        // Update name
        previewName.textContent = nameInput.value || 'Materiaal naam';
        
        // Update category
        const selectedCategory = categorySelect.selectedOptions[0];
        if (selectedCategory && selectedCategory.value) {
            previewCategory.textContent = selectedCategory.textContent;
        }
        
        // Update description
        previewDescription.textContent = descriptionInput.value || 'Geen beschrijving';
        
        // Update stock
        const stock = parseInt(currentStockInput.value) || 0;
        const unit = unitSelect.value || 'stuks';
        previewStock.textContent = `${stock} ${unit}`;
        
        // Update button
        const isAvailable = isAvailableCheckbox.checked;
        if (!isAvailable || stock <= 0) {
            previewButton.textContent = 'Niet beschikbaar';
            previewButton.className = 'w-full py-1 px-4 rounded text-sm bg-gray-300 text-gray-500';
        } else {
            previewButton.textContent = 'Toevoegen';
            previewButton.className = 'w-full py-1 px-4 rounded text-sm bg-blue-500 text-white';
        }
    }
    
    function updatePreviewImage() {
        const materialName = nameInput.value;
        if (materialName && materialName.length > 3) {
            // This would normally call the PHP helper, but for real-time preview we'd need AJAX
            // For now, just update the alt text
            previewImage.alt = materialName;
        }
    }
    
    // Add event listeners
    nameInput.addEventListener('input', function() {
        updatePreview();
        updatePreviewImage();
    });
    categorySelect.addEventListener('change', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    currentStockInput.addEventListener('input', updatePreview);
    unitSelect.addEventListener('change', updatePreview);
    isAvailableCheckbox.addEventListener('change', updatePreview);
    
    // Initial preview update
    updatePreview();
});

// Quick stock adjustment functions
function adjustStock(amount) {
    const stockInput = document.getElementById('current_stock');
    const currentValue = parseInt(stockInput.value) || 0;
    const newValue = Math.max(0, currentValue + amount);
    stockInput.value = newValue;
    
    // Trigger preview update
    stockInput.dispatchEvent(new Event('input'));
    
    // Visual feedback
    stockInput.style.backgroundColor = amount > 0 ? '#dcfce7' : '#fef2f2';
    setTimeout(() => {
        stockInput.style.backgroundColor = '';
    }, 500);
}

function setStockToMinimum() {
    const stockInput = document.getElementById('current_stock');
    const minimumInput = document.getElementById('minimum_stock');
    const minimumValue = parseInt(minimumInput.value) || 0;
    
    stockInput.value = minimumValue;
    stockInput.dispatchEvent(new Event('input'));
    
    // Visual feedback
    stockInput.style.backgroundColor = '#fef3c7';
    setTimeout(() => {
        stockInput.style.backgroundColor = '';
    }, 500);
}

function refreshImage() {
    const materialName = document.getElementById('name').value;
    if (!materialName) {
        alert('Voer eerst een materiaal naam in');
        return;
    }

    // Maak een verborgen file input
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    
    // Wanneer een bestand wordt geselecteerd
    fileInput.onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            // Maak een URL van het bestand
            const imageUrl = URL.createObjectURL(file);
            
            // Update de afbeelding op de pagina
            const imageElement = document.getElementById('current-material-image');
            if (imageElement) {
                imageElement.src = imageUrl;
                imageElement.style.display = 'block'; // Zorg dat de img zichtbaar is
                imageElement.nextElementSibling.style.display = 'none'; // Verberg de "geen afbeelding" placeholder
            }
        }
    };
    
    // Open file selector
    fileInput.click();
}

function resetImage() {
    const imageElement = document.getElementById('current-material-image');
    if (imageElement) {
        // Zet terug naar de originele afbeelding
        imageElement.src = '{{ \App\Helpers\MaterialImageHelper::getImageUrl($material->name) }}';
        imageElement.style.display = 'block';
        imageElement.nextElementSibling.style.display = 'none';
    }
}
</script>
@endsection