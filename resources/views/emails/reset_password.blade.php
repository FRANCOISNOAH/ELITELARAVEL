<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
<h1>Réinitialisation du mot de passe</h1>

<p>Bonjour,</p>

<p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>

<p><a href="{{ $url }}">Cliquez ici pour réinitialiser votre mot de passe</a></p>

<p>Ce lien de réinitialisation expirera dans {{ config('auth.passwords.users.expire') }} minutes.</p>

<p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>

<p>Merci,</p>

<p>Votre équipe</p>
</body>
</html>
