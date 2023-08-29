<header class="c-header">
    <div class="c-header__logo d-flex justify-content-center align-items-center">
        <a href="{{ URL::To('admin/dashboard') }}">
            <img src="{{ url('public/images/logo.png') }}" class="img-fluid" alt="Lendkash">
        </a>
    </div>
    <nav class="navbar justify-content-between" id="navbar">
        <div class="navbar__toggle-icon">
            <a href="javascript:void(0);" id="menu">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <ul class="navbar-nav navbar__nav flex-row nav-right mb-0 justify-content-end align-items-center">
            <li class="nav-item list-inline-item notification dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-notifications1"></i>
                    <span class="count rounded-circle" id="notificationCount" style="background: #2A05A7;color: #fff;padding: 2px 5px;font-size: 11px;position: absolute;left: 12px;top: -4px;text-align: center;">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right position-absolute">
                    <div class="dropdown-header">
                        Notifications
                    </div>
                    <div class="dropdown_items" id="notificationDiv">

                    </div>
                    <div class="view-all text-center p-2 p-sm-3">
                        <a href="{{ URL::To('admin/notifications') }}" class="theme-color">View more</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown author list-inline-item">
                <a href="javascript:void(0);" class="dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ getUserInfo('admin')->user_image }}" class='rounded-circle author__avtar' id="profileImage">
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="javascript:void(0);" onClick="updateProfile()">Profile Setting</a>
                    <a class="dropdown-item" href="javascript:void(0);" onClick="changePassword();">Change Password</a>
                    <a class="dropdown-item" href="{{ url('admin/logout') }}" >Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
