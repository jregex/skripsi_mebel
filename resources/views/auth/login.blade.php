@extends('_layouts.login')

@section('content')
<main class="form-signin">
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <h1 class="h3 mb-3 fw-normal">CV. IWAN MEBEL</h1>
        <div class="form-floating">
            <input type="text" class="form-control rounded-0" name="username" id="floatingInput" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control rounded-0" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        {{-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> --}}
        <button class="w-100 btn btn-lg btn-primary mt-2 rounded-0" type="submit"><i
                class="bi bi-box-arrow-in-right"></i> Login</button>
        <p class="mt-5 mb-3 text-center text-muted">&copy; 2023</p>
    </form>
</main>

@endsection