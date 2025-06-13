<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Complétion de profil utilisateur">
    <title>Compléter le profil - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
</head>

<body class="login-container">
    <form action="{{ route('profile.complete.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="login-box">
            <div class="login-form center">

                <a href="#" class="login-logo">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" />
                </a>

                <div class="login-welcome">Compléter le profil</div>

                @if ($errors->any())
                    <div class="alert alert-danger text-start">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label" for="first_name">Prénom <span class="text-danger">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="last_name">Nom <span class="text-danger">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">Nom d'utilisateur <span class="text-danger">*</span></label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">Téléphone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="address">Adresse</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="image">Photo de profil</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <div class="login-form-actions">
                    <button type="submit" class="btn">
                        <span class="icon"><i class="bi bi-arrow-right-circle"></i></span>
                        Mettre à jour le profil
                    </button>
                </div>

            </div>
        </div>
    </form>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
