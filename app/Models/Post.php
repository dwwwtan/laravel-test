<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    /**
     * Mass Assignment: Các trường (cột) ĐƯỢC PHÉP điền vào khi dùng Post::create([...]).
     * Đây là CƠ CHẾ BẢO MẬT cực kỳ quan trọng để chống lại Mass Assignment Vulnerability.
     * Nó giống như việc cậu chỉ cho phép người dùng điền vào form các trường 'title', 'content',
     * chứ không cho họ tự ý điền vào các trường nhạy cảm như 'is_published' hay 'views'.
     */

    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'image',
        'content',
        'published_at',
    ];

    /**
     * Type Casting: Tự động chuyển đổi kiểu dữ liệu của các cột.
     * Rất hữu ích! Ví dụ, cột 'published_at' trong DB là dạng chuỗi '2025-11-11 14:30:00',
     * nhưng khi cậu truy cập $post->published_at, nó sẽ tự động là một object Carbon (để xử lý ngày tháng).
     */

    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    public function user(): BelongsTo {
        // Eloquent sẽ tự hiểu khóa ngoại (foreign key) là 'user_id'
        // dựa vào tên hàm 'user' + '_id'.
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
    /**
     * Ví dụ về một mối quan hệ khác:
     * Một bài viết (Post) có nhiều (hasMany) bình luận (Comment).
     */
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }
}
