<?php

namespace App\Http\Requests\Page;

use App\Enums\PageTypeEnum;
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
        return [
            'title'   => 'required|min:3|max:255',
            'content' => 'required|min:3',
            'type'    => ['required', 'unique:pages', Rule::in([PageTypeEnum::WELCOME->value, PageTypeEnum::GET_CONSULTATION->value])],
        ];
    }
}
