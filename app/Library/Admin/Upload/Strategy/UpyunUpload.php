<?php
namespace App\Library\Admin\Upload\Strategy;

class UpyunUpload
{

    public function get()
    {
        //又拍云认证
        //配置参数
        $bucket = config("upload.upyun_bucket");//又拍云的服务名
        //$form_api_secret = 'form_api_secret';//表单密钥：后台——>空间——>通用——>基本设置
        $operator = config("upload.upyun_operator"); //授权的操作员
        $password = md5(config("upload.upyun_password")); // 授权的操作员密码

        $GMTdate = gmdate('D, d M Y H:i:s') . ' GMT';
        $method = 'POST';
        $URI = '/'.$bucket;
        $options = array();
        $options['bucket'] = $bucket;
        $options['expiration'] = time()+3600;
        $options['save-key'] = '/{year}/{mon}/{day}/{filemd5}{.suffix}';//save-key 详细说明可以看官方文档
        $options['date'] = $GMTdate;
        $policy = base64_encode(json_encode($options));//policy 生成
        $str = $method.'&'.$URI.'&'.$GMTdate.'&'.$policy;
        $signature = base64_encode(hash_hmac('sha1',$str, $password, true));
        $authorization = "UPYUN {$operator}:{$signature}";

        return [
            'show' => 'upyun',
            'authorization' => $authorization,
            'policy' => $policy,
            'bucket' => $bucket,
            'imageUrl' => config("upload.upyun_domain"),
            'url' => 'http://v0.api.upyun.com/' . $bucket
        ];
    }


}
