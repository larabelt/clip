<?php
namespace Ohio\Storage\Http\Requests;

use Ohio\Core\Http\Requests\FormRequest;

class StoreFile extends FormRequest
{

    public function rules()
    {

        $drivers = array_keys(config('ohio.storage.drivers'));

        return [
            'file' => 'required|file',
            'drivers' => 'in:' . implode(',', $drivers),
        ];
    }

}