<?php  
    $registration = $_POST['registration'];

    if ($registration == "success"){
        include 'fonctionUser.php';
        $userIp = getUserIP();

        echo json_encode(array("abc"=>'successfuly registered'.$userIp));
    }

?>