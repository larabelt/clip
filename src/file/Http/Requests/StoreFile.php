<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreFile extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

}