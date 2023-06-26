

<?php
$host = "localhost"; 
$username = "root"; 
$password = "123";
$database = "login"; 

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $stmt = mysqli_prepare($connection, "SELECT * FROM auth WHERE username=? AND password=?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
    
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
    
        if ($role === 'admin') {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: customer.php");
            exit();
        }
    } else {
        $login_error = "Invalid username or password.";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
  <h1>Login</h1>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
  </form>
  <?php if (isset($login_error)) { echo $login_error; } ?>
</body>
</html>
