<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: contacts.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    

    $valid_username = 'admin';
    $valid_password = 'admin123';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        
        header('Location: contacts.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .login-header h1 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1><i class="bi bi-person-lines-fill"></i> Manajemen Kontak</h1>
                <p class="mb-0">Silakan login untuk melanjutkan</p>
            </div>
            
            <div class="login-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
