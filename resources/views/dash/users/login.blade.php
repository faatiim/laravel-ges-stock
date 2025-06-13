@extends('partials.auth-layout')

@section('title', "Page de connexion")

@section('auth-form')

    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
            <div class="img" style="background-image: url('{{ asset('auth/images/bg-3.jpg') }}');">
        </div>
        <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
                <div class="w-100">
                    <h3 class="mb-4">Connexion</h3>
                </div>
                    <div class="w-100">
                        <p class="social-media d-flex justify-content-end">
                            <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                            <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                        </p>
                    </div>
            </div>
            <form action="{{ route('login.submit') }}" method="POST" class="signin-form">
                @csrf
                <div class="form-group mb-3">
                    <label class="label" for="name">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('name') }}" placeholder="email" required>
                    @error('email')
                        <p class="mb-4"> {{ $message }}</p>
                    @enderror 
                </div>
                <div class="form-group mb-3">
                    <label class="label" for="password">Mot de Passe</label>
                    <input type="password" class="form-control" name="password" placeholder="Mot de Passe" required>
                    @error('password')
                        <p class="mb-4"> {{ $message }}</p>
                    @enderror 
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Se connecter</button>
                </div>
                 <div class="form-group d-md-flex">
                    <div class="w-50 text-left">
                        <label class="checkbox-wrap checkbox-primary mb-0">se souvenir de moi
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="w-50 text-md-right">
                        <a href="{{ route('password.request') }}">Mot de passe oublié</a>
                    </div>
                </div>
            </form>
            {{-- <p class="text-center">Not a member? <a href="{{ route('register') }}">S'inscrire</a></p> --}}
        </div>
    </div>
    
@endsection


