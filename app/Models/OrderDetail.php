<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model{
    protected $table = "order_details";

    protected $fillable = [
        'order_id',
        'stock_id',
        'qty'
    ];
    
    protected $with = [
        'stock'
    ];
    // public $timestamps = false;
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}