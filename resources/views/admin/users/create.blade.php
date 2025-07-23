@extends('layouts.admin')
@section('title', 'Add User')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center justify-between gap20 mb-27">
            <h3>Add User</h3>
        </div>

        <div class="wg-box">
            <form action="{{ route('admin.users.store') }}" method="POST" class="form-style-1">
                @csrf

                <fieldset>
                    <div class="body-title">Name *</div>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Email *</div>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Mobile *</div>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" required>
                    @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Password *</div>
                    <input type="password" name="password" required>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Confirm Password *</div>
                    <input type="password" name="password_confirmation" required>
                </fieldset>

                <fieldset>
                    <div class="body-title">User Type *</div>
                    <select name="utype" required>
                        <option value="USR" {{ old('utype') == 'USR' ? 'selected' : '' }}>User</option>
                        <option value="ADM" {{ old('utype') == 'ADM' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('utype') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <div class="mt-3">
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
