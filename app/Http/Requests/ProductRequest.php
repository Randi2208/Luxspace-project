<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    // class yang berguna untuk mengelola logika transfer data pada databae
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //mengecek sudah login apa belum
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //required berarti wajib diisi
            'name'=>'required|max:255',
            'description'=>'required',
            'price'=>'required|integer'
        ];
    }
}
