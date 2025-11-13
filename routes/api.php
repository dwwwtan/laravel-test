<?php 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Đây là nơi đăng ký các route API. Chúng được tự động
| prefix (thêm tiền tố) là '/api/' (cấu hình trong bootstrap/app.php).
|
*/
// Bất kỳ ai GỌI CÁC ROUTE TRONG NÀY...
Route::middleware(['auth:sanctum'])->group(function () {
    // ...ĐỀU BẮT BUỘC PHẢI ĐĂNG NHẬP (đã được xác thực bởi Sanctum)
    
    // 1. Route trả về user đang đăng nhập (có sẵn)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // 2. Tự động tạo 5 route cho Posts
    Route::apiResource('posts', PostController::class);

    // 3. (Tương lai) Cậu có thể thêm các route khác ở đây
    // Route::apiResource('categories', CategoryController::class);
    // Route::get('/profile', [ProfileController::class, 'show']);
});

// Các route này CHỈ hoạt động khi user đã đăng nhập
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    // ... (ví dụ: /api/profile, /api/comments...)
    //(Lưu ý: Dùng apiResource thay vì resource sẽ tự động bỏ qua các route create 
    // và edit, vì chúng là route trả về form HTML, không cần thiết cho API).
});

// Ví dụ các route API cơ bản
// Route::prefix('v1')->group(function () {
    
//     // Public routes (không cần authentication)
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/register', [AuthController::class, 'register']);
    
//     // Protected routes (cần authentication)
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('/logout', [AuthController::class, 'logout']);
        
//         // User routes
//         Route::get('/profile', [UserController::class, 'profile']);
//         Route::put('/profile', [UserController::class, 'update']);
        
//         // Resource routes (CRUD)
//         Route::apiResource('posts', PostController::class);
//         Route::apiResource('categories', CategoryController::class);
//     });
// });


Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String()
    ]);
});