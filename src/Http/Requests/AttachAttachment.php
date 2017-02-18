<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

/**
 * Class AttachAttachment
 * @package Belt\Clip\Http\Requests
 */
class AttachAttachment extends FormRequest
{


    /**
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:attachments,id',
        ];
    }

}