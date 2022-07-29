@php
$value = isset($field) ? old_empty_or_null($field['name'], '') ?? ($field['value'] ?? null) : null;
@endphp

@php
$progress = [
    'episodes' => 'Tập mới',
    'status' => 'Trạng thái phim',
    'episode_time' => 'Thời lượng tập phim',
    'episode_current' => 'Số tập phim hiện tại',
    'episode_total' => 'Tổng số tập phim',
];

$info = [
    'name' => 'Tên phim',
    'origin_name' => 'Tên gốc phim',
    'content' => 'Mô tả nội dung phim',
    'thumb_url' => 'Ảnh Thumb',
    'poster_url' => 'Ảnh Poster',
    'trailer_url' => 'Trailer URL',
    'quality' => 'Chất lượng phim',
    'language' => 'Ngôn ngữ',
    'notify' => 'Nội dung thông báo',
    'showtimes' => 'Giờ chiếu phim',
    'publish_year' => 'Năm xuất bản',
    'is_shown_in_theater' => 'Đánh dấu phim chiếu rạp',
    'is_copyright' => 'Đánh dấu có bản quyền',
];

$relations = [
    'type' => 'Định dạng phim',
    'actors' => 'Diễn viên',
    'directors' => 'Đạo diễn',
    'categories' => 'Thể loại',
    'regions' => 'Khu vực',
    'tags' => 'Từ khóa',
    'studios' => 'Studio',
];
@endphp

<div class="px-3 py-2">
    <div class="row mb-3">
        <div class="col-12 px-0">
            <input class="checkall" data-target="progress-checkbox" id="progress-all" type="checkbox" checked>
            <label for="progress-all">Tiến độ phim</label>
        </div>
        @foreach ($progress as $key => $option)
            <div class="col-12 col-md-6 form-check checkbox">
                <input class="form-check-input progress-checkbox" id="progress-{{ $loop->index }}" type="checkbox"
                    name="fields[]" value="{{ $key }}" @if (is_null($value) || in_array($key, $value)) checked @endif>
                <label class="d-inline" for="progress-{{ $loop->index }}">{{ $option }}</label>
            </div>
        @endforeach
    </div>
    <div class="row mb-3">
        <div class="col-12 px-0">
            <input class="checkall" data-target="info-checkbox" id="info-all" type="checkbox" checked>
            <label for="info-all">Thông tin phim</label>
        </div>
        @foreach ($info as $key => $option)
            <div class="col-12 col-md-6 form-check checkbox">
                <input class="form-check-input info-checkbox" id="info-{{ $loop->index }}" type="checkbox"
                    name="fields[]" value="{{ $key }}" @if (is_null($value) || in_array($key, $value)) checked @endif>
                <label class="d-inline" for="info-{{ $loop->index }}">{{ $option }}</label>
            </div>
        @endforeach
    </div>
    <div class="row mb-3">
        <div class="col-12 px-0">
            <input class="checkall" data-target="relation-checkbox" id="relation-all" type="checkbox" checked>
            <label for="relation-all">Phân loại</label>
        </div>
        @foreach ($relations as $key => $option)
            <div class="col-12 col-md-6 form-check">
                <input class="form-check-input relation-checkbox" id="relation-{{ $loop->index }}" type="checkbox"
                    name="fields[]" value="{{ $key }}" @if (is_null($value) || in_array($key, $value)) checked @endif>
                <label class="d-inline" for="relation-{{ $loop->index }}">{{ $option }}</label>
            </div>
        @endforeach
    </div>

</div>

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <script>
        $('.checkall').change(function() {
            $(`.${$(this).data('target')}`).prop('checked', this.checked);
        })
    </script>
@endpush
