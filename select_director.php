<?php
    $select = $db->prepare('SELECT * FROM admins ');
    $select->execute();
    $admins = $select->fetchAll(PDO::FETCH_ASSOC);
?>