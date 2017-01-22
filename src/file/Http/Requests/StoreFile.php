<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

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