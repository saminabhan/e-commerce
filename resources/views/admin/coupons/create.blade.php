@extends('layouts.admin')
@section('title', 'Add Coupon')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Coupon</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.coupons.index') }}"><div class="text-tiny">Coupons</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add Coupon</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="form-new-product form-style-1">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input type="text" name="code" placeholder="Coupon Code" value="{{ old('code') }}" required>
                </fieldset>
                @error('code') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Discount <span class="tf-color-1">*</span></div>
                    <input type="number" name="discount" placeholder="Discount amount" value="{{ old('discount') }}" step="0.01" min="0" required>
                </fieldset>
                @error('discount') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Type <span class="tf-color-1">*</span></div>
                    <select name="type" required>
                        <option value="">Select Type</option>
                        <option value="fixed" {{ old('type')=='fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="percent" {{ old('type')=='percent' ? 'selected' : '' }}>Percent</option>
                    </select>
                </fieldset>
                @error('type') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <div class="bot" style="margin-top: 1rem;">
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
