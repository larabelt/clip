<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class UpdateAttachment extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}