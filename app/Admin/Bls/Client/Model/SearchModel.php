<?php

namespace App\Admin\Bls\Client\Model;

use Illuminate\Database\Eloquent\Model;

class SearchModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_search';

    protected $casts = [
        'extend' => 'array'
    ];

}
