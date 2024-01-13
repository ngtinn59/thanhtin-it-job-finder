<?php

namespace App\Services\ProductCategory;

use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Services\BaseService;
use App\Services\Product\ProductServiceInterface;

class ProductCategoryService extends BaseService implements ProductCategoryServiceInterface
{
    public $repository;

    public function __construct(ProductCategoryRepositoryInterface $ProductCategoryRepository) {
        $this->repository = $ProductCategoryRepository;
    }
}
