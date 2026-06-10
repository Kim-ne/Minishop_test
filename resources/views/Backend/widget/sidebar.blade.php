<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('user.dashboard') }}"><img class="img-fluid for-light"
                    src="/Backend/assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                    src="/Backend/assets/images/logo/logo_dark.png" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('user.dashboard') }}"><img class="img-fluid"
                    src="/Backend/assets/images/logo/logo-icon.png" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('user.dashboard') }}"><img class="img-fluid"
                                src="/Backend/assets/images/logo/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                        <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#fill-home"></use>
                            </svg><span class="">Dashboard </span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="" href="{{ route('user.dashboard') }}">Home Page</a></li>
                            <li><a href="{{ route('social') }}">Social</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                        <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#user-visitor"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#fill-visitor"></use>
                            </svg><span class="">Profile</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('userProfile') }}">Infomation</a></li>
                            <li><a href="{{ route('editProfile') }}">Edit</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Applications</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#stroke-ecommerce"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                            </svg><span>Ecommerce</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('user.products') }}">Product</a></li>
                            <li><a href="{{ route('products.create') }}">Add Product</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="/Backend/assets/svg/icon-sprite.svg#fill-user"></use>
                            </svg><span>Customers</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('customer.index') }}">Customers List</a></li>
                            @if (auth()->guard('user')->check() && auth()->guard('user')->user()->hasRole('admin'))
                                <li><a href="{{ route('roles.index') }}">Role</a></li>
                            @else

                            @endif
                        </ul>
                    </li>

            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
