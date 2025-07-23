@extends('layouts.admin')
@section('title', 'Add Slider')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slider Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.slider.index') }}">
                        <div class="text-tiny">Sliders</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">New Slider</div></li>
            </ul>
        </div>
        <!-- new-slider -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Title (Optional)</div>
                    <input class="flex-grow" type="text" placeholder="Slider title" name="title" tabindex="0" value="{{ old('title') }}">
                </fieldset>
                @error('title') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Link (Optional)</div>
                    <input class="flex-grow" type="text" placeholder="Slider link" name="link" tabindex="0" value="{{ old('link') }}">
                </fieldset>
                @error('link') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="#" class="effect8" alt="Preview Image">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="sliderImage">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="sliderImage" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                
                <fieldset class="form-check" style="margin-top:1rem;">
                        <label for="is_active" class="body-title">Active</label>
                        <input type="checkbox" name="is_active" id="is_active" 
                            {{ old('is_active') ? 'checked' : '' }}>
                </fieldset>           
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("#sliderImage").on("change", function () {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
    });
</script>
@endpush
