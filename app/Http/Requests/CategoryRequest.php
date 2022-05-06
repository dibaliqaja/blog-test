<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:categories,name,'.$this->category.'|min:3',
            'slug' => 'required|string|unique:categories,slug,'.$this->category,
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = Str::slug($data['name']);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
