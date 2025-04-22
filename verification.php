<?php
session_start();
include('data.php');

$nom = $_POST['name'];
$email = $_POST['email'];
$class = $_POST['class'];
$module = $_POST['module'];
$password = $_POST['password'];

$sql = $db->prepare("SELECT * FROM admins WHERE name = ? AND email = ? AND class = ? AND module = ?");
$sql->execute([$nom, $email, $class, $module]);

if ($sql->rowCount() > 0) {
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
}
//$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

return false;
?>
