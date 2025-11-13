<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * * (Ví dụ: chỉ user đã đăng nhập mới được tạo post)
     */
    // authorize(): Gọi PostPolicy để check xem user có quyền create không.
    public function authorize(): bool
    {
        // return false; // Mặc định là false -> trả về 403 Forbidden
        // return auth()->check(); // Chỉ cần đã đăng nhập (use facade to satisfy static analysis)
        
        // Thay vì `auth()->check()`
        // Hãy dùng: "Này Laravel, check xem user hiện tại có quyền 'create'
        // trên model 'Post' không?"
        // Laravel sẽ tự động tìm PostPolicy và gọi hàm create()
        return $this->user()->can('create', Post::class);
        // Nếu không có policy thì Laravel sẽ tự động tìm Policy của model
        // và gọi hàm create() của policy đó
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // rules(): Định nghĩa các quy tắc cho dữ liệu gửi lên.
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255', 'unique:posts'],
            'content' => ['required', 'string', 'min:3'],
            'category_id' => ['required', 'integer', 'exists:categories,id'], // Phải tồn tại trong bảng 'categories'
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'published_at' => ['nullable', 'date', 'after_or_equal:today'], // chỉ cho phép ngày hiện tại trở đi
        ];
    }

    public function messages()
    {
        return [
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Ảnh không được vượt quá 2MB'
        ];
    }
}
