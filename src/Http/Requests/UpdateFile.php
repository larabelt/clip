<?php
namespace Ohio\Storage\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class UpdateFile extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}