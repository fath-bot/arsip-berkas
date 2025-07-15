<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm">
        <label>Username</label><br>
        <input type="text" name="username" id="username" required><br>

        <label>Password</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p id="errorMsg" style="color:red;"></p>

    <script>
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch("{{ route('login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ username, password })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    document.getElementById('errorMsg').innerText = data.message;
                }
            } catch (error) {
                document.getElementById('errorMsg').innerText = "Terjadi kesalahan. Coba lagi.";
            }
        });
    </script>
</body>
</html>
