
@extends('loginform.login')
@section('loginform')

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                            </a>
                            <h3>Connexion Admin</h3>
                        </div>
                        @if (session('error'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form action="{{route('logadmin')}}" method="POST">
                            @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nomadmin" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Login</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="mdp" placeholder="Password">
                            <label for="floatingPassword">Mot de passe</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
@endsection