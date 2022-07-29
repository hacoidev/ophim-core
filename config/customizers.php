<?php

return [
    'default' => [
        'name' => 'Default theme\'s customizer',
        'fields' => [
            [
                'name' => 'latest',
                'label' => 'Danh sách mới cập nhật',
                'type' => 'textarea',
                'hint' => 'display_label:relation:find_by_field:value:limit:show_more_url',
            ],
            [
                'name' => 'hotest',
                'label' => 'Danh sách hot',
                'type' => 'textarea',
                'hint' => 'display_label:relation:find_by_field:value:sort_by_field:sort_algo:limit',
            ],
        ]
    ],

];
