<?php session_start(); 
include '../../Merits-Education/admin/login/dbconfig.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Fetch user details
    $sql = "SELECT * FROM adminuser WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Check if the password in the database is already hashed
        if (password_verify($password, $row['password'])) {
            // Password is hashed and verified
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: ../../Merits-Education/admin/admin.php");
            exit();
        } else if ($password === $row['password']) {
            // Password is stored as plaintext, but matches
            // This allows login and also updates to a hashed password for future security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE adminuser SET password = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $hashed_password, $username);
            $update_stmt->execute();
            $update_stmt->close();
            
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: ../../Merits-Education/admin/admin.php");
            exit();
        } else {
            $error = "Invalid Username or Password!";
        }
    } else {
        $error = "Invalid Username or Password!";
    }
    $stmt->close();
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
    <?php if (isset($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="">
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