<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePerfilRequest extends Request
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


        $rules = [
            'name'     => 'required|min:2|max:255|alpha',
            'lastname' => 'required|min:2|max:255|alpha',
            'phone'    => 'required|min:15|max:15'

        ];

        if($this->request->get('cid')){

            $rules['cid']='required';
            $rules['especialidade_id']='required';
        }

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'name.required'     => 'O nome é obrigatório',
            'lastname.required' => 'O sobrenome é obrigatório',

            'name.min'     => 'O nome deve conter no minimo 2 caracteres',
            'lastname.min' => 'O sobrenome deve conter no minimo 2 caracteres',

            'name.max'     => 'O nome deve conter no maximo 255 caracteres',
            'lastname.max' => 'O sobrenome deve conter no maximo 255 caracteres',

            'name.alpha'     => 'O nome deve conter somente letras',
            'lastname.alpha' => 'O sobrenome deve conter somente letras',

            'phone.required'    => 'O  telefone é obrigatório',

            'phone.min'    => 'O  telefone é inválido',

            'phone.max'    => 'O  telefone é inválido',

            'especialidade_id.required' => 'Sua área de atuação é obrigatório'

        ];


        return $messages;
    }
}
