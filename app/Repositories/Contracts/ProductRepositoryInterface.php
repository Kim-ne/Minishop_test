<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAdminProductPaginate(array $filters = []):LengthAwarePaginator;
}
