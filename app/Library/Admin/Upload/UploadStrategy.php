<?php
namespace App\Library\Admin\Upload;

use App\Exceptions\LogicException;
use App\Library\Admin\Upload\Strategy\LocalUpload;
use App\Library\Admin\Upload\Strategy\UpyunUpload;

/**
 * 上传策略
 * @author zouxiang
 * Date 2018年6月7日
 */
class UploadStrategy
{
    private $_correctStrategy;

    /**
     * 构造函数
     * @param integer $type 批改类型
     */
    public function __construct($type)
    {
        switch ($type) {
            case 'local' :  //本地上传
                $this->_correctStrategy = new LocalUpload();
                break;
            case 'upyun' : //upyun是又拍云
                $this->_correctStrategy = new UpyunUpload();
                break;
            default:
                throwException(new LogicException('没有这个批改类型！'));
                break;
        }
    }

    public function get()
    {
        return $this->_correctStrategy->get();
    }


}
