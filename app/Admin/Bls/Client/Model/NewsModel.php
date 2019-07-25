<?php

namespace App\Admin\Bls\Client\Model;

use App\Library\Database\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_news';

    protected $casts = [
        'extend' => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get parent of current node.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(PageModel::class, 'page_id');
    }
}
