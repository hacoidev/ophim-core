@php
$name = data_get($entry, $column['name']);
$origin_name = data_get($entry, $column['origin_name']);
$publish_year = data_get($entry, $column['publish_year']);
$episode_current = data_get($entry, $column['episode_current']);
$status = data_get($entry, $column['status']);
$movie_type = data_get($entry, $column['movie_type']);
$config_show_type = [
    'single' => [
        'class' => 'bg-secondary',
        'label' => 'Phim lẻ',
    ],
    'series' => [
        'class' => 'bg-primary',
        'label' => 'Phim bộ',
    ],
];
$config_show_status = [
    'trailer' => [
        'class' => 'bg-warning',
        'label' => 'Trailer',
    ],
    'ongoing' => [
        'class' => 'bg-info',
        'label' => 'Đang chiếu',
    ],
    'completed' => [
        'class' => 'bg-success',
        'label' => 'Hoàn thành',
    ],
];
@endphp
<div class="">
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    <div class="text-primary pb-2">{{ $name }} <span class="text-success">[{{ $publish_year }}]</span></div>
    <div class="text-muted pb-2"><small>({{ $origin_name }}) <span class="text-danger">[{{ $episode_current }}]</span></small></div>
    <div class="badge {{ $config_show_type[$movie_type]['class'] }} font-weight-normal">{{ $config_show_type[$movie_type]['label'] }}</div>
    <div class="badge {{ $config_show_status[$status]['class'] }} font-weight-normal">{{ $config_show_status[$status]['label'] }}</div>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</div>
