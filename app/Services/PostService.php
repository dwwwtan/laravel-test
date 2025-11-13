<?php 
namespace App\Services;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * Lấy danh sách post, đã phân trang và load sẵn quan hệ.
     */
    public function getPaginatedPosts(int $perPage = 10): LengthAwarePaginator
    {
        // Eager load user and category to avoid N+1 query problem
        return Post::with(['user', 'category'])
            ->latest()
            ->paginate($perPage);
    }
    /**
     * Tạo một bài viết mới.
     */
    public function createPost(array $data, User $user): Post
    {
        // Gán tác giả
        $data['user_id'] = $user->id;

        // Tự động tạo slug từ title
        $data['slug'] = Str::slug($data['title']);

        // Xử lý upload ảnh nếu có
        if (!empty($data['image'])) {
            // Lưu file vào 'storage/app/public/post_images'
            // Trả về đường dẫn 'post_images/ten_file.jpg'
            $uploadedFile  = $data['image'];

            // Tạo tên file: timestamp_slug_random.extension
            $originalName = pathinfo($uploadedFile ->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($originalName);
            $fileName = time() . '_' . $slug . '_' . Str::random(5) . '.' . $uploadedFile ->getClientOriginalExtension();
            
            // Lưu file
            $path = $uploadedFile ->storeAs('post_images', $fileName, 'public');
            $data['image'] = $path;
        }
        // Tạo mới post
        return Post::create($data);
    }

    /**
     * Cập nhật một bài viết đã có.
     */

    public function updatePost(Post $post, array $data) {
        // Nếu title thay đổi, tạo lại slug
        if (!empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Xử lý ảnh nếu có ảnh mới
        if (!empty($data['image'])) {
            // Xóa ảnh cũ nếu có
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Upload ảnh mới
            $path = $data['image']->store('post_images', 'public');
            $data['image'] = $path;
        }

        // Cập nhật post
        $post->update($data);
        return $post;
    }

    /**
     * Xóa một bài viết.
     */
    public function deletePost(Post $post): void
    {
        // 1. Xóa ảnh của post (nếu có)
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // 2. Xóa post khỏi DB
        $post->delete();
    }
}