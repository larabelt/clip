<?php
namespace Ohio\Storage\File\Http\Requests;

use Ohio\Core\Base\Http\Requests\FormRequest;

class StoreFile extends FormRequest
{

    public function rules()
    {

        $disks = array_keys(config('ohio.storage.disks'));

        return [
            'file' => 'required|file',
            'disk' => 'in:' . implode(',', $disks),
        ];
    }

}