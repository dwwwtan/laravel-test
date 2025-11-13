<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\Api\StorePostRequest;   // <-- Import
use App\Http\Requests\Api\UpdatePostRequest;   // <-- Import
use App\Services\PostService;                  // <-- Import
use App\Http\Resources\Api\PostResource;           // <-- Import
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class PostController extends Controller
{
    // Inject the PostService class to Controller
    public function __construct(protected PostService $postService)
    {
        // Đảm bảo user PHẢI có quyền (dùng Policy) TRƯỚC KHI gọi hàm
        // (Trừ 'index' và 'show' là public)
        // $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource. (GET /api/posts)
     */
    public function index(): JsonResource
    {
        $posts = $this->postService->getPaginatedPosts();

        // Dùng collection để trả về dữ liệu
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage. (POST /api/posts)
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        // 1. Validation + Authorization đã được StorePostRequest tự động lo
        $validatedData = $request->validated();

        // 2. Tạo mới post
        $post = $this->postService->createPost($validatedData, $request->user());
        
        // 3. Trả về post đã được "make up" với status 201 Created
        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource. (GET /api/posts/{post})
     */
    public function show(Post $post): JsonResource
    {
        // 1. Route Model Binding đã tự tìm $post
        // 2. Tải sẵn quan hệ (nếu chưa có)
        $post->loadMissing('user', 'category');

        // 3. Trả về post đã được "make up"
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage. (PUT/PATCH /api/posts/{post})
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        // 1. Validation + Authorization đã được UpdatePostRequest tự động lo
        $validatedData = $request->validated();

        // 2. Cập nhật post
        $post = $this->postService->updatePost($post, $validatedData);

        // 3. Trả về post đã được "make up"
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage. (DELETE /api/posts/{post})
     */
    public function destroy(Post $post)
    {
        // 1. Authorization đã được $this->authorizeResource() lo
        
        // 2. "Nhờ" Service xóa
        $this->postService->deletePost($post);

        // 3. Trả về response rỗng với status 204 No Content
        return response()->noContent();
    }
}
