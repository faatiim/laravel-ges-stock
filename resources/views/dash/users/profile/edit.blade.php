<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compléter le profil - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">

    <style>
        .form-wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group label {
            font-weight: 500;
        }

        .image-preview-box {
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
        }

        .image-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-light">

    <div class="form-wrapper">
        <form action="{{ route('profile.complete.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-title">Compléter votre profil</div>

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">Prénom <span class="text-danger">*</span></label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        @error('first_name')
                        <p class="mb-4"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Nom <span class="text-danger">*</span></label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        @error('last_name')
                        <p class="mb-4"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur <span class="text-danger">*</span></label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                        @error('username')
                        <p class="mb-4"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                        <p class="mb-4"> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                        @error('address')
                        <p class="mb-4"> {{ $message }}</p>
                      @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label">Photo de profil</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @error('image')
                    <p class="mb-4"> {{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Aperçu</label>
                    <div class="image-preview-box">
                        <img id="preview" src="#" alt="Aperçu" style="display: none;">
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-arrow-right-circle me-1"></i> Mettre à jour le profil
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>



{{-- <!doctype html>
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

</html> --}}
