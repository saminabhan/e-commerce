<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">Order Summary</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Subtotal
                <span>${{ number_format($subTotal, 2) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                VAT
                <span>${{ number_format($vat, 2) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                Total
                <span>${{ number_format($total, 2) }}</span>
            </li>
        </ul>
    </div>
</div>
