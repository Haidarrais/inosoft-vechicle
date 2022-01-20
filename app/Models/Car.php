<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model{
    protected $table = "cars";

    protected $fillable = [
        'vehicle_id',
        'machine',
        'car_type'
    ];

    // public $timestamps = false;

    public function vehicle()
    {
        return $this->morphOne(User::class, 'vehicle');
    }
}