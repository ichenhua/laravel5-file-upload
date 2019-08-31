Laravel5-FileUpload
---------
Laravel5-FileUpload 是用于 Kindeditor/Summernote 等富文本在线HTMl编辑器的图片上传组件，支持 Laravel5 项目。已集成本地、七牛云、阿里云文件存储。

## 更新记录

* 2019-08-31 `Release v1.1.0` 修复 KindEditor 上传漏洞，配置文件添加返回格式参数控制。
* 2019-02-28 `Release v1.0.0` 完成 KindEditor/Summernote 在线编辑器主程序，且集成本地、七牛、阿里云oss存储。

## 安装流程

1、安装的两种方式

① 直接编辑配置文件

将以下内容增加到 composer.json：

```json
require: {
    "chenhua/laravel5-file-upload": "~1.0"
}
```

然后运行 `composer update`。

② 执行命令安装

运行命令：

```bash
composer require chenhua/laravel5-file-upload
```

2、完成上面的操作后，修改 `config/app.php` 中 `providers` 数组（laravel5.5以上忽略）

```php
Chenhua\FileUpload\FileUploadServiceProvider::class,
```

3、执行 `artisan` 命令，生成 `config/vendor/editor.php` 配置文件

```bash
php artisan vendor:publish --tag=file_upload
```

4、修改 `config/vendor/editor.php` 配置文件

```bash
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
```
> 七牛和阿里云的配置内容，需要去对应官网申请账号并配置获取，此处省略一万字。。。

## License
本扩展遵循 [MIT license](http://opensource.org/licenses/MIT) 开源。


