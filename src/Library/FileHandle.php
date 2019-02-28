<?php
/**
 * Created by PhpStorm.
 * User: ChenHua <chenhua@hfax.com>
 * Date: 2019/2/28
 * Time: 16:31
 */

namespace Chenhua\FileUpload\Library;

use OSS\OssClient;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use Exception;

class FileHandle
{
    protected static $config;
    static $_url = [];
    static $real_path = '';

    public static function upload($request)
    {
        try {
            $section      = $request->get('section', 'default');
            self::$config = config('vendor.file_upload.' . $section);

            $fileId = self::$config['file_id'];
            if (!$request->hasFile($fileId)) {
                throw new Exception('没有找到要上传的文件.');
            }

            $file = $request->file($fileId);
            if (!$file->isValid()) {
                throw new Exception('上传的文件非法.');
            }

            $path = array_get(self::$config, 'disks.local.prefix');
            if (!$path) {
                throw new Exception('没有设置上传文件的本地目录.');
            }

            $newName = date('Ymd-His') . '-' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            //本地保存
            $file->move($path, $newName);
            self::$_url['local'] = asset($path . '/' . $newName);
            //本地保存绝对路径
            self::$real_path = $path . '/' . $newName;

            //同步到七牛
            if (in_array('qiniu', array_get(self::$config, 'dirver'))) {
                self::_qiniu();
            }

            //同步到阿里云
            if (in_array('aliyun', array_get(self::$config, 'dirver'))) {
                self::_aliyun();
            }

            return self::$_url;
        } catch (Exception $e) {
            throw $e;
        }
    }

    //上传到七牛云
    private static function _qiniu()
    {
        try {
            $qiniu_config = array_get(self::$config, 'disks.qiniu');
            if (!$qiniu_config)
                throw new Exception("七牛配置信息有误.");
            //参数设置
            $accessKey  = $qiniu_config['access_key'];
            $secretKey  = $qiniu_config['secret_key'];
            $bucketName = $qiniu_config['bucket'];
            $domain     = $qiniu_config['domain'];
            //上传七牛后的文件名
            $file_name = $qiniu_config['prefix'] . basename(self::$_url['local']);
            $upManager = new UploadManager();
            $auth      = new Auth($accessKey, $secretKey);
            $token     = $auth->uploadToken($bucketName);
            list($ret, $error) = $upManager->putFile($token, $file_name, self::$real_path);
            if ($error) {
                throw new Exception('七牛上传文件失败.');
            } else {
                self::$_url['qiniu'] = $domain . '/' . $ret['key'];
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //上传到阿里云
    private static function _aliyun()
    {
        try {
            $aliyun_config = array_get(self::$config, 'disks.aliyun');
            if (!$aliyun_config)
                throw new Exception("阿里云配置信息有误.");
            //通过配置项初始化oss设置
            $accessKeyId     = $aliyun_config['ak_id'];
            $accessKeySecret = $aliyun_config['ak_secret'];
            $endpoint        = $aliyun_config['end_point'];
            $bucket          = $aliyun_config['bucket'];
            //上传阿里云后的文件名
            $object = $aliyun_config['prefix'] . basename(self::$_url['local']);
            //实例化阿里云处理类
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $result    = $ossClient->uploadFile($bucket, $object, self::$real_path);
            if (isset($result['info']['url'])) {
                self::$_url['aliyun'] = $result['info']['url'];
            } else {
                throw new Exception('阿里云上传文件失败.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}