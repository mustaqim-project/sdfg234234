@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.News') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.Update News') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="language">{{ __('admin.Language') }}</label>
                    <select name="language" id="language-select" class="form-control select2">
                        <option value="">--{{ __('admin.Select') }}--</option>
                        @foreach ($languages as $lang)
                            <option {{ $lang->lang === $news->language ? 'selected' : '' }} value="{{ $lang->lang }}">
                                {{ $lang->name }}</option>
                        @endforeach
                    </select>
                    @error('language')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">{{ __('admin.Category') }}</label>
                    <select name="category" id="category" class="form-control select2">
                        <option value="">--{{ __('admin.Select') }}---</option>
                        @foreach ($categories as $category)
                            <option {{ $category->id === $news->category_id ? 'selected' : '' }} value="{{ $category->id }}">
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">{{ __('admin.Image') }}</label>
                    <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
                        <input type="file" name="image" id="image-upload">
                    </div>
                    @error('image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                

                <div class="form-group">
                    <label for="title">{{ __('admin.Title') }}</label>
                    <input name="title" value="{{ $news->title }}" type="text" class="form-control" id="title">
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">{{ __('admin.Content') }}</label>
                    <textarea name="content" id="content">{{ $news->content }}</textarea>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">{{ __('admin.Tags') }}</label>
                    <input name="tags" type="text" value="{{ formatTags($news->tags()->pluck('name')->toArray()) }}" class="form-control inputtags">
                    @error('tags')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="meta_keyword">{{ __('Keyword') }}</label>
                    <input name="meta_keyword" type="text" value="{{ $news->meta_keyword }}" class="form-control inputtags" id="meta_keyword">
                    @error('meta_keyword')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="meta_title">{{ __('admin.Meta Title') }}</label>
                    <input name="meta_title" value="{{ $news->meta_title }}" type="text" class="form-control" id="meta_title">
                    @error('meta_title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description">{{ __('admin.Meta Description') }}</label>
                    <textarea name="meta_description" class="form-control">{{ $news->meta_description }}</textarea>
                    @error('meta_description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="scheduled_at">{{ __('Scheduled At') }}</label>
                    <input name="scheduled_at" type="datetime-local" class="form-control" id="scheduled_at" 
                        value="{{ $news->scheduled_at ? \Carbon\Carbon::parse($news->scheduled_at)->format('Y-m-d\TH:i') : '' }}">
                    @error('scheduled_at')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>


                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="control-label">{{ __('admin.Status') }}</div>
                            <label class="custom-switch mt-2">
                                <input {{ $news->status === 1 ? 'checked' : '' }} value="1" type="checkbox" name="status" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>

                    @if (canAccess(['news status', 'news all-access']))
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('admin.Is Breaking News') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $news->is_breaking_news == 1 ? 'checked' : '' }} value="1" type="checkbox" name="is_breaking_news" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('admin.Show At Slider') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $news->show_at_slider === 1 ? 'checked' : '' }} value="1" type="checkbox" name="show_at_slider" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('admin.Show At Popular') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $news->show_at_popular === 1 ? 'checked' : '' }} value="1" type="checkbox" name="show_at_popular" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{ __('admin.Update') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<script>

    $(document).ready(function() {

        $('#language-select').on('change', function() {
            let lang = $(this).val();
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.fetch-news-category') }}",
                data: {
                    lang: lang
                },
                success: function(data) {
                    $('#category').html("");
                    $('#category').html(
                        `<option value="">---{{ __('admin.Select') }}---</option>`);

                    $.each(data, function(index, data) {
                        $('#category').append(
                            `<option value="${data.id}">${data.name}</option>`)
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })
    })
</script>
@endpush
