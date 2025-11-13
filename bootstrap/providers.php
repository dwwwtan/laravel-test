<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Framework Service Providers...
    |--------------------------------------------------------------------------
    */
    // Database + Filesystem + Session + View providers là bắt buộc nếu SPA + Fortify + API.
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class, // ✅ Bắt buộc, fix "Target [db]"
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class, // ✅ Bắt buộc, fix "Target [files]"
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Application Service Providers...
    |--------------------------------------------------------------------------
    */
    App\Providers\AppServiceProvider::class, 
    App\Providers\AuthServiceProvider::class, // registration Authentication
    // App\Providers\EventServiceProvider::class,
    // App\Providers\RouteServiceProvider::class,
    App\Providers\FortifyServiceProvider::class, // -> ✅ Bắt buộc, fix "Target [fortify]"

];
