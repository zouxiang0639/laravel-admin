<?php

namespace App\Admin\Bls\System\Model;

use App\Admin\Bls\Auth\Model\AdministratorModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Created by TagsModel.
 * @author: zouxiang
 * @date:
 */
class TagsModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_tags';

    protected $dates = ['deleted_at'];


    /**
     * 操作人
     */
    public function oneParent()
    {
        return $this->belongsTo(TagsModel::class, 'parent_id');
    }

}
