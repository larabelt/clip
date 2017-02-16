<?php
namespace Belt\Storage\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class UpdateFile extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}