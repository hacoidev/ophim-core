<?php

namespace Ophim\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Ophim\Core\Rules\UniqueName;

class DirectorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->name_md5 = md5($this->name);

        return [
            'name' => ['required', 'max:255', new UniqueName('directors', 'name', 'name_md5', 'id', $this->id)],
            'slug' => 'max:255|unique:directors,slug,' . $this->id . ',id',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
