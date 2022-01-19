<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model{
    protected $table = "vehicles";

    protected $fillable = [
        'year',
        'color',
        'price',
        'vehicle_type'
    ];

    protected $relationMethods;

    // public $timestamps = false;
    protected $append = [
        'vehicle_type_name'
    ];

    public function getVehicleTypeNameAttribute()
    {
        return $this->type()->first()->name;
    }    
    /**
     * Get the type that owns the Vehicle
     *
     */
    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type', 'id');
    }
    /**
     * Get the motor that owns the Vehicle
     *
     */
    public function motor()
    {
        return $this->belongsTo(Motorcycle::class, 'id', 'vehicle_id');
    }
    /**
     * Get the mobil that owns the Vehicle
     *
     */
    public function mobil()
    {
        return $this->belongsTo(Car::class, 'id', 'vehicle_id');
    }
}