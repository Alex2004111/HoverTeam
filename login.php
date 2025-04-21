<?php
session_start();
$nomError = $emailError = $classError = $moduleError = $passError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $class = $_POST['class'];
  $module = $_POST['module'];
  $password = $_POST['password'];

  if (empty($nom)) $nomError = '<p class="Erreur">Enter your name</p>';
  if (empty($email)) $emailError = '<p class="Erreur">Enter your email</p>';
  if (empty($password)) $passError = '<p class="Erreur">Enter your password</p>';

  if (empty($nomError) && empty($emailError) && empty($passError)) {
    $validUser = include('verification.php');

    if ($validUser) {
      header("Location: ../admin_dashbord/index.php");
      exit();
    } else {
      echo "<script>alert('Utilisateur non trouvé ou informations incorrectes.');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel= 'icon' href = "https://cdn-icons-png.flaticon.com/512/6915/6915669.png" >
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(45deg, #5aa1ed, #023e7e, #007bff);
      background-size: 400% 400%;
      animation: gradientMove 10s ease infinite;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes rotateTilt {
      0% { transform: rotate(0deg); }
      25% { transform: rotate(-2deg); }
      50% { transform: rotate(2deg); }
      75% { transform: rotate(-2deg); }
      100% { transform: rotate(0deg); }
    }

    .login-container {
      background-color: #c9d8e7;
      padding: 20px 15px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      width: 260px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.3s ease;
    }

    .login-container:hover {
      animation: rotateTilt 0.6s ease-in-out;
    }

    .login-container img {
      width: 60px;
      margin-bottom: 10px;
    }

    .login-container h2 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #333;
    }

    form {
      width: 100%;
    }

    label {
      font-size: 13px;
      margin: 4px 0 2px;
      color: #333;
    }

    input,
    select {
      width: 100%;
      padding: 7px 10px;
      margin-bottom: 5px;
      font-size: 13px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: all 0.2s;
    }

    input:focus,
    select:focus {
      border-color: #007bff;
      outline: none;
      box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
    }

    .Erreur {
      color: red;
      font-size: 11px;
      margin: 2px 0 6px;
    }

    button {
      width: 100%;
      padding: 8px;
      font-size: 13px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 8px;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="login-container">
  <img src="https://cdn-icons-png.flaticon.com/512/6915/6915669.png" alt="Logo">
  <h2>Login Form</h2>

  <form method="POST">
    <label for="class">Class:</label>
    <select name="class" id="class">
      <option value="DD101">DD101</option>
      <option value="DD102">DD102</option>
    </select>
    <?php echo $classError; ?>

    <label for="module">Module:</label>
    <select name="module" id="module">
      <option value="M101">M101</option>
      <option value="M102">M102</option>
    </select>
    <?php echo $moduleError; ?>

    <label for="nom">Name:</label>
    <input type="text" name="nom" id="nom">
    <?php echo $nomError; ?>

    <label for="email">Email:</label>
    <input type="text" name="email" id="email">
    <?php echo $emailError; ?>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <?php echo $passError; ?>

    <button type="submit" name="action" value="add">Login</button>
  </form>
</div>

</body>
</html>