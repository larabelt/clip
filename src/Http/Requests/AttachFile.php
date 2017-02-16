<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class AttachFile extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:files,id',
        ];
    }

}