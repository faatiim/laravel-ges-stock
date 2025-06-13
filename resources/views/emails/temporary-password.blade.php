<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur {{ config('app.name') }}</title>
</head>
<body>
    <p>Bonjour {{ $user->first_name ?? 'utilisateur' }},</p>

    <p>Un compte a été créé pour vous sur notre plateforme <strong>{{ config('app.name') }}</strong>.</p>

    <p>Voici vos identifiants de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe temporaire :</strong> <span style="color: #d9534f;">{{ $password }}</span></li>
    </ul>

    <p>Merci de vous connecter dès que possible afin de :</p>
    <ol>
        <li>Modifier votre mot de passe (ce mot de passe expire dans <strong>48h</strong>).</li>
        <li>Compléter les informations de votre profil utilisateur.</li>
    </ol>

    <p>
        ▶️ <a href="{{ url('/') }}" style="color: #337ab7;">Accéder à la plateforme</a>
    </p>

    <hr>
    <p style="font-size: 0.9em; color: #777;">
        Si vous n'êtes pas à l’origine de cette inscription, merci d’ignorer cet email ou de nous contacter.
    </p>

    <p>
        Cordialement,<br>
        L'équipe {{ config('app.name') }}
    </p>
</body>
</html>



{{-- <p>Bonjour,</p>

<p>Un compte vient d’être créé pour vous sur notre plateforme Stock Quincaillerie.</p>

<p><strong>Email :</strong> {{ $email }}</p>
<p><strong>Mot de passe temporaire :</strong> {{ $password }}</p>

<p>Veuillez vous connecter dès que possible, et suivre la procédure de mise à jour de votre mot de passe et de votre profil.</p>

<p><em>⚠️ Ce mot de passe expirera dans 48 heures.</em></p>

<p>Cordialement,<br>L'équipe Support</p> --}}
