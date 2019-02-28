<?php
/**
 * Created by PhpStorm.
 * User: ChenHua <chenhua@hfax.com>
 * Date: 2019/2/28
 * Time: 16:31
 */

namespace Chenhua\FileUpload\Controllers;

use Chenhua\FileUpload\Library\FileHandle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FileHandleController extends BaseController
{
    public function upload(Request $request)
    {
        $section = $request->get('section', 'default');
        try {
            $urlArr  = FileHandle::upload($request);
            return $this->formatRes('SUCCESS', $section, $urlArr);
        } catch (\Exception $e) {
            $err_msg = $e->getMessage();
            return $this->formatRes('ERROR', $section, [], $err_msg);
        }
    }

    public function formatRes($option, $section, $urlArr = [], $message = '')
    {
        $url_key   = config('vendor.file_upload.' . $section . '.url_format');
        $retStruct = [];
        switch ($section) {
            case 'default':
                $retStruct = [
                    'err_code' => $option == 'SUCCESS' ? 0 : 1,
                    'err_msg'  => $message,
                    'data'     => [
                        'url' => $urlArr[$url_key] ?? ''
                    ]
                ];
                break;
            case 'kindeditor':
                $retStruct = [
                    'error'   => $option == 'SUCCESS' ? 0 : 1,
                    'message' => $message,
                    'url'     => $urlArr[$url_key] ?? ''
                ];
                break;
        }
        return response()->json($retStruct);
    }
}