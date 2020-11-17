<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'             => 'required|string|unique:posts,title,'.$this->post.'|min:5',
            'slug'              => 'required|string|unique:posts,slug,'.$this->post,
            'short_description' => 'required|min:5',
            'content'           => 'required',
            'image'             => 'image|mimes:jpeg,png,jpg|max:1024',
            'thumbnail'         => 'image|mimes:jpeg,png,jpg',
            'category_id'       => 'exists:categories,id',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = Str::slug($data['title']);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
