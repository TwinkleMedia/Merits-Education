<?php session_start(); 
include './dbconfig.php';

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
            header("Location: ../admin/admin.php");
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
            header("Location: ../admin/admin.php");
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
