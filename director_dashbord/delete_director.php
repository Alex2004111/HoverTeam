<?php   
    $check = $db->prepare('SELECT COUNT(*) FROM admins WHERE class = :class and module = :module');
    $check->execute(['class' => $class , 'module' => $module]);
    $exists = $check->fetchColumn();
    if ($exists === 0) {
        $delAdmin = '<p class="verification">Cet admin n\'existe pas !</p>';
    }else {
        $delete = $db->prepare('DELETE FROM admins WHERE class = :class AND module = :module');
        $delete->execute(['class' => $class, 'module' => $module]);
    }
    
?>
