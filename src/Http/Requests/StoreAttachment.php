<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class StoreAttachment extends FormRequest
{

    public function rules()
    {

        $drivers = array_keys(config('belt.clip.drivers'));

        return [
            'file' => 'required|file',
            'drivers' => 'in:' . implode(',', $drivers),
        ];
    }

}