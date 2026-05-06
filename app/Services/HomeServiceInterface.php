<?php

namespace App\Services;

interface HomeServiceInterface
{
    /**
     * Get Paginate with product and category
     * @return mixed
     */
    public function getListProduct(): mixed;
    public function getListCategory(): mixed;
    public function getListProductRecent(): mixed;

    public function homeDashboard(): mixed;

    public function socialIndex(): mixed;
}


