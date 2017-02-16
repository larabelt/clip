<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class AttachAttachment extends FormRequest
{


    public function rules()
    {
        return [
            'id' => 'required|exists:attachments,id',
        ];
    }

}