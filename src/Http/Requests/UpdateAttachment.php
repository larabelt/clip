<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

/**
 * Class UpdateAttachment
 * @package Belt\Clip\Http\Requests
 */
class UpdateAttachment extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
        ];
    }

}