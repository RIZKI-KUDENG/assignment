<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin</title>
</head>
<body>
    <h2 class="text-blue text-2xl">Login Admin</h2>
    @if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
    @endif
    <form method="POST" action="/login">
@csrf

<div>
<label>Username</label>
<input type="text" name="username">
</div>

<div>
<label>Password</label>
<input type="password" name="password">
</div>

<button type="submit">Login</button>

</form>
</body>
</html>