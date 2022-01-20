<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'subtotal'
    ];

    protected $with = [
        'user',
        'detail'
    ];

    // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}