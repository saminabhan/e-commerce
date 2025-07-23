@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center justify-between gap20 mb-27">
            <h3>Edit User</h3>
        </div>

        <div class="wg-box">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form-style-1">
                @csrf
                @method('PUT')

                <fieldset>
                    <div class="body-title">Name *</div>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Email *</div>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Mobile *</div>
                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                    @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Password (leave blank if unchanged)</div>
                    <input type="password" name="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Confirm Password</div>
                    <input type="password" name="password_confirmation">
                </fieldset>

                <fieldset>
                    <div class="body-title">User Type *</div>
                    <select name="utype" required>
                        <option value="USR" {{ $user->utype == 'USR' ? 'selected' : '' }}>User</option>
                        <option value="ADM" {{ $user->utype == 'ADM' ? 'selected' : '' }}>Admin</option>
                    </select>
                </fieldset>

                <div class="mt-3">
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
