<?php
namespace Chenhua\FileUpload;

/**
 * Created by PhpStorm.
 * Author: ChenHua <http://www.ichenhua.cn>
 * Date: 2018/6/14 19:04
 */

use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Route::post('file_upload', 'Chenhua\FileUpload\Controllers\FileHandleController@upload')->name('file.upload');

        $this->publishes([
            __DIR__.'/config/file_upload.php' => base_path('config/vendor/file_upload.php'),
        ], 'file_upload');
    }
}
