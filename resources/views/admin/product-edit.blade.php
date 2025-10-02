@extends('layouts.admin')
@section('title', 'Edit Product')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit Product</div></li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.product.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $product->id }}">

            <!-- Basic Product Information -->
            <div class="wg-box">
                <div class="body-title mb-10">Basic Information</div>
                
                <fieldset class="name">
                    <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="e.g., iPhone 17 Pro Max" name="name" id="productName" value="{{ $product->name }}" required>
                    <div class="text-tiny">Maximum 100 characters</div>
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="e.g., iphone-17-pro-max" name="slug" id="productSlug" value="{{ $product->slug }}" required>
                    <div class="text-tiny">Auto-generated from product name</div>
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" required>
                                <option value="">Choose Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category_id') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="brand_id" required>
                                <option value="">Choose Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Brief product description" required>{{ $product->short_description }}</textarea>
                </fieldset>
                @error('short_description') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-200" name="description" placeholder="Detailed product description" required>{{ $product->description }}</textarea>
                </fieldset>
                @error('description') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
            </div>

            <!-- Pricing & Stock -->
            <div class="wg-box">
                <div class="body-title mb-20">Pricing & Inventory</div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" step="0.01" placeholder="0.00" name="regular_price" value="{{ $product->regular_price }}" required>
                    </fieldset>
                    @error('regular_price') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price</div>
                        <input class="mb-10" type="number" step="0.01" placeholder="0.00" name="sale_price" value="{{ $product->sale_price }}">
                    </fieldset>
                    @error('sale_price') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="e.g., IPHONE-17PM" name="SKU" value="{{ $product->SKU }}" required>
                    </fieldset>
                    @error('SKU') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="0" name="quantity" value="{{ $product->quantity }}" required>
                    </fieldset>
                    @error('quantity') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock Status</div>
                        <div class="select mb-10">
                            <select name="stock_status">
                                <option value="instock" {{ $product->stock_status == "instock" ? "selected" : "" }}>In Stock</option>
                                <option value="outofstock" {{ $product->stock_status == "outofstock" ? "selected" : "" }}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Featured Product</div>
                        <div class="select mb-10">
                            <select name="featured">
                                <option value="0" {{ $product->featured == "0" ? "selected" : "" }}>No</option>
                                <option value="1" {{ $product->featured == "1" ? "selected" : "" }}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>
            </div>

            <!-- Product Variants Section -->
            <div class="wg-box variants-main-box" id="variantsSection">
                <div class="variants-intro">
                    <div class="variants-intro-icon">
                        <i class="icon-package"></i>
                    </div>
                    <div class="variants-intro-content">
                        <h4>Product Variants & Images Management</h4>
                        <p><strong>Manage your product variants and their images</strong></p>
                        <p>Edit existing variants, update images, or create new variant combinations below</p>
                        <div class="example-box">
                            <strong>Quick Tips</strong>
                            <ul>
                                <li>Edit existing variant details and add more images</li>
                                <li>Delete variants you no longer need</li>
                                <li>Create new variants by selecting options below</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Existing Variants -->
                @if($product->variants->count() > 0)
                <div class="existing-variants-section">
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-text">
                            <i class="icon-list"></i> Existing Variants ({{ $product->variants->count() }})
                        </div>
                        <div class="section-divider-line"></div>
                    </div>
                    
                    @foreach($product->variants as $index => $variant)
                    <div class="variant-card existing-variant" data-variant-id="{{ $variant->id }}">
                        <div class="variant-header">
                            <div class="variant-header-left">
                                <span class="variant-emoji">@php echo getColorEmoji($variant->attributeValues->first()->value ?? 'default'); @endphp</span>
                                <div>
                                    <span class="variant-label">Existing Variant {{ $index + 1 }}</span>
                                    <h6>{{ $variant->attributeValues->pluck('value')->join(' • ') }}</h6>
                                </div>
                            </div>
                            <button type="button" class="btn-remove-variant" onclick="deleteVariant({{ $variant->id }}, this)">
                                <i class="icon-trash-2"></i> Delete
                            </button>
                        </div>
                        
                        <div class="variant-body">
                            <!-- Existing Images -->
                            <div class="variant-images-main">
                                <div class="images-header">
                                    <div>
                                        <h5><i class="icon-camera"></i> Current Images for: {{ $variant->attributeValues->pluck('value')->join(' • ') }}</h5>
                                        <p class="text-tiny">{{ $variant->images ? count(explode(',', $variant->images)) : 0 }} image(s) currently uploaded</p>
                                    </div>
                                </div>
                                
                                @if($variant->images)
                                <div class="variant-preview-grid">
                                    @foreach(explode(',', $variant->images) as $imgIndex => $img)
                                    <div class="variant-preview-item" data-image-name="{{ trim($img) }}">
                                        <img src="{{ asset('uploads/products') }}/{{ trim($img) }}" alt="Image {{ $imgIndex + 1 }}">
                                        <div class="preview-badge">{{ $imgIndex + 1 }}</div>
                                        <button type="button" class="btn-delete-image" onclick="deleteVariantImage({{ $variant->id }}, '{{ trim($img) }}', this)">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                        <div class="preview-overlay">
                                            <i class="icon-check"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Upload More Images -->
                                <div class="variant-upload-container mt-3">
                                    <input type="file" 
                                           name="existing_variants[{{ $variant->id }}][images][]" 
                                           multiple 
                                           accept="image/*"
                                           class="variant-file-input"
                                           id="existingImages{{ $variant->id }}"
                                           onchange="previewExistingVariantImages({{ $variant->id }})">
                                    <label for="existingImages{{ $variant->id }}" class="variant-upload-box">
                                        <div class="upload-icon">
                                            <i class="icon-upload-cloud"></i>
                                        </div>
                                        <div class="upload-content">
                                            <h6>Add More Images</h6>
                                            <p>Upload additional images for this variant</p>
                                            <span class="upload-formats">JPG, PNG, JPEG • Max 2MB each</span>
                                        </div>
                                    </label>
                                </div>
                                
                                <div id="existingPreview{{ $variant->id }}" class="variant-preview-grid mt-2"></div>
                                <div id="existingCounter{{ $variant->id }}" class="image-counter" style="display:none;">
                                    <i class="icon-image"></i> <span class="count">0</span> new image(s) to be added
                                </div>
                            </div>

                            <!-- Variant Details -->
                            <div class="variant-details-section">
                                <h6 class="section-subtitle"><i class="icon-settings"></i> Variant Details</h6>
                                <div class="variant-details-grid">
                                    <div class="variant-field">
                                        <label><i class="icon-hash"></i> SKU</label>
                                        <input type="text" 
                                               name="existing_variants[{{ $variant->id }}][sku]" 
                                               value="{{ $variant->sku }}"
                                               class="variant-input">
                                    </div>
                                    
                                    <div class="variant-field">
                                        <label><i class="icon-dollar-sign"></i> Price</label>
                                        <input type="number" 
                                               name="existing_variants[{{ $variant->id }}][price]" 
                                               value="{{ $variant->price }}"
                                               step="0.01"
                                               class="variant-input">
                                    </div>
                                    
                                    <div class="variant-field">
                                        <label><i class="icon-box"></i> Stock Quantity</label>
                                        <input type="number" 
                                               name="existing_variants[{{ $variant->id }}][quantity]" 
                                               value="{{ $variant->quantity }}"
                                               min="0"
                                               class="variant-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Add New Variants Section -->
                <div class="new-variants-section">
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-text">
                            <i class="icon-plus-circle"></i> Add New Variants
                        </div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="step-indicator">
                        <div class="step active">
                            <span class="step-number">1</span>
                            <span class="step-text">Select Variants</span>
                        </div>
                        <div class="step-arrow">→</div>
                        <div class="step">
                            <span class="step-number">2</span>
                            <span class="step-text">Generate Variants</span>
                        </div>
                        <div class="step-arrow">→</div>
                        <div class="step">
                            <span class="step-number">3</span>
                            <span class="step-text">Upload Images</span>
                        </div>
                    </div>
                    
                    @foreach($attributes as $attribute)
                    <div class="attribute-selector mb-20" data-attribute-id="{{ $attribute->id }}">
                        <label class="body-title mb-10">
                            <i class="icon-tag"></i> {{ $attribute->name }}:
                        </label>
                        <div class="attribute-values-grid">
                            @foreach($attribute->values as $val)
                            <label class="attribute-checkbox-item">
                                <input type="checkbox" 
                                       class="attribute-value"
                                       data-attr-id="{{ $attribute->id }}"
                                       data-attr-name="{{ $attribute->name }}"
                                       data-value-id="{{ $val->id }}"
                                       data-value-text="{{ $val->value }}">
                                <span class="checkbox-label">
                                    @if($attribute->type === 'color' && $val->color_code)
                                        <span class="color-preview" style="background:{{ $val->color_code }}"></span>
                                    @endif
                                    {{ $val->value }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <button type="button" class="tf-button style-1 w208" onclick="generateVariants()">
                        <i class="icon-zap"></i> Generate New Variants
                    </button>

                    <div id="variantsList"></div>
                </div>
            </div>

            <div class="wg-box">
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">
                        <i class="icon-save"></i> Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@php
function getColorEmoji($colorName) {
    $colorMap = [
        'black' => '⚫', 'white' => '⚪', 'red' => '🔴', 'blue' => '🔵',
        'green' => '🟢', 'yellow' => '🟡', 'orange' => '🟠', 'purple' => '🟣',
        'brown' => '🟤', 'gray' => '⚫', 'pink' => '🌸', 'navy' => '🔵'
    ];
    $color = strtolower($colorName);
    foreach ($colorMap as $key => $emoji) {
        if (stripos($color, $key) !== false) return $emoji;
    }
    return '📦';
}
@endphp

@push('scripts')
<script>
let selectedAttributes = {};

document.getElementById('productName').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('productSlug').value = slug;
});

