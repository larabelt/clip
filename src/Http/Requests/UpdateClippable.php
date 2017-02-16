<?php
namespace Belt\Clip\Http\Requests;

use Belt\Core\Http\Requests\FormRequest;

class UpdateClippable extends FormRequest
{

    public function rules()
    {
        return [
            'move' => 'required_with:position_entity_id|in:before,after',
            'position_entity_id' => [
                'required_with:move',
                'exists:attachments,id',
                $this->ruleExists('clippables', 'attachment_id', ['clippable_id', 'clippable_type'])
            ],
        ];
    }

}