<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

/**
 * Class StoreAlbum
 * @package Belt\Clip\Http\Requests
 */
class StoreAlbum extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        if ($this->get('source')) {
            return [
                'source' => 'exists:albums,id',
            ];
        }

        return [
            'name' => 'required',
        ];
    }

}