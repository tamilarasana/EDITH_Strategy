<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'basket_name',
        'sq_target',
        'stop_loss',
        'target_strike',
        'init_target',
        'sq_loss',
        'scheduled_exec',
        'scheduled_sqoff',
        'recorring',
        'weekDays', 
        'strategy',
        'qty',
        'Pnl',
        'Pnl_perc',
        'init_Target',
        'current_target',
        'target_strike',
        'stop_loss',
        'status',
    ];


    public function orders(){
       return $this->hasMany(Order::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
    }
}

