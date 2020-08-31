<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'finance_transactions';

    protected $fillable = [
        'title', 'description', 'finance_account_id',
        'amount', 'finance_name',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


   public function account()
   {
       return $this->belongsTo('App\Models\FinanceAccount', 'finance_account_id', 'id');
   }
}