function previewExistingVariantImages(variantId) {
    const input = document.getElementById('existingImages' + variantId);
    const preview = document.getElementById('existingPreview' + variantId);
    const counter = document.getElementById('existingCounter' + variantId);
    const uploadBox = input.nextElementSibling;
    
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        uploadBox.classList.add('has-files');
        counter.style.display = 'flex';
        counter.querySelector('.count').textContent = input.files.length;
        
        const filesArray = Array.from(input.files);
        
        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'variant-preview-item';
                div.draggable = true;
                div.dataset.fileIndex = index;
                div.innerHTML = `
                    <img src="${e.target.result}" alt="New Image ${index + 1}">
                    <div class="preview-badge new-badge">NEW</div>
                    <div class="preview-overlay">
                        <i class="icon-move"></i>
                    </div>
                `;
                preview.appendChild(div);
                
                if (index === filesArray.length - 1) {
                    makeImagesSortable('existing' + variantId);
                }
            }
            reader.readAsDataURL(file);
        });
    } else {
        uploadBox.classList.remove('has-files');
        counter.style.display = 'none';
    }
}

async function deleteVariant(variantId, button) {
    if (!confirm('Delete this variant? All images and data will be permanently removed.')) return;
    
    try {
        const response = await fetch(`/admin/variant/delete/${variantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const card = button.closest('.variant-card');
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            setTimeout(() => card.remove(), 300);
            alert('Variant deleted successfully!');
        } else {
            alert('Error deleting variant');
        }
    } catch (err) {
        console.error(err);
        alert('Network error');
    }
}

async function deleteVariantImage(variantId, imageName, button) {
    if (!confirm('Are you sure you want to delete this image? This action cannot be undone.')) return;
    
    try {
        const response = await fetch(`/admin/variant/delete-image/${variantId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ image: imageName })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const previewItem = button.closest('.variant-preview-item');
            previewItem.style.opacity = '0';
            previewItem.style.transform = 'scale(0.8)';
            setTimeout(() => {
                previewItem.remove();
                const variantCard = button.closest('.variant-card');
                const previewGrid = variantCard.querySelector('.variant-preview-grid');
                const items = previewGrid.querySelectorAll('.variant-preview-item');
                items.forEach((item, index) => {
                    const badge = item.querySelector('.preview-badge');
                    if (badge && !badge.classList.contains('new-badge')) {
                        badge.textContent = index + 1;
                    }
                });
            }, 300);
            alert('Image deleted successfully!');
        } else {
            alert(data.message || 'Error deleting image');
        }
    } catch (err) {
        console.error(err);
        alert('Network error. Please try again.');
    }
}

