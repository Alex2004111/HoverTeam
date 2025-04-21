<?php
include('data.php');



$sql = $db->prepare("SELECT * FROM admins WHERE name = ? AND email = ? AND class = ? AND module = ? AND password = ? ");
$sql->execute([$nom, $email, $class, $module, $password]);


if ($sql->rowCount() > 0) {
    $_SESSION['user'] = $sql->fetch(PDO::FETCH_ASSOC);
    return true;
} else {
    return false;
}
?>