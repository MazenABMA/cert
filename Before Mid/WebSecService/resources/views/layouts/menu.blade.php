<nav class="navbar navbar-expand-sm bg-light">
<div class="container-fluid">
<ul class="navbar-nav">


<li class="nav-item">
<a class="nav-link" href="./">Home</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./even">Even Numbers</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./prime">Prime Numbers</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./multable">Multiplication Table</a>
</li>
<li class="nav-item">
<a class="nav-link" href="./text">text</a>
</li>
 <li class="nav-item">
<a class="nav-link" href="./bill">bill</a>
</li> 
<li class="nav-item">
<a class="nav-link" href="./transcript">transcript</a>
</li> 
<li class="nav-item">
<a class="nav-link" href="./products"> products list</a>
</li> 

<li class="nav-item">
    <a class="nav-link" href="./books">Books</a>
</li>

@can('edit_users')
    <li class="nav-item">
        <a class="nav-link" href="./users">Users</a>
    </li>
@endcan

<li class="nav-item">
<a class="nav-link" href="./grades"> grades</a>
</li> 

<li class="nav-item">
<a class="nav-link" href="./exam"> exam</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.index') }}">To-Do List</a>
</ul>

<ul class="navbar-nav">
    @auth
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
            <li>
                <form action="{{ route('do_logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </li>
        </ul>
    </li>
    @else
    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
    @endauth
    
</li>
    
 </ul>

</div>
</nav>