document.querySelectorAll('.attribute-value').forEach(cb => {
    cb.addEventListener('change', function() {
        const attrId = this.dataset.attrId;
        const attrName = this.dataset.attrName;
        const valueId = this.dataset.valueId;
        const valueText = this.dataset.valueText;

        if (!selectedAttributes[attrId]) {
            selectedAttributes[attrId] = { name: attrName, values: [] };
        }

        if (this.checked) {
            selectedAttributes[attrId].values.push({ id: valueId, text: valueText });
        } else {
            selectedAttributes[attrId].values = selectedAttributes[attrId].values.filter(v => v.id != valueId);
            if (selectedAttributes[attrId].values.length === 0) {
                delete selectedAttributes[attrId];
            }
        }
    });
});

function generateVariants() {
    const validAttrs = Object.values(selectedAttributes).filter(attr => attr.values.length > 0);
    
    if (validAttrs.length === 0) {
        alert('Please select at least one variant option (color, size, etc.)');
        return;
    }

    const attrValues = validAttrs.map(attr => attr.values);
    const combos = cartesianProduct(attrValues);
    
    document.querySelectorAll('.new-variants-section .step').forEach((step, idx) => {
        if (idx <= 1) step.classList.add('active');
    });
    
    let html = '<div class="variants-container">';
    html += '<div class="variants-header">';
    html += '<div class="variants-header-content">';
    html += '<i class="icon-check-circle"></i>';
    html += '<div>';
    html += '<h5>' + combos.length + ' New Variant(s) Generated</h5>';
    html += '<p>Now upload specific images for each new variant below</p>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    combos.forEach((combo, i) => {
        const variantName = combo.map(v => v.text).join(' • ');
        const attributeIds = combo.map(v => v.id).join(',');
        const colorEmoji = getColorEmoji(combo[0].text);
        
        html += `
        <div class="variant-card new-variant" id="newVariantCard${i}">
            <div class="variant-header">
                <div class="variant-header-left">
                    <span class="variant-emoji">${colorEmoji}</span>
                    <div>
                        <span class="variant-label">New Variant ${i + 1}</span>
                        <h6>${variantName}</h6>
                    </div>
                </div>
                <button type="button" class="btn-remove-variant" onclick="removeNewVariant(${i})">
                    <i class="icon-trash-2"></i> Remove
                </button>
            </div>
            
            <div class="variant-body">
                <div class="variant-images-main">
                    <div class="images-header">
                        <div>
                            <h5><i class="icon-camera"></i> Upload Images for: ${variantName}</h5>
                            <p class="text-tiny">Upload 1-10 high-quality images - Drag to reorder</p>
                        </div>
                        <span class="required-badge"><i class="icon-alert-circle"></i> Required</span>
                    </div>
                    
                    <div class="variant-upload-container">
                        <input type="file" 
                               name="new_variants[${i}][images][]" 
                               multiple 
                               accept="image/*"
                               class="variant-file-input"
                               id="newVariantImages${i}"
                               onchange="previewNewVariantImages(${i})"
                               required>
                        <label for="newVariantImages${i}" class="variant-upload-box">
                            <div class="upload-icon">
                                <i class="icon-upload-cloud"></i>
                            </div>
                            <div class="upload-content">
                                <h6>Click to Upload Images</h6>
                                <p>or drag and drop here</p>
                                <span class="upload-formats">JPG, PNG, JPEG • Max 2MB each</span>
                            </div>
                        </label>
                    </div>
                    
                    <div id="newVariantPreview${i}" class="variant-preview-grid"></div>
                    <div id="newImageCounter${i}" class="image-counter" style="display:none;">
                        <i class="icon-image"></i> <span class="count">0</span> image(s) uploaded
                    </div>
                </div>

                <div class="variant-details-section">
                    <h6 class="section-subtitle"><i class="icon-settings"></i> Variant Details</h6>
                    <div class="variant-details-grid">
                        <div class="variant-field">
                            <label><i class="icon-hash"></i> SKU <span class="tf-color-1">*</span></label>
                            <input type="text" 
                                   name="new_variants[${i}][sku]" 
                                   placeholder="e.g., ${combo.map(v => v.text.substring(0,3).toUpperCase()).join('-')}" 
                                   required 
                                   class="variant-input">
                        </div>
                        
                        <div class="variant-field">
                            <label><i class="icon-dollar-sign"></i> Price Override</label>
                            <input type="number" 
                                   name="new_variants[${i}][price]" 
                                   step="0.01" 
                                   placeholder="Optional - uses main price"
                                   class="variant-input">
                        </div>
                        
                        <div class="variant-field">
                            <label><i class="icon-box"></i> Stock Quantity <span class="tf-color-1">*</span></label>
                            <input type="number" 
                                   name="new_variants[${i}][quantity]" 
                                   value="0" 
                                   min="0" 
                                   required
                                   class="variant-input">
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="new_variants[${i}][attributes]" value="${attributeIds}">
            </div>
        </div>`;
    });

    html += '</div>';
    document.getElementById('variantsList').innerHTML = html;
    
    setTimeout(() => {
        document.querySelectorAll('.new-variants-section .step')[2].classList.add('active');
    }, 300);
    
    document.getElementById('variantsList').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function getColorEmoji(colorName) {
    const colorMap = {
        'black': '⚫', 'white': '⚪', 'red': '🔴', 'blue': '🔵',
        'green': '🟢', 'yellow': '🟡', 'orange': '🟠', 'purple': '🟣',
        'brown': '🟤', 'gray': '⚫', 'pink': '🌸', 'navy': '🔵'
    };
    const color = colorName.toLowerCase();
    for (let key in colorMap) {
        if (color.includes(key)) return colorMap[key];
    }
    return '🆕';
}

