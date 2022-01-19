<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model{
    protected $table = "cars";

    protected $fillable = [
        'vehicle_id',
        'machine',
        'type'
    ];

    // public $timestamps = false;
}