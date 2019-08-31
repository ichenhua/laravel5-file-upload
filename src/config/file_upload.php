<?php
return [
    "default" => [
        "file_id" => "file",
        "url_format" => 'local', //返回存储位置url
        "ret_format" => 'default', //上传返回格式
        "dirver"  => ['local'], //存储平台
        "disks"   => [
            "local"  => [
                'prefix' => 'uploads', //本地存储目录
            ],
            "qiniu"  => [
                'access_key' => '',
                'secret_key' => '',
                'bucket'     => '',
                'prefix'     => '',
                'domain'     => ''
            ],
            "aliyun" => [
                'ak_id'     => '',
                'ak_secret' => '',
                'end_point' => '',
                'bucket'    => '',
                'prefix'    => '',
            ],
        ],
    ],
    "kindeditor" => [
        "file_id" => "imgFile",
        "url_format" => 'local', //返回存储位置url
        "ret_format" => 'kindeditor', //上传返回格式
        "dirver"  => ['local'], //存储平台
        "disks"   => [
            "local"  => [
                'prefix' => 'uploads', //本地存储目录
            ],
            "qiniu"  => [
                'access_key' => '',
                'secret_key' => '',
                'bucket'     => '',
                'prefix'     => '',
                'domain'     => ''
            ],
            "aliyun" => [
                'ak_id'     => '',
                'ak_secret' => '',
                'end_point' => '',
                'bucket'    => '',
                'prefix'    => '',
            ],
        ],
    ],
];