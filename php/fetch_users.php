<?php
include 'models/Database.php'; 


$sql = "SELECT id, firstname, lastname, email, gender FROM users";
$stmt = $dbh->query($sql);

$users = [];
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }
} else {
    $users = []; 
}


include 'views/users.view.php';
?>
