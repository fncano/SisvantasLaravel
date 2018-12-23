<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idcliente'=>'required',
            'tipocomprobante'=>'required|max:20',
            'seriecomprobante'=>'max:7',
            'numcomprobante'=>'required|max:10',
            'idarticulo'=>'required',
            'cantidad'=>'required',
            'precioventa'=>'required',
            'descuento'=>'required',
            'totalventa'=>'required'
        ];
    }
}
