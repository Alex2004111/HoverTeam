<?php
session_start();
include('data.php');
$idError = "";
$nomError = "";
$emailError = "";
$deleteError = "";
$emailRegex = '/^[a-zA-Z0-9]+([-._]?[a-zA-Z0-9])*@{1}[a-zA-Z0-9]+([-._]?[a-zA-Z0-9])*[a-zA-Z0-9]{2,8}$/';

if (!isset($_SESSION['user'])) {
  header('Location: ../login/login.php');
  exit;
};
if ($_SERVER['REQUEST_METHOD'] && isset($_POST['action'])) {

  if ($_POST['action'] == 'logout') {
      include('../login/logout.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = $_POST['id'] ?? '';
  $nom = $_POST['nom'] ?? '';
  $email = $_POST['email'] ?? '';
  $action = $_POST['action'] ?? '';

  if (empty($id)) {
    $idError = '<p class="Erreur">Remplir le champ</p>';
  } elseif (!preg_match('/^[0-9]{1,11}$/', $id)) {
    $idError = '<p class="verification">Syntax Erreur</p>';
  }

  if (empty($nom)) {
    $nomError = '<p class="Erreur">Remplir le champ</p>';
  } elseif (!preg_match('/^[a-zA-Z]{3,15}$/', $nom)) {
    $nomError = '<p class="verification">Syntax Erreur</p>';
  }

  if (empty($email)) {
    $emailError = '<p class="Erreur">Entrez votre email</p>';
  } elseif (!preg_match(/*'/^[a-zA-Z0-9._-]+@gmail\.com$/'*/ $emailRegex, $email)) {
    $emailError = '<p class="verification">Syntax Erreur</p>';
  }

  if (empty($idError) && empty($nomError) && empty($emailError)) {
    $_SESSION['id'] = $id;
    $_SESSION['nom'] = $nom;
    $_SESSION['email'] = $email;
    if ($_POST['action'] == 'add') {
      include('insert.php');
    }
    if ($_POST['action'] == 'update') {
      include('update.php');
    }
  }
  
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idd'])) {
  if (empty($deleteError)) {
    $_SESSION['idd'] = $_POST['idd'];
    if ($_POST['action'] == 'delete') {
      include('delete.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Form and Table Layout</title>
  <link rel= 'icon' href = "https://cdn-icons-png.flaticon.com/512/6915/6915669.png" >
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100%;

    }

    .container {
      display: flex;
      width: 100%;
      flex-wrap: wrap;
    }

    .form-section {
      width: 40%;
      padding: 30px;
      background-color: #f5f5f5;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .form-section h2 {
      margin-bottom: 20px;
    }

    .form-section form {
      display: flex;
      flex-direction: column;
    }

    .form-section label {
      margin-top: 10px;
      margin-bottom: 5px;
    }

    .form-section input {
      padding: 8px;
      font-size: 16px;
    }

    .form-section button {
      margin-top: 20px;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
    }

    .table-section {
      flex: 1;
      padding: 30px;
    }

    .table-section h2 {
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    img {
      width: 200px;
    }

    .Erreur,
    .verification {
      color: red;
      font-size: 12px;
      margin-top: 5px;
    }

    .delink {
      color : red;
      cursor: pointer;
    }
    .delink.show {
      color: green;
    }
    .delink:hover {
      position: relative;
      left : 3px
    }
    .delForm {
      height: 0;
      opacity: 0;
      overflow: hidden;
      transition: all 0.5s ease;
    }
    .delForm.show{
      height: 150px; 
      opacity: 1;
    }

    [value = 'logout'] {
      background-color: #e74c3c; 
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      position: absolute;
      top: 10px;
      right: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    [value = 'logout']:hover {
      background-color: #c0392b;
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
  </style>
</head>

<body>
  <form method = "post">
   <button name ='action' value='logout'>Log out</button> 
  </form>
  <div class="container">
    <div class="form-section">
      <img src="https://cdn-icons-png.flaticon.com/512/6915/6915669.png">
      <h2>Admin Dashboard</h2>
      <form method="POST">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id">
        <?php echo $idError; ?>

        <label for="nom">Name:</label>
        <input type="text" name="nom" id="nom">
        <?php echo $nomError; ?>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <?php echo $emailError; ?>

        <button type="submit" name="action" value="add">ADD</button>
        <button type="submit" name="action" value="update">UPDATE</button>
      </form>
      <p class='delink'>৲ DELETE</p>
      <form method="post" class = 'delForm'>
        <label for="id">ID:</label>
        <input type="text" name="idd" id="idd">
        <?php echo $deleteError; ?>
        <button type="submit" name="action" value="delete">DELETE</button>
    </form>
    </div>

    <div class="table-section">
      <h2>Information Table</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <?php
  include('select.php');
  ?>
  <script>
    let tbody = document.querySelector('tbody');
    tbody.innerHTML = "";
    let infos = <?php echo json_encode($_SESSION['info']); ?>;
    infos.forEach(info => {
      let tr = `<tr>
            <td>${info['id']}</td>
            <td>${info['nom']}</td>
            <td>${info['email']}</td>
            </tr>`;
      tbody.innerHTML += tr;
    });
    let delink = document.querySelector('.delink');
    let delForm = document.querySelector('.delForm');
    let error = document.querySelector('input#idd + p');
    if (error) {
      delForm.classList.toggle('show');
      delink.classList.toggle('show');
    }
    delink.addEventListener('click', (e)=>{
      delForm.classList.toggle('show');
      delink.classList.toggle('show');
    })
  </script>

</body>

</html>
