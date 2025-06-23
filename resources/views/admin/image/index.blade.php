@extends('admin.layouts.master') 
@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ __('admin.Image') }}</h1>
  </div>

  <div class="card card-primary">
    <div class="card-header">
      <h4>{{ __('Upload Image') }}</h4>
    </div>
    <div class="card-body">
      <form
        action="{{ route('admin.image.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4"
      >
        @csrf
        <div class="form-group">
          <label for="image">{{ __('admin.Image') }}</label>
          <div id="image-preview" class="image-preview">
            <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
            <input type="file" name="image" id="image-upload" />
          </div>
          @error('image')
          <p class="text-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label for="title">{{ __('admin.Title') }}</label>
          <input name="title" type="text" class="form-control" id="title" />
          @error('title')
          <p class="text-danger">{{ $message }}</p>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
      </form>
    </div>
  </div>

  <!-- Grid Display -->
  <div class="card">
    <div class="card-header">
      <h4>Gallery <code>.gallery-md</code></h4>
    </div>
    <div class="card-body">
      <div class="gallery gallery-md" style="max-height: 500px; overflow-y: auto;">
        @foreach ($images as $image)
          <div class="gallery-item" 
               data-image="{{ $image->path }}" 
               data-title="{{ $image->title }}" 
               href="{{ $image->path }}" 
               title="{{ $image->title }}" 
               style="background-image: url('{{ $image->path }}'); position: relative;">
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@push('scripts')
@endpush 
@endsection
