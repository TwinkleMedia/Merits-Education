

<?php
// login.php
session_start();
include './dbconfig.php'; // Make sure this path is correct

$error = ""; // Initialize error message variable

// If already logged in, redirect to admin page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add error logging to help debug
    error_log("Login attempt for username: " . trim($_POST['username']));
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        // Fetch user details securely
        $sql = "SELECT * FROM adminuser WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Debug logging - DO NOT use in production
            error_log("Password verification: Input vs Stored");
            
            if (password_verify($password, $row['password'])) {
                // Password is correct
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id']; // Store user ID if available
                $_SESSION['last_activity'] = time(); // Track session time
                
                // Debug successful login
                error_log("Login successful for: " . $username);
                
                // Redirect to admin page
                header("Location: ../admin.php");
                exit();
            } else {
                $error = "Invalid Username or Password!";
                error_log("Password verification failed for: " . $username);
            }
        } else {
            $error = "Invalid Username or Password!";
            error_log("User not found: " . $username);
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center" style="color: white;">Admin Login</h2>
    <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
