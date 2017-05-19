<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

/**
 * Class StoreAttachment
 * @package Belt\Clip\Http\Requests
 */
class StoreAttachment extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {

        $drivers = array_keys(config('belt.clip.drivers'));

        return [
            'file' => 'required|file',
            'driver' => 'in:' . implode(',', $drivers),
        ];
    }

}