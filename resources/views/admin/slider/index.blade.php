@extends('layouts.admin')
@section('title', 'Sliders')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Sliders</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Sliders</div></li>
            </ul>
        </div>

        @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.slider.create') }}" class="btn btn-success tf-button w208">Add New Slider</a>
        </div>

        <div class="wg-box">
            <div class="overflow-auto">
                <table class="table table-bordered text-center min-w-full">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td><img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" width="100"></td>
                                <td>{{ $slider->title ?? '—' }}</td>
                                <td>{{ $slider->link ?? '—' }}</td>
                                <td>
                                    @if($slider->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST" class="d-inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No sliders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function(){
        $('.delete-btn').on('click', function(e){
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this slider!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
