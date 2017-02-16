<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class UpdateFileable extends FormRequest
{

    public function rules()
    {
        return [
            'move' => 'required_with:position_entity_id|in:before,after',
            'position_entity_id' => [
                'required_with:move',
                'exists:files,id',
                $this->ruleExists('fileables', 'file_id', ['fileable_id', 'fileable_type'])
            ],
        ];
    }

}