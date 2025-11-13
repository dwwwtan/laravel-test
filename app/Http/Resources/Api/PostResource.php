<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\URL;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * Biến đổi resource thành một mảng.
     */
    public function toArray(Request $request): array
    {
        // $this ở đây chính là object $post
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            // Thêm đường dẫn đầy đủ cho ảnh
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            // 'image_url' => $this->image ? Storage::disk('public')->url($this->image) : null,
            'published_at' => $this->published_at?->toIso8601String(), // Format ngày giờ
            'created_at' => $this->created_at->toIso8601String(),

            // "loadMissing" sẽ chỉ load quan hệ nếu nó chưa được load (tối ưu query)
            // Chúng ta dùng "UserResource" và "CategoryResource" (cậu có thể tạo sau)
            // Tạm thời, chúng ta sẽ trả về object thô:
            'author' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            
            // Tạm thời, nếu cậu chưa tạo UserResource/CategoryResource:
            // 'author' => $this->whenLoaded('user'),
            // 'category' => $this->whenLoaded('category'),
        ];
        
        // Cậu hãy tạo 2 resource kia cho "chuẩn" nhé:
        // php artisan make:resource UserResource
        // php artisan make:resource CategoryResource
    }
}
