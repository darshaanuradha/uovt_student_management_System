<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UOVT Student Management System</title>
</head>
<body>
   <div>
        <div>
            <h1>UOVT SMS</h1>
            <p>Sign in to your account</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div>
                Invalid credentials or empty fields.
            </div>
        <?php endif; ?>

        <form action="../application/auth.php" method="POST">
            <div>
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">
                Log In
            </button>
        </form>
    </div>
</body>
</html>

