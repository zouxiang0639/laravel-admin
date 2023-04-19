<?php
return [
    "upload_drive" => env('UPLOAD_DRIVE','local'), //local 是本地 upyun是又拍云

    "upyun_bucket" => env('UPYUN_BUCKET'), //目录
    "upyun_operator" => env('UPYUN_OPERATOR'), //操作人
    "upyun_password" => env('UPYUN_PASSWORD'), //又拍云密码
    "upyun_domain" => env('UPYUN_DOMAIN'), //又拍云地址
];
