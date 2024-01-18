<?php

namespace App\Providers;

use App\Repositories\Recruitments\RecruitmentsRepository;
use App\Repositories\Recruitments\RecruitmentsRepositoryInterface;
use App\Services\ProductCategory\RecruitmentsServiceInterface;
use App\Services\Recruitments\RecruitmentsService;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //Product
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(
            ProductServiceInterface::class,
            ProductService::class
        );

        //ProductComment
        $this->app->singleton(
            RecruitmentsRepositoryInterface::class,
            RecruitmentsRepository::class
        );

        $this->app->singleton(
            ProductCommentServiceInterface::class,
            ProductCommentService::class
        );

        //Recruitments
        $this->app->singleton(
            RecruitmentsRepositoryInterface::class,
            RecruitmentsRepository::class
        );

        $this->app->singleton(
            RecruitmentsServiceInterface::class,
            RecruitmentsService::class
        );

        //ProductCategory
        $this->app->singleton(
            ProductCategoryRepositoryInterface::class,
            ProductCategoryRepository::class
        );

        $this->app->singleton(
            RecruitmentsServiceInterface::class,
            RecruitmentsService::class
        );

        //Brand
        $this->app->singleton(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->singleton(
            BrandServiceInterface::class,
            BrandService::class
        );

        //Order
        $this->app->singleton(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->singleton(
            OrderServiceInterface::class,
            OrderService::class
        );

        //OrderDetail
        $this->app->singleton(
            OrderDetailRepositoryInterface::class,
            OrderDetailRepository::class
        );

        $this->app->singleton(
            OrderDetailServiceInterface::class,
            OrderDetailService::class
        );

        //User
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            UserServiceInterface::class,
            UserService::class
        );


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(
            PostRepositoryInterface::class,
            PostRepository::class
        );

        $this->app->singleton(
            PostServiceInterface::class,
            PostService::class
        );
    }
}
