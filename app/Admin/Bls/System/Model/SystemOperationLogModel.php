<?php
namespace App\Admin\Bls\System\Model;

use App\Admin\Bls\Auth\Model\AdministratorModel;
use Illuminate\Database\Eloquent\Model;
use App\Bls\Admin\Model\User;


class SystemOperationLogModel extends Model
{
    protected $table = 'admin_system_operation_log';


    /**
     * 操作人
     */
    public function operators()
    {
        return $this->belongsTo(AdministratorModel::class, 'operator');
    }


}
