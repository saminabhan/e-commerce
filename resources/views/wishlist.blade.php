@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
      <div class="shopping-cart">
       @if ($items->count() > 0)
    <div class="cart-table__wrapper" id="wishlist-table-wrapper">
        <table class="cart-table" id="wishlist-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th></th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="wishlist-table-body">
                @foreach ($items as $item)
                <tr id="wishlist-row-{{ $item->id }}">
    <td>
        <div class="shopping-cart__product-item">
            <img loading="lazy" src="{{ asset('uploads/products/' . $item->product->image) }}" width="120" height="120" alt="{{ $item->product_name }}" />
        </div>
    </td>
    <td>
        <div class="shopping-cart__product-item__detail">
            <h4>{{ $item->product_name }}</h4>
        </div>
    </td>
    <td>
        <span class="shopping-cart__product-price">
            ${{ number_format($item->current_price, 2) }}
        </span>
    </td>
    <td>
        {{ $item->quantity }}
    </td>
    <td>
        <form method="POST" class="js-wishlist-remove-form" 
              action="{{ route('wishlist.item.remove', ['rowId' => $item->id]) }}"
              data-row-id="{{ $item->id }}">
            @csrf
            @method('DELETE')
            <a href="javascript:void(0)" class="remove-cart js-remove-wishlist">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                </svg>
            </a>
        </form>
    </td>
</tr>
                @endforeach
            </tbody>
        </table>
        <div class="cart-table-footer" id="wishlist-footer">
            <form method="POST" action="{{ route('wishlist.items.empty') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-light" type="submit">CLEAR WISHLIST</button>
            </form>
        </div>
    </div>
@else
    <div class="row" id="empty-wishlist-message">
        <div class="col-md-12 text-center pt-5 pb-5">
            <p>No item found in your Wishlist</p>
            <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
        </div>
    </div>
@endif
      </div>
    </section>
  </main>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    function showWishlistToast(message, isError = false) {
        const oldToasts = document.querySelectorAll('.wishlist-toast');
        oldToasts.forEach(toast => toast.remove());
        
        const toast = document.createElement('div');
        toast.innerText = message;
        toast.className = `wishlist-toast ${isError ? 'error' : 'success'}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    document.querySelectorAll('.js-remove-wishlist').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const form = this.closest('.js-wishlist-remove-form');
            const rowId = form.dataset.rowId;
            const rowElement = document.getElementById(`wishlist-row-${rowId}`);

            try {
                const response = await fetch(form.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    
                    rowElement.style.transition = 'all 0.3s ease';
                    rowElement.style.opacity = '0';
                    rowElement.style.height = '0';
                    rowElement.style.padding = '0';
                    rowElement.style.margin = '0';
                    rowElement.style.overflow = 'hidden';
                    
                    setTimeout(() => {
                        rowElement.remove();
                        
                        if (document.querySelectorAll('#wishlist-table tbody tr').length === 0) {
                            document.querySelector('#wishlist-table tbody').innerHTML = `
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p>Your wishlist is empty</p>
                                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
                                    </td>
                                </tr>
                            `;
                        }
                    }, 300);
                    
                    updateWishlistCount(result.wishlistCount);
                    
                    showWishlistToast('Removed from Wishlist');
                } else {
                    showWishlistToast('Failed to remove item', true);
                }
            } catch (err) {
                console.error(err);
                showWishlistToast('Network error', true);
            }
        });
    });

    function updateWishlistCount(newCount) {
        const countElements = document.querySelectorAll('.wishlist-count, #wishlist-count, .js-wishlist-count');
        
        countElements.forEach(element => {
            element.textContent = newCount;
            element.style.display = newCount > 0 ? 'inline-block' : 'none';
        });
    }
});
</script>
@endpush