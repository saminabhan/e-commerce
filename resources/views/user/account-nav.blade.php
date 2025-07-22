<ul class="account-nav">
    <li>
        <a href="{{ route('user.index') }}" class="menu-link menu-link_us-s @if(request()->routeIs('user.index')) menu-link_active @endif">Dashboard</a>
    </li>
    <li>
        <a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s @if(request()->routeIs('user.orders')) menu-link_active @endif">Orders</a>
    </li>
    <li>
        <a href="{{ route('addresses.index') }}" 
           class="menu-link menu-link_us-s @if(request()->routeIs('addresses.*')) menu-link_active @endif">
            Addresses
        </a>
    </li>

    <li>
        <a href="{{ route('user.details') }}" class="menu-link menu-link_us-s @if(request()->routeIs('user.details')) menu-link_active @endif">Account Details</a>
    </li>
    <li>
        <a href="{{ route('wishlist.index') }}" class="menu-link menu-link_us-s @if(request()->routeIs('wishlist.*')) menu-link_active @endif">Wishlist</a>
    </li>
    <li>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf  
            <a href="{{ route('logout') }}" class="menu-link menu-link_us-s" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
        </form>
    </li>
</ul>