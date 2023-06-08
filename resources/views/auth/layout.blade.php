<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <h1><a href="javascript:void(0)" class="logo">{{ Auth::user()->name }}</a></h1>
    <ul class="list-unstyled components mb-5">
        <li class="active">
            <a href="/dashboard"><span class="fa fa-dashboard mr-3"></span>Dashboard </a>
        </li>
        <li class="">
            <a href="{{ route('referraltrack.data') }}"><span class="fa fa-bar-chart mr-3"></span>Referral Track 
            </a>
        </li>
        <li class="">
            <a href="{{ route('profile.load') }}" class="profile"><span class="fa fa-user mr-3"></span>Profile </a>
        </li>
        <li class="">
            <a href="#" class="trash_account"><span class="fa fa-trash mr-3"></span>Delete Account </a>
        </li>
        <li>
            <a href="{{url('user-logout')}}"><span class="fa fa-sign-out mr-3"></span>Logout</a>
        </li>
        
    </ul>
</nav>