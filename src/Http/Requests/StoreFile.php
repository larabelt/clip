<?php
namespace Belt\Storage\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class StoreFile extends FormRequest
{

    public function rules()
    {

        $drivers = array_keys(config('belt.storage.drivers'));

        return [
            'file' => 'required|file',
            'drivers' => 'in:' . implode(',', $drivers),
        ];
    }

}