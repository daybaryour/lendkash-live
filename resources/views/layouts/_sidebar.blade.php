<div class="overlay-screen" (click)="closeMenu()"></div>
<aside class="sidemenu" id="sidemenu">
    <div class="sidebar-wrapper">
        <?php
            $routeSegment =  request()->segment(2);
        ?>
        <ul id="sideSubMenu" class="nav flex-column">
            <li class="<?php if($routeSegment=='dashboard' ) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="{{ URL::To('admin/dashboard') }}">
                    <span class="nav_icon"><i class="icon-dashboard"></i></span>
                    <span class="nav_title">Dashboard</span>
                </a>
            </li>
            <li class="<?php if(($routeSegment=='users') || ($routeSegment=='user-detail')) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="{{ URL::To('admin/users') }}">
                    <span class="nav_icon"><i class="icon-team"></i></span>
                    <span class="nav_title">User</span>
                </a>
            </li>
            <li class="<?php if(($routeSegment=='approval-loans') || ($routeSegment=='loans')) {echo 'active';} ?>">
                <a href="{{ URL::To('admin/approval-loans') }}" class="nav-link nav__link ripple-effect data-toggle collapsed" data-toggle="collapse" data-target="#loanRequest" aria-expanded="<?php if(($routeSegment=='Manage Loan Request') || ($routeSegment=='Manage Loan')) {echo 'true';} ?>">
                    <span class="nav_icon"><i class="icon-discount"></i></span>
                    <span class="nav_title">Loan Request </span>
                </a>
                <ul class="list-unstyled collapse nav__submenu <?php if(($routeSegment=='approval-loans') || ($routeSegment=='loans'))  {echo 'show';} ?>" id="loanRequest">
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='approval-loans') {echo 'active';} ?>" href="{{ URL::To('admin/approval-loans') }}">Approve Loans</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='loans' ) {echo 'active';} ?>" href="{{ URL::To('admin/loans') }}">Loans</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='un-paid-emi-list' ) {echo 'active';} ?>" href="{{ URL::To('admin/un-paid-emi-list') }}">Un Paid EMI</a></li>
                </ul>
            </li>
            <li class="<?php if(($routeSegment=='invest-request') || ($routeSegment=='invest')) {echo 'active';} ?>">
                <a href="javascript:void(0);" class="nav-link nav__link ripple-effect data-toggle collapsed" data-toggle="collapse" data-target="#investRequest" aria-expanded="<?php if(($routeSegment=='Manage Invest Request') || ($routeSegment=='Manage Invest')) {echo 'true';} ?>">
                    <span class="nav_icon"><i class="icon-profits"></i></span>
                    <span class="nav_title">Invest Request </span>
                </a>
                <ul class="list-unstyled collapse nav__submenu <?php if(($routeSegment=='invest-request') || ($routeSegment=='invest'))  {echo 'show';} ?>" id="investRequest">
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='invest-request') {echo 'active';} ?>" href="{{ URL::To('admin/invest-request') }}">Approve Invest</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='invest' ) {echo 'active';} ?>" href="{{ URL::To('admin/invest') }}">Invest</a></li>
                </ul>
            </li>
           <!--  <li class="<?php if($routeSegment=='Manage Invest' ) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="invest.php">
                    <span class="nav_icon"><i class="icon-profits"></i></span>
                    <span class="nav_title">Invest</span>
                </a>
            </li> -->
            <li class="<?php if($routeSegment=='support' ) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="{{ URL::To('admin/support') }}">
                    <span class="nav_icon"><i class="icon-support"></i></span>
                    <span class="nav_title">Support</span>
                </a>
            </li>
            <li class="<?php if($routeSegment=='reviews-and-ratings' ) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="{{ URL::To('admin/reviews-and-ratings') }}">
                    <span class="nav_icon"><i class="icon-review"></i></span>
                    <span class="nav_title">Reviews & Ratings</span>
                </a>
            </li>
            <li class="<?php if(($routeSegment=='set-commission') || ($routeSegment=='commission-list')) {echo 'active';} ?>">
                <a href="javascript:void(0);" class="nav-link nav__link ripple-effect data-toggle collapsed" data-toggle="collapse" data-target="#manageReport" aria-expanded="<?php if(($routeSegment=='set-commission') || ($routeSegment=='commission-list')) {echo 'true';} ?>">
                    <span class="nav_icon"><i class="icon-commission"></i></span>
                    <span class="nav_title">Commission</span>
                </a>
                <ul class="list-unstyled collapse nav__submenu <?php if(($routeSegment=='set-commission') || ($routeSegment=='commission-list'))  {echo 'show';} ?>" id="manageReport">
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='set-commission' ) {echo 'active';} ?>" href="{{ URL::To('admin/set-commission') }}">Set Commission</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='commission-list' ) {echo 'active';} ?>" href="{{ URL::To('admin/commission-list') }}">Loan Commission</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='wallet-commission-list' ) {echo 'active';} ?>" href="{{ URL::To('admin/wallet-commission-list') }}">Wallet Commission</a></li>
                </ul>
            </li>
            <li class="<?php if($routeSegment=='Manage Transaction' ) {echo 'active';} ?>">
                <a class="nav-link nav__link ripple-effect" href="{{ URL::To('admin/transaction') }}">
                    <span class="nav_icon"><i class="icon-money"></i></span>
                    <span class="nav_title">Transaction</span>
                </a>
            </li>
             <li class="<?php if($routeSegment=='manage-transfer' ) {echo 'active';} ?>">
                <a href="javascript:void(0);" class="nav-link nav__link ripple-effect data-toggle collapsed" data-toggle="collapse" data-target="#walletManage" aria-expanded="<?php if(($routeSegment=='emi-lender-hold-amount') || ($routeSegment=='manage-transfer')) {echo 'true';} ?>">
                    <span class="nav_icon"><i class="icon-wallet"></i></span>
                    <span class="nav_title">Manage Wallet</span>
                </a>
                <ul class="list-unstyled collapse nav__submenu <?php if(($routeSegment=='manage-transfer') || ($routeSegment=='emi-lender-hold-amount'))  {echo 'show';} ?>" id="walletManage">
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='manage-transfer') {echo 'active';} ?>" href="{{ URL::To('admin/manage-transfer') }}">Wallet</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='emi-lender-hold-amount' ) {echo 'active';} ?>" href="{{ URL::To('admin/emi-lender-hold-amount') }}">Lender Hold Amount</a></li>
                </ul>
            </li>
            <li class="<?php if(($routeSegment=='user-report') || ($routeSegment=='loan-report') || ($routeSegment=='invest-report')) {echo 'active';} ?>">
                <a href="javascript:void(0);" class="nav-link nav__link ripple-effect data-toggle collapsed" data-toggle="collapse" data-target="#manageReport" aria-expanded="<?php if(($routeSegment=='user-report') || ($routeSegment=='loan-report') || ($routeSegment=='invest-report')) {echo 'true';} ?>">
                    <span class="nav_icon"><i class="icon-approve-invoice"></i></span>
                    <span class="nav_title">Manage Report</span>
                </a>
                <ul class="list-unstyled collapse nav__submenu <?php if(($routeSegment=='user-report') || ($routeSegment=='loan-report') || ($routeSegment=='invest-report'))  {echo 'show';} ?>" id="manageReport">
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='user-report' ) {echo 'active';} ?>" href="{{ URL::To('admin/user-report') }}">Users</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='loan-report' ) {echo 'active';} ?>" href="{{ URL::To('admin/loan-report') }}">Loans</a></li>
                    <li class=""><a class="nav-link nav__link <?php if($routeSegment=='invest-report' ) {echo 'active';} ?>" href="{{ URL::To('admin/invest-report') }}">Invests</a></li>
                </ul>
            </li>
            <li class="<?php if(($routeSegment=='manage-cms') || ($routeSegment=='manage-faqs')) {echo 'active';} ?>">
                <a href="{{ URL::To('admin/manage-cms') }}" class="nav-link nav__link ripple-effect">
                    <span class="nav_icon"><i class="icon-file-list"></i></span>
                    <span class="nav_title">Manage CMS</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
