<?php
namespace Ohio\Storage\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class AttachFile extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:files,id',
        ];
    }

}