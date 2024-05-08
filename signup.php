<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
    }

    .form-container {
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .form-container h2 {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
    }

    .btn-primary {
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 10px 20px;
      cursor: pointer;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="form-container">
        <h2>Sign Up</h2>
        <form action="" method="POST">
        <div class="form-group">
          <label for="signupEmail">Username</label>
          <input type="text" class="form-control" name="uname" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="signupEmail">Email address</label>
          <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="signupPassword">Password</label>
          <input type="password" class="form-control" name="password">
        </div>
        
        <p>Login <a href="./">Now</a></p>
        <button type="submit" class="btn btn-primary">Sign Up</button>
  </form>
      </div>
    </div>
  
  </div>
</div>

</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uname, $email, $hashed_password);

    $username = $email;

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