function previewNewVariantImages(variantIndex) {
    const input = document.getElementById('newVariantImages' + variantIndex);
    const preview = document.getElementById('newVariantPreview' + variantIndex);
    const counter = document.getElementById('newImageCounter' + variantIndex);
    const uploadBox = input.nextElementSibling;
    
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        uploadBox.classList.add('has-files');
        counter.style.display = 'flex';
        counter.querySelector('.count').textContent = input.files.length;
        
        const filesArray = Array.from(input.files);
        
        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'variant-preview-item';
                div.draggable = true;
                div.dataset.fileIndex = index;
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Image ${index + 1}">
                    <div class="preview-badge">${index + 1}</div>
                    <div class="preview-overlay">
                        <i class="icon-move"></i>
                    </div>
                `;
                preview.appendChild(div);
                
                if (index === filesArray.length - 1) {
                    makeImagesSortable('new' + variantIndex);
                }
            }
            reader.readAsDataURL(file);
        });
    } else {
        uploadBox.classList.remove('has-files');
        counter.style.display = 'none';
    }
}

function makeImagesSortable(variantId) {
    const preview = document.getElementById(variantId.includes('existing') ? 'existingPreview' + variantId.replace('existing', '') : 'newVariantPreview' + variantId.replace('new', ''));
    if (!preview) return;
    
    let draggedElement = null;
    
    preview.addEventListener('dragstart', function(e) {
        if (e.target.classList.contains('variant-preview-item')) {
            draggedElement = e.target;
            e.target.classList.add('dragging');
            e.target.style.opacity = '0.5';
        }
    });
    
    preview.addEventListener('dragend', function(e) {
        if (e.target.classList.contains('variant-preview-item')) {
            e.target.classList.remove('dragging');
            e.target.style.opacity = '1';
        }
    });
    
    preview.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(preview, e.clientX, e.clientY);
        if (draggedElement) {
            if (afterElement == null) {
                preview.appendChild(draggedElement);
            } else {
                preview.insertBefore(draggedElement, afterElement);
            }
        }
    });
    
    preview.addEventListener('drop', function() {
        updateBadgeNumbers(variantId);
        reorderFileInput(variantId);
    });
}

function getDragAfterElement(container, x, y) {
    const draggableElements = [...container.querySelectorAll('.variant-preview-item:not(.dragging)')];
    
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offsetX = x - box.left - box.width / 2;
        const offsetY = y - box.top - box.height / 2;
        const offset = Math.sqrt(offsetX * offsetX + offsetY * offsetY);
        
        if (offset < closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.POSITIVE_INFINITY }).element;
}

function updateBadgeNumbers(variantId) {
    const isExisting = variantId.includes('existing');
    const actualId = isExisting ? variantId.replace('existing', '') : variantId.replace('new', '');
    const preview = document.getElementById(isExisting ? 'existingPreview' + actualId : 'newVariantPreview' + actualId);
    const items = preview.querySelectorAll('.variant-preview-item');
    
    items.forEach((item, index) => {
        const badge = item.querySelector('.preview-badge');
        if (badge && !badge.classList.contains('new-badge')) {
            badge.textContent = index + 1;
        }
        item.dataset.fileIndex = index;
    });
}

function reorderFileInput(variantId) {
    const isExisting = variantId.includes('existing');
    const actualId = isExisting ? variantId.replace('existing', '') : variantId.replace('new', '');
    const input = document.getElementById(isExisting ? 'existingImages' + actualId : 'newVariantImages' + actualId);
    const preview = document.getElementById(isExisting ? 'existingPreview' + actualId : 'newVariantPreview' + actualId);
    const items = preview.querySelectorAll('.variant-preview-item');
    
    if (!input.files || input.files.length === 0) return;
    
    const filesArray = Array.from(input.files);
    const newOrder = Array.from(items).map(item => parseInt(item.dataset.fileIndex));
    const reorderedFiles = newOrder.map(index => filesArray[index]);
    
    const dataTransfer = new DataTransfer();
    reorderedFiles.forEach(file => {
        if (file) dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
}

function removeNewVariant(index) {
    if (confirm('Remove this variant? All uploaded images and data will be lost.')) {
        const variantCard = document.getElementById('newVariantCard' + index);
        variantCard.style.opacity = '0';
        variantCard.style.transform = 'scale(0.95)';
        setTimeout(() => variantCard.remove(), 300);
    }
}

function cartesianProduct(arrays) {
    return arrays.reduce((a, b) => 
        a.flatMap(d => b.map(e => [...d, e])), [[]]
    );
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.existing-variant').forEach(function(variantCard) {
        const variantId = variantCard.dataset.variantId;
        
        if (variantId) {
            const previewGrids = variantCard.querySelectorAll('.variant-preview-grid');
            
            if (previewGrids.length > 0) {
                const existingImagesGrid = previewGrids[0];
                
                if (existingImagesGrid.children.length > 0) {
                    makeExistingImagesSortable(existingImagesGrid, variantId);
                }
            }
        }
    });
});

function makeExistingImagesSortable(previewGrid, variantId) {
    let draggedElement = null;
    
    previewGrid.querySelectorAll('.variant-preview-item').forEach((item, index) => {
        item.draggable = true;
        item.dataset.imageIndex = index;
    });
    
    previewGrid.addEventListener('dragstart', function(e) {
        if (e.target.classList.contains('variant-preview-item')) {
            draggedElement = e.target;
            e.target.classList.add('dragging');
            e.target.style.opacity = '0.5';
        }
    });
    
    previewGrid.addEventListener('dragend', function(e) {
        if (e.target.classList.contains('variant-preview-item')) {
            e.target.classList.remove('dragging');
            e.target.style.opacity = '1';
            
            updateExistingImagesOrder(previewGrid, variantId);
        }
    });
    
    previewGrid.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(previewGrid, e.clientX, e.clientY);
        if (draggedElement) {
            if (afterElement == null) {
                previewGrid.appendChild(draggedElement);
            } else {
                previewGrid.insertBefore(draggedElement, afterElement);
            }
        }
    });
}

function updateExistingImagesOrder(previewGrid, variantId) {
    const items = previewGrid.querySelectorAll('.variant-preview-item');
    const newOrder = [];
    
    items.forEach((item, index) => {
        const badge = item.querySelector('.preview-badge:not(.new-badge)');
        if (badge) {
            badge.textContent = index + 1;
        }
        
        const img = item.querySelector('img');
        if (img) {
            const src = img.getAttribute('src');
            const filename = src.split('/').pop();
            newOrder.push(filename);
        }
    });
    
    fetch('/admin/variant/reorder-images/' + variantId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ order: newOrder })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Images reordered successfully');
        }
    })
    .catch(err => {
        console.error('Error reordering images:', err);
    });
}
</script>

<style>
/* Main Layout */
.variants-main-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 2px solid #0ea5e9;
}

/* Variants Intro */
.variants-intro {
    display: flex;
    gap: 20px;
    padding: 25px;
    background: white;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.variants-intro-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
    flex-shrink: 0;
    box-shadow: 0 8px 16px rgba(14, 165, 233, 0.3);
}

.variants-intro-content h4 {
    margin: 0 0 12px 0;
    font-size: 22px;
    color: #0c4a6e;
}

.variants-intro-content p {
    margin: 0 0 10px 0;
    color: #475569;
    line-height: 1.7;
}

.example-box {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    padding: 15px 20px;
    border-radius: 8px;
    margin-top: 15px;
}

.example-box strong {
    display: block;
    margin-bottom: 10px;
    color: #92400e;
    font-size: 15px;
}

.example-box ul {
    margin: 0;
    padding-left: 20px;
}

.example-box li {
    margin: 8px 0;
    color: #78350f;
}

/* Section Dividers */
.section-divider {
    display: flex;
    align-items: center;
    gap: 20px;
    margin: 40px 0 30px 0;
}

.section-divider-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(to right, transparent, #cbd5e1, transparent);
}

.section-divider-text {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    padding: 12px 24px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.section-divider-text i {
    font-size: 24px;
    color: #3b82f6;
}

/* Existing Variants Section */
.existing-variants-section {
    margin-bottom: 40px;
}

.existing-variant {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #f59e0b;
    position: relative;
}

.existing-variant::before {
    content: 'EXISTING';
    position: absolute;
    top: 15px;
    right: 15px;
    background: #f59e0b;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
    z-index: 10;
}

.existing-variant .variant-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

/* New Variants Section */
.new-variants-section {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 2px solid #3b82f6;
    border-radius: 16px;
    padding: 30px;
    margin-top: 30px;
}

.new-variant {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 2px solid #3b82f6;
    position: relative;
}

.new-variant::before {
    content: 'NEW';
    position: absolute;
    top: 15px;
    right: 15px;
    background: #10b981;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
    animation: pulse 2s infinite;
    z-index: 10;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

/* Step Indicator */
.step-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin: 30px 0;
    padding: 20px;
    background: white;
    border-radius: 12px;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    opacity: 0.4;
    transition: all 0.3s;
}

.step.active {
    opacity: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #e2e8f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    color: #64748b;
    transition: all 0.3s;
}

.step.active .step-number {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
}

.step-text {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

.step.active .step-text {
    color: #0c4a6e;
}

.step-arrow {
    font-size: 24px;
    color: #cbd5e1;
    font-weight: 300;
}

/* Attribute Selection */
.attribute-values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 12px;
}

.attribute-checkbox-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
}

.attribute-checkbox-item:hover {
    border-color: #0ea5e9;
    background: #f0f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
}

.attribute-checkbox-item input[type="checkbox"]:checked ~ .checkbox-label {
    font-weight: 700;
    color: #0284c7;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.color-preview {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 1px #cbd5e1, 0 2px 8px rgba(0,0,0,0.15);
}

/* Variants Container */
.variants-container {
    margin-top: 30px;
}

.variants-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 12px 12px 0 0;
}

.variants-header-content {
    display: flex;
    align-items: center;
    gap: 15px;
    color: white;
}

.variants-header-content i {
    font-size: 36px;
}

.variants-header h5 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
}

.variants-header p {
    margin: 5px 0 0 0;
    opacity: 0.95;
}

/* Variant Card */
.variant-card {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    margin-bottom: 25px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    transition: all 0.3s;
}

.variant-card:hover {
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.variant-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.variant-header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.variant-emoji {
    font-size: 32px;
}

.variant-label {
    display: block;
    font-size: 12px;
    opacity: 0.9;
    font-weight: 500;
    margin-bottom: 3px;
}

.variant-header h6 {
    margin: 0;
    font-size: 19px;
    font-weight: 700;
}

.btn-remove-variant {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
}

.btn-remove-variant:hover {
    background: #ef4444;
}

.variant-body {
    padding: 30px;
}

/* Variant Images */
.variant-images-main {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 3px solid #3b82f6;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 25px;
}

.images-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.images-header h5 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 8px 0;
    color: #1e3a8a;
    font-size: 18px;
    font-weight: 700;
}

.images-header i {
    color: #3b82f6;
    font-size: 24px;
}

.required-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #dc2626;
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
}

/* Upload Container */
.variant-upload-container {
    position: relative;
    margin-bottom: 20px;
}

.variant-file-input {
    display: none;
}

.variant-upload-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 50px 30px;
    border: 3px dashed #3b82f6;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
}

.variant-upload-box:hover {
    border-color: #2563eb;
    background: #eff6ff;
    transform: scale(1.02);
}

.variant-upload-box.has-files {
    border-color: #10b981;
    background: #d1fae5;
    border-style: solid;
}

.upload-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

.variant-upload-box.has-files .upload-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.upload-icon i {
    font-size: 40px;
    color: white;
}

.upload-content h6 {
    margin: 0 0 8px 0;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
}

.upload-content p {
    margin: 0 0 12px 0;
    font-size: 15px;
    color: #64748b;
}

.upload-formats {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 20px;
    font-size: 12px;
    color: #1e40af;
    font-weight: 600;
}

/* Image Counter */
.image-counter {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: #10b981;
    color: white;
    border-radius: 12px;
    font-weight: 700;
    margin-top: 15px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.image-counter i {
    font-size: 20px;
}

/* Preview Grid */
.variant-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.mt-2 {
    margin-top: 10px;
}

.mt-3 {
    margin-top: 15px;
}

.variant-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 16px;
    overflow: hidden;
    border: 4px solid #10b981;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    animation: fadeIn 0.3s ease;
    cursor: move;
    user-select: none;
}

.variant-preview-item:hover {
    transform: scale(1.02);
}

.variant-preview-item.dragging {
    opacity: 0.5;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.variant-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    background: #10b981;
    color: white;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    z-index: 5;
}

.new-badge {
    width: auto;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    letter-spacing: 0.5px;
}

.preview-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(16, 185, 129, 0.9) 0%, transparent 100%);
    padding: 12px;
    display: flex;
    justify-content: center;
    align-items: flex-end;
}

.preview-overlay i {
    color: white;
    font-size: 24px;
}

.preview-overlay i.icon-move::before {
    content: "⇄";
    font-size: 28px;
    font-weight: bold;
}

/* Delete Image Button */
.btn-delete-image {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 32px;
    height: 32px;
    background: #ef4444;
    border: 2px solid white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    z-index: 10;
    opacity: 0;
    transform: scale(0.8);
}

.variant-preview-item:hover .btn-delete-image {
    opacity: 1;
    transform: scale(1);
}

.btn-delete-image:hover {
    background: #dc2626;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
}

.btn-delete-image i {
    color: white;
    font-size: 16px;
}

/* Variant Details Section */
.variant-details-section {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 25px;
}

.section-subtitle {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 20px 0;
    font-size: 16px;
    color: #334155;
    font-weight: 700;
}

.section-subtitle i {
    color: #64748b;
    font-size: 20px;
}

.variant-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.variant-field {
    display: flex;
    flex-direction: column;
}

.variant-field label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1e293b;
}

.variant-field label i {
    color: #3b82f6;
    font-size: 18px;
}

.variant-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #cbd5e1;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s;
    background: white;
    font-weight: 500;
}

.variant-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    background: #eff6ff;
}

.variant-input::placeholder {
    color: #94a3b8;
}

/*Button Styles */
.tf-button.w208 {
    min-width: 208px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 28px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    transition: all 0.3s;
}

.tf-button.w208:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}

.tf-button i {
    font-size: 20px;
}

/* Animation for variant cards */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.variant-card {
    animation: slideInUp 0.4s ease;
}

/* Responsive Design */
@media (max-width: 992px) {
    .variants-intro {
        flex-direction: column;
    }
    
    .step-indicator {
        flex-wrap: wrap;
    }
    
    .step-arrow {
        display: none;
    }
    
    .section-divider {
        flex-direction: column;
        gap: 15px;
    }
    
    .section-divider-line {
        display: none;
    }
}

@media (max-width: 768px) {
    .attribute-values-grid {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    }
    
    .variant-details-grid {
        grid-template-columns: 1fr;
    }
    
    .variant-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .btn-remove-variant {
        width: 100%;
        justify-content: center;
    }
    
    .images-header {
        flex-direction: column;
        gap: 12px;
    }
    
    .variant-preview-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}

@media (max-width: 576px) {
    .variants-intro-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .variants-intro-content h4 {
        font-size: 18px;
    }
    
    .variant-upload-box {
        padding: 35px 20px;
    }
    
    .upload-icon {
        width: 60px;
        height: 60px;
    }
    
    .upload-icon i {
        font-size: 30px;
    }
}

/* Focus styles for accessibility */
input[type="checkbox"]:focus,
input[type="file"]:focus + label,
.variant-input:focus,
button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}
</style>
@endpush
@endsection