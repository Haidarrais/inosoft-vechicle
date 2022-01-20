<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Support\Str;

class VehicleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $message;
    public function __construct()
    {
        $this->message = 'data yang diberikan belum sesuai';
    }
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'year' => 'required|integer|digits:4',
            'color' => 'required',
            'price' => 'required|integer',
            'vehicle_type' => 'required|in:1,2'
        ];

        // add to this switch if you want to add more vehicle type
        switch ($this->request->get('vehicle_type')) {
            case 1:
                $this->message = 'Tipe kendaraan Motor membutuhkan beberapa field dibawah ini';
                $rules['suspension_type'] = 'required';
                $rules['transmision_type'] = 'required|in:MT,AT';
                break;
            case 2:
                $this->message = 'Tipe kendaraan Mobil membutuhkan beberapa field dibawah ini';
                $rules['machine'] = 'required|integer';
                $rules['capacity'] = 'required|integer';
                $rules['car_type'] = 'required|in:suv,mpv,sport';
                break;
            default:
                # code...
                break;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'color.required' => 'Color harus diisi',
            'year.required' => 'Year harus diisi',
            'price.required' => 'Price harus diisi',
            'suspension_type.required' => 'suspension_type harus diisi',
            'transmision_type.required' => 'transmision_type harus diisi',
            'transmision_type.in' => 'Isian yang diperbolehkan MT, AT (dengan uppercase)',
            'machine.required' => 'Price harus diisi',
            'capacity.required' => 'Color harus diisi',
            'type.required' => 'Year harus diisi',
            'vehicle_type.required' => 'vehicle_type harus diisi',
            'vehicle_type.in' => 'isi 1 untuk Motor dam 2 untuk Mobil',
            'car_type.in' => 'Isian yang diperbolehkan suv, mpv, sport (dengan lowercase)',
        ];
    }

    public function errorMessage(): string
    {
        return $this->message;
    }
}