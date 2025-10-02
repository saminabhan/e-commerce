@extends('layouts.admin')
@section('title', 'Product Attributes')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Product Attributes</h3>
            <button class="tf-button" onclick="showAddAttributeModal()">
                <i class="icon-plus"></i> Add Attribute
            </button>
        </div>

        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Attributes List -->
        <div class="wg-box">
            @forelse($attributes as $attribute)
            <div class="attribute-section mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h5>{{ $attribute->name }} <span class="badge">({{ ucfirst($attribute->type) }})</span></h5>
                    <div class="flex gap-2">
                        <button class="tf-button style-1" onclick="showAddValueModal({{ $attribute->id }}, '{{ $attribute->type }}')">
                            Add Value
                        </button>
                        <form action="{{ route('admin.attributes.delete', $attribute->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this attribute and all its values?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tf-button style-2">Delete</button>
                        </form>
                    </div>
                </div>
                
                <div class="attribute-values flex gap-2 flex-wrap">
                    @forelse($attribute->values as $value)
                    <div class="attribute-value-item">
                        @if($attribute->type === 'color')
                        <span class="color-box" style="background: {{ $value->color_code }}"></span>
                        @endif
                        <span>{{ $value->value }}</span>
                        <form action="{{ route('admin.attributes.value.delete', $value->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Delete this value?')">×</button>
                        </form>
                    </div>
                    @empty
                    <p class="text-muted">No values added yet</p>
                    @endforelse
                </div>
            </div>
            <hr>
            @empty
            <p class="text-center">No attributes found. Add your first attribute!</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal: Add Attribute -->
<div id="addAttributeModal" class="modal" style="display:none">
    <div class="modal-content">
        <h4>Add New Attribute</h4>
        <form action="{{ route('admin.attributes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Attribute Name</label>
                <input type="text" name="name" placeholder="e.g., Color, Size, Storage" required>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="color">Color (with color picker)</option>
                    <option value="text">Text (e.g., Size, Storage)</option>
                </select>
            </div>
          
            <div class="flex gap-2">
                <button type="submit" class="tf-button">Save</button>
                <button type="button" class="tf-button style-2" onclick="closeModal('addAttributeModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Value -->
<div id="addValueModal" class="modal" style="display:none">
    <div class="modal-content">
        <h4>Add Attribute Value</h4>
        <form action="{{ route('admin.attributes.value.store') }}" method="POST">
            @csrf
            <input type="hidden" name="attribute_id" id="attribute_id">

            <div class="form-group" id="valueField">
                <label>Value</label>
                <input type="text" name="value" id="valueInput" placeholder="e.g., Red, 64GB, Large" required>
            </div>

            <div class="form-group" id="colorField" style="display:none">
                <label>Color Code</label>
                <input type="color" name="color_code" id="colorInput">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="tf-button">Save</button>
                <button type="button" class="tf-button style-2" onclick="closeModal('addValueModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
.attribute-section {
    padding: 15px;
    background: #fafafa;
    border-radius: 8px;
}
.badge {
    font-size: 12px;
    padding: 3px 8px;
    background: #e0e0e0;
    border-radius: 3px;
}
.attribute-value-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.color-box {
    width: 20px;
    height: 20px;
    border-radius: 3px;
    border: 1px solid #ccc;
}
.btn-delete {
    background: #ff4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    line-height: 1;
}
.btn-delete:hover {
    background: #cc0000;
}

.modal {
    position: fixed;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.5);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index: 1000;
}
.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    min-width: 400px;
    max-width: 500px;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}
.form-group input,
.form-group select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.alert {
    padding: 12px 20px;
    margin-bottom: 20px;
    border-radius: 5px;
}
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.text-muted {
    color: #999;
    font-style: italic;
}
</style>

<script>
function showAddAttributeModal() {
    document.getElementById('addAttributeModal').style.display = 'flex';
}

function showAddValueModal(attributeId, type) {
    document.getElementById('attribute_id').value = attributeId;
    
    // Reset form
    document.getElementById('valueInput').value = '';
    document.getElementById('colorInput').value = '#000000';

    if (type === 'color') {
        document.getElementById('colorField').style.display = 'block';
        document.getElementById('valueField').querySelector('input').placeholder = 'e.g., Red, Blue, Green';
    } else {
        document.getElementById('colorField').style.display = 'none';
        document.getElementById('valueField').querySelector('input').placeholder = 'e.g., 64GB, Large, XL';
    }

    document.getElementById('addValueModal').style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

@endsection