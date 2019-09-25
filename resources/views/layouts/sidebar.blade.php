
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
        

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="{{ route('about') }}">About</a>
  <a href="{{ route('users.index') }}">User</a>
  <a href="{{ route('logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
  
</div>
