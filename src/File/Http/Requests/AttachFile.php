<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class AttachFile extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:files,id',
        ];
    }

}