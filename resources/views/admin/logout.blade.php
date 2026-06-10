<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Logout - Siakad App</title>
</head>
<body>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Keluar</button>
  </form>
</body>
</html>
