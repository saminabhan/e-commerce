@extends('layouts.app')

@section('title', 'Sami Store | Addresses')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title"><span>My</span> Addresses</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__addresses">
                    <a href="{{ route('addresses.create') }}" class="btn btn-primary mb-3">Add New Address</a>

                    @if($addresses->count())
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Address</th>
                                <th>Default</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{ $address->name }}</td>
                                    <td>{{ $address->phone }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->state }}</td>
                                    <td>{{ $address->address }}, {{ $address->locality }}</td>
                                    <td>{{ $address->is_default ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('addresses.edit', $address) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No addresses found.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
