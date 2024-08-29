<?php

function insert_logs($action){
    include('../PHP/db.php');

    $login_req = 'SELECT * FROM users WHERE firstname = :firstname';
    $login_query = $dbh->prepare($login_req);
    $login_query->bindParam(':firstname', $_SESSION['firstname']);
    $login_query->execute();
    $row_login = $login_query->fetch(PDO::FETCH_ASSOC);

    $ip = $_SERVER['REMOTE_ADDR'];
    $date_now = date('Y-m-d H:i:s');
    $firstname = $_SESSION['firstname'];
    $email = $row_login['email'];

    $logs_req = 'INSERT INTO logs(action, ip, date, firstname, email) VALUES(:action, :ip, :date, :firstname, :email)';
    $logs_query = $dbh->prepare($logs_req);
    $logs_query->bindParam(':action', $action);
    $logs_query->bindParam(':ip', $ip);
    $logs_query->bindParam(':date', $date_now);
    $logs_query->bindParam(':firstname', $firstname);
    $logs_query->bindParam(':email', $email);
    $logs_query->execute();

}
?>