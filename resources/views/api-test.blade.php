<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input { width: 100%; padding: 8px; margin-top: 5px; }
        button { background: #4CAF50; color: white; padding: 10px; border: none; cursor: pointer; }
        #result { margin-top: 20px; padding: 15px; background: #f5f5f5; white-space: pre-wrap; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Test Login API</h1>
    
    <div class="form-group">
        <label>Username:</label>
        <input type="text" id="username" required>
    </div>
    
    <div class="form-group">
        <label>Password:</label>
        <input type="password" id="password" required>
    </div>
    
    <button onclick="submitLogin()">Login</button>
    
    <div id="error" class="error"></div>
    
    <h2>API Response:</h2>
    <div id="result">Response akan muncul di sini...</div>

    <script>
       async function submitLogin() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const resultDiv = document.getElementById('result');
    const errorDiv = document.getElementById('error');
    
    errorDiv.textContent = '';
    resultDiv.textContent = 'Mengirim request...';
    
    // Hapus info user sebelumnya jika ada
    const oldUserInfo = document.getElementById('user-info');
    if (oldUserInfo) oldUserInfo.remove();
    
    try {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                username: username,
                password: password
            })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            resultDiv.textContent = JSON.stringify(data, null, 2);
            
            // Ambil dan tampilkan data user
            const userName =   data.message?.name || 'Nama tidak tersedia';
            const userNip =    data.message?.nipbaru || 'NIP tidak tersedia';
            
            const userInfoDiv = document.createElement('div');
            userInfoDiv.id = 'user-info';
            userInfoDiv.innerHTML = `
                <h3>Informasi User:</h3>
                <p>Nama: <strong>${userName}</strong></p>
                <p>NIP: <strong>${userNip}</strong></p>
                <p>Nama: <strong>${username}</strong></p>
            `;
            userInfoDiv.style.marginTop = '20px';
            userInfoDiv.style.padding = '15px';
            userInfoDiv.style.backgroundColor = '#e8f5e9';
            userInfoDiv.style.borderRadius = '5px';
            
            resultDiv.insertAdjacentElement('afterend', userInfoDiv);
            
        } else {
            errorDiv.textContent = data.error || 'Login failed';
            resultDiv.textContent = JSON.stringify(data, null, 2);
        }
    } catch (error) {
        errorDiv.textContent = 'Terjadi kesalahan: ' + error.message;
        resultDiv.textContent = '';
        console.error('Error:', error);
    }
}
    </script>
</body>
</html>