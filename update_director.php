<?php
    $check = $db->prepare('SELECT COUNT(*) FROM admins WHERE class = :class and module = :module');
    $check->execute(['class' => $class , 'module' => $module]);
    $exists = $check->fetchColumn();
    if ($exists === 0) {
        $idError = '<p class="verification">Cet ID n\'existe pas !</p>';
    }else {
        $update = $db->prepare('UPDATE admins SET name= :name, email = :email, password = :password WHERE class = :class and module = :module');
        $update->execute(['class' => $class ,'module' => $module, 'name' => $name, 'email' => $email,'password' => $password]);
    }
    
    
?>