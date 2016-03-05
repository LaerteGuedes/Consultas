<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocalidadeRequest extends Request
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
        $data = $this->request->all();

        $rules = ['tipo' => 'required',
            'uf' => 'required',
            'cidade_id' => 'required',
            'bairro' => 'required'
        ];

        if ($data['tipo'] == 'CONSULTORIO'){
            $rules['logradouro'] = 'required';
            $rules['numero'] = 'required';
            $rules['cep'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'uf.required' => 'É obrigatória a indicação de um valor para o campo estado',
            'cidade_id.required' => 'É obrigatória a indicação de um valor para o campo cidade'
        ];
    }

}
