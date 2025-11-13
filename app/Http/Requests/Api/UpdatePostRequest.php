<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        // Lấy post từ route (ví dụ: /api/posts/123)
        $post = $this->route('post');
        
        // Gọi hàm 'update' trong PostPolicy
        return $this->user()->can('update', $post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Lấy bài viết (Post) từ route
        $post = $this->route('post');
        return [
            // 'sometimes' nghĩa là: nếu field này được gửi lên thì validate,
            // không gửi thì bỏ qua
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                // Check unique, NHƯNG bỏ qua (ignore) ID của post hiện tại
                Rule::unique('posts')->ignore($post->id),
            ],
            'content' => ['sometimes', 'required', 'string'],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'published_at' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
