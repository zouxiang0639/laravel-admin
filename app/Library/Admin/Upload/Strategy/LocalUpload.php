<?php
namespace App\Library\Admin\Upload\Strategy;

class LocalUpload
{

    public function get()
    {

        return [
            'show' => 'local',
            'imageUrl' => \Storage::disk('admin')->url(''),
            'url' => route('m.system.upload.image')
        ];
    }
}
