<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

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
            'year' => 'required|integer',
            'color' => 'required',
            'price' => 'required|integer',
            'vehicle_type' => 'required|in:1,2'
        ];

        switch (FormRequest::input('vehicle_type')) {
            case 1:
                $this->message = 'Tipe kendaraan Motor membutuhkan beberapa field dibawah ini';
                $rules['suspension_type'] = 'required|in:automatic,manual';
                $rules['transmision_type'] = 'required';
                break;
            case 2:
                $this->message = 'Tipe kendaraan Mobil membutuhkan beberapa field dibawah ini';
                $rules['machine'] = 'required|integer';
                $rules['capacity'] = 'required|integer';
                $rules['type'] = 'required|in:suv,mpv,sport';
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
            'transmision_type.required' => 'transmision_type harus diisi',
            'suspension_type.required' => 'suspension_type harus diisi',
            'suspension_type.in' => 'Isian yang diperbolehkan Manual, Automatic',
            'machine.required' => 'Price harus diisi',
            'capacity.required' => 'Color harus diisi',
            'type.required' => 'Year harus diisi',
            'vehicle_type.required' => 'vehicle_type harus diisi',
            'vehicle_type.in' => 'isi 1 untuk Motor dam 2 untuk Mobil',
            'type.in' => 'Isian yang diperbolehkan Suv, Mpv, Sport',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            'color' => 'trim|lowercase',
            'suspension_type' => 'trim|lowercase',
            'transmision_type' => 'trim|lowercase',
            'type' => 'trim|lowercase',
        ];
    }
    public function errorMessage(): string
    {
        return $this->message;
    }
}