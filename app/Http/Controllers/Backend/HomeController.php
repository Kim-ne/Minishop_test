<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\HomeServiceInterface;

class HomeController extends Controller
{
    public function __construct
    (
        protected HomeServiceInterface $homeService,
    )
    {}
    /**
     * Login page
    */
    function dashboardIndex()
    {
        $this->homeService->homeDashboard();

        return view('Backend.index');
    }

    function socialIndex()
    {
        $this->homeService->socialIndex();

        return view('Backend.social');
    }

     function loginTest()
    {
        return view('Backend.auth.loginTest',[
            'categories' => Category::all()
        ]);
    }

     function profileTest()
    {
        return view('Backend.auth.profileTest');
    }

    // function editProfileTest()
    // {
    //     return view('Backend.auth.edit-profile');
    // }

}
