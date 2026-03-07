<?php

namespace App\Services\Interface;

interface ProductServiceInterface
{
    /**
     * Get Paginate with product and category
     * @return mixed
     */
    public function getListProduct(): mixed;
    public function getListCategory(): mixed;

}


