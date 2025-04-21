<?Php
  include('data.php');

$nameError = $passError = $Admin = $delAdmin = $clsErr = $modErr =
$emailError = $delmod = $delcls ="";
$emailRegex = '/^[a-zA-Z0-9]+([-._]?[a-zA-Z0-9])*@{1}[a-zA-Z0-9]+([-._]?[a-zA-Z0-9])*[a-zA-Z0-9]{2,8}$/';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class'])) {

  $class = $_POST['class'] ?? '';
  $module = $_POST['module'] ?? '';
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $action = $_POST['action'] ?? '';

  if (empty($class)) {
    $clsErr = '<p class="Erreur">Veuillez sélectionner une classe.</p>';
  }

  if (empty($module)) {
    $modErr = '<p class="Erreur">Veuillez sélectionner un module.</p>';
  }

  if (empty($name)) {
    $nameError = '<p class="Erreur">Remplir le champ</p>';
  } elseif (!preg_match('/^[A-Z][a-zA-Z]{3,}(?: [A-Z][a-zA-Z]{1,}){0,2}$/', $name)) {
    $nameError = '<p class="verification">Syntax Erreur</p>';
  }
  
  if (empty($email)) {
    $emailError = '<p class="Erreur">Entrez votre email</p>';
  } elseif (!preg_match($emailRegex, $email)) {
    $emailError = '<p class="verification">Syntax Erreur</p>';
  }

  if (empty($password)) {
    $passError = '<p class="Erreur">Remplir le champ</p>';
  } elseif (strlen($password) < 8) {
    $passError = '<p class="verification">Syntax Erreur</p>';
  }
  
  if (empty($passError) && empty($nameError) && empty($emailError) && empty($clsErr) && empty($modErr)) {
    if ($_POST['action'] == 'add') {
      include('insert_director.php');
    }
    if ($_POST['action'] == 'update') {
      include('update_director.php');
    }
  }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-module']) && isset($_POST['delete-class'])) {
  $class = $_POST['delete-class'];
  $module = $_POST['delete-module'];
  $del = true ;
  if (empty($class)) {
    $delcls = '<p class="Erreur">Veuillez sélectionner une classe.</p>';
    $del = false;
  }

  if (empty($module)) {
    $delmod = '<p class="Erreur">Veuillez sélectionner un module.</p>';
    $del = false;
  }

  if ($del && empty($delAdmin)) {
      
    if ($_POST['action'] == 'delete') {
      include('delete_director.php');
  }
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Director Dashboard</title>
  <link rel= 'icon' href = "https://cdn-icons-png.flaticon.com/512/3135/3135715.png" >
  <style>
    body {
      display: flex;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      overflow-x: hidden;
    }

    .toggle-btn {
      position: fixed;
      display: flex;
      align-items:center;
      justify-content: center;
      top: 5px;
      left: 20px;
      background: rgb(255, 0, 0);
      color: white;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      cursor: pointer;
      font-size: 18px;
      z-index: 1000;
      transition: transform 0.3s ease;
    }

    .sidebar {
      width: 500px;
      max-width: 80%;
      padding: 40px 20px;
      background: #f8f8f8;
      /* animation: slideIn 1s ease; */
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.4s ease;
      border-radius: 10px; 
    }

    .sidebar.closed {
      transform: translateX(-100%);
    }

    .sidebar img {
      width: 120px;
      margin-bottom: 20px;
      animation: zoomIn 1.5s ease;
    }

    h2 {
      color: #b30000;
      margin-bottom: 25px;
    }

    .Erreur,
    .verification {
      color: red;
      margin-top: 0;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
    }

    input , select{
      width: 100%;
      box-sizing: border-box;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px; 
    }

    button {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      font-size: 16px;
      background: #e60000;
      color: white;
      border: none;
      border-radius: 6px; 
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background: #cc0000;
    }

    .delete {
      color: red;
      font-weight: bold;
      cursor: pointer;
    }

    .content {
      flex: 1;
      padding: 40px;
      animation: fadeIn 1.5s ease;
      margin-left: 300px;
      transition: margin-left 0.4s ease;
    }

    .content.full {
      margin-left: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }

    th {
      background: rgb(205, 70, 70);
      color: white;
    }

    tr:nth-child(even) {
      background: #f2f2f2;
    }
    
    .delForm {
      margin-top: 20px;
      background: #f8f8f8;
      border-radius: 6px;
      height: 0;
      opacity: 0;
      overflow: hidden;
      transition: all 0.5s ease;
    }

    .delForm.show{
      height: fit-content; 
      opacity: 1;
    }
    
    .delink {
      color: red;
      cursor: pointer;
      font-weight: bold;
      transition: color 0.3s;
    }

    .delink:hover {
      color: green;
    }

    @keyframes slideIn {
      from { transform: translateX(-100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes zoomIn {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

  <button class="toggle-btn" id="toggleBtn">❰</button>
<div class="sidebar" id="sidebar">
  <form method = "POST" id = "sidebar">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Director Icon" />
    <h2>Director Dashboard</h2>
    <?php echo $Admin; ?>
    <label for="id">Class:</label>
    <select name="class" id="class">
      <option value=""></option>
      <option value="DD101">DD101</option>
      <option value="DD102">DD102</option>
    </select>
    <?php echo $clsErr; ?>
    <label for="module">Module:</label>
    <select name="module" id="module" >
      <option value=""></option>
      <option value="M101">M101</option>
      <option value="M102">M102</option>
    </select>
    <?php echo $modErr; ?>
    <label for="email">Full Name:</label>
    <input type="text" id="name" name="name"/>
    <?php echo $nameError; ?>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"/>
    <?php echo $emailError; ?>
    <label for="name">Password:</label>
    <input type="text" id="password" name="password"/>
    <?php echo $passError; ?>
    <button name = "action" value="add">ADD</button>
    <button name = "action" value="update">UPDATE</button>
    <p class="delink">৲ DELETE</p>
    
  </form>
  <form method = "POST" class="delForm" id = "delForm">
      <?php echo $delAdmin; ?>
      <label for="delete-class">Enter Class to delete:</label>
      <select name='delete-class' id='delete-class' >
        <option value=""></option>
        <option value="DD101">DD101</option>
        <option value="DD102">DD102</option>
      </select>
      <?php echo $delcls; ?>
      <label for="delete-module">Enter Module to delete:</label>
      <select name='delete-module' id='delete-module' >
        <option value=""></option>
        <option value="M101">M101</option>
        <option value="M102">M102</option>
      </select>
      <?php echo $delmod; ?>
      <button name = "action" value = "delete" >DELETE</button>
  </form>
  </div>

  <div class="content" id="content">
    <h2>Information Table</h2>
    <table>
      <thead>
        <tr>
          <th>Class</th>
          <th>Module</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Password</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
<?php include('select_director.php');?>
  <script>
    let tbody = document.querySelector('tbody');
    tbody.innerHTML = "";
    let admins = <?php echo json_encode($admins); ?>;
    console.log(admins);
    
    admins.forEach(admin => {
      let tr = `<tr>
            <td>${admin['Class']}</td>
            <td>${admin['Module']}</td>
            <td>${admin['Name']}</td>
            <td>${admin['Email']}</td>
            <td>${admin['Password']}</td>
            </tr>`;
      tbody.innerHTML += tr;
    });
    const toggleBtn = document.getElementById("toggleBtn");
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    const deleteLink = document.querySelector('.delink');
    const deleteForm = document.querySelector('.delForm');
    setTimeout(() => {
      sidebar.classList.remove('animate-once');
    }, 1500);
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("closed");
      content.classList.toggle("full");
      
      if (sidebar.classList.contains("closed")) {
        toggleBtn.innerHTML = "❱"; 
      } else {
        toggleBtn.innerHTML = "❰"; 
      }
    });
    
    let del = document.querySelector('.delForm  p');
    if (del) {
      deleteForm.classList.toggle('show');
    }

    deleteLink.addEventListener('click', () => {
      deleteForm.classList.toggle('show');
    });
  </script>

</body>
</html>
