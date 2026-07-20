<?php
// Step 1: Start session (this is where user data is stored)
session_start();
include 'config/db_connect.php';
include 'includes/header.php';

// Step 2: Check if user is already logged in
if (isset($_SESSION['CustomerID'])) {
    header("Location: dashboard.php");
    exit();
}

// Step 3: Check for success message from registration
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// Step 4: Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Step 5: Find user by email
    $sql = "SELECT * FROM customers WHERE C_Email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Step 6: Verify password
        if (password_verify($password, $user['C_Password'])) {
            // Step 7: Set session variables
            $_SESSION['CustomerID'] = $user['CustomerID'];
            $_SESSION['C_Name'] = $user['C_Name'];
            $_SESSION['C_Email'] = $user['C_Email'];
            
            // Step 8: Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Email not found. Please register first.";
    }
}
?>

<div class="container">
    <div class="auth-container">
        <h2>Login to NepalRent</h2>
        <p>Welcome back! Login to access your account</p>
        
        <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

<?php
// Same CSS as registration page
$extra_css = '
    .auth-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .auth-container h2 {
        text-align: center;
        margin-bottom: 5px;
    }
    .auth-container p {
        text-align: center;
        color: #777;
        margin-bottom: 20px;
    }
    .auth-container .alert {
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .auth-container .btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
    }
    .auth-container p a {
        color: #4CAF50;
        text-decoration: none;
    }
';
echo '<style>' . $extra_css . '</style>';

include 'includes/footer.php';
?>