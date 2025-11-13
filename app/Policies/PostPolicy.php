<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    /**
     * Xác định xem user có thể XEM DANH SÁCH (view any) post không.
     */
    public function viewAny(User $user): bool
    {
        // Vì route đã được bọc 'auth:sanctum', ta biết $user đã login.
        // Ta cho phép BẤT KỲ ai đã login được xem danh sách.
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    /**
     * Xác định xem user có thể XEM CHI TIẾT (view) post không.
     */
    public function view(User $user, Post $post): bool
    {
        // Ai đã login cũng được xem chi tiết.
        // (Nếu cậu muốn, cậu có thể check logic phức tạp hơn ở đây,
        // ví dụ: chỉ cho xem bài viết 'published')
        return true;
    }

    /**
     * Quyền tạo (create) một bài viết mới.
     * Tương ứng với `StorePostRequest`
     */
    public function create(User $user): bool
    {
        // Logic của chúng ta là: "Ai cũng được tạo, miễn là đã đăng nhập"
        // Vì hàm này chỉ chạy nếu $user TỒN TẠI (đã đăng nhập),
        // nên chúng ta chỉ cần trả về true.
        return true; 
        
        // Nâng cao: return $user->hasRole('writer'); // Chỉ 'writer' mới được tạo
    }

    /**
     * Quyền cập nhật (update) một bài viết đã có.
     * Tương ứng với `UpdatePostRequest`
     */
    public function update(User $user, Post $post): bool
    {
        // $user là người đang đăng nhập (auth()->user())
        // $post là bài viết đang được check (từ route)
        
        // Chỉ cho phép nếu ID của user đang login === ID của người viết post
        $isOwner = $user->id === $post->user_id;

        // Logic #2: User có phải là Admin?
        // $isAdmin = $user->role === 'admin'; // (Giả sử cậu có cột 'role' trong users)

        // "Cho phép nếu là chủ HOẶC là admin"
        // return $isOwner || $isAdmin;
        return $isOwner;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
    
    // Các hàm khác như viewAny, view, restore, forceDelete...
    // Chúng ta có thể để trống, mặc định là 'deny' (từ chối)
    // Hoặc 'allow' (cho phép) nếu chúng ta không check quyền

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
