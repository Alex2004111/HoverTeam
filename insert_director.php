<?php
if (isset($class) && isset($module)){
    $check = $db->prepare('SELECT COUNT(*) FROM admins WHERE class = :class and module = :module');
    $check->execute(['class' => $class , 'module' => $module]);
    $exists = $check->fetchColumn();
                    
    if ($exists >= 1) {
        $Admin = '<p class="verification">Un admin pour cette classe et ce module existe déjà !</p>';
    } else {
        $insert = $db->prepare('INSERT INTO admins (class,module,name,email,password) VALUES (:class,:module,:name,:email,:password)');
        $insert->execute(['class' => $class ,'module' => $module, 'name' => $name, 'email' => $email,'password' => $password]);
    }                
}
?>