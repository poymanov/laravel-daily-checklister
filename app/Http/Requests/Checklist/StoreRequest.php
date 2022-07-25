<?php

namespace App\Http\Requests\Checklist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @phpstan-ignore-next-line */
        $checklistGroupId = $this->route('checklist_group')->id;
        $name             = $this->request->get('name');

        return [
            'name' => [
                'required',
                Rule::unique('checklists')->where(fn ($query) => $query->where('name', $name)->where('checklist_group_id', $checklistGroupId)),
            ],
        ];
    }
}
