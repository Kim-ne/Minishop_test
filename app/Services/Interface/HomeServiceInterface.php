<?php

namespace App\Services\Interface;

interface HomeServiceInterface
{
    /**
     * Get Paginate with product and category
     * @return mixed
     */
    public function getListProduct(): mixed;
    public function getListCategory(): mixed;
    public function getListProductRecent(): mixed;
}


