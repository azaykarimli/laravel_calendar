{{-- Bootstrap 5 nav bar --}}


<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                @auth

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            change user
                        </a>
                        <select class="form-select" id="my_select" aria-label="Default select example">
                            @foreach ($users as $user)
                                <option class="willbe" id="selected_{{ $user->id }}" data-id="{{ $user->id }}">
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        {{--        <select class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($users as $user)
                                <option><a class="dropdown-item" id="necessary" id="{{ $user->id }}"
                                        href="/getevent/{{ $user->id }}">
                                        {{ $user->name }}</a></option>
                            @endforeach

                        </select> --}}
                    </li>

                    <li>
                        <span class="nav-link active">
                            Welcome {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li>
                        <a href="/manage" class="nav-link active"><i class="fa-solid fa-gear"></i>
                            Manage My Events</a>
                    </li>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-door-closed">Logout</i></button>
                    </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/login">Login</a>
                    </li>

                @endauth


            </ul>

        </div>
    </div>
</nav>
