<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model{
    protected $table = "stocks";

    protected $fillable = [
        'vehicle_id',
        'qty'
    ];

    // public $timestamps = false;

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}