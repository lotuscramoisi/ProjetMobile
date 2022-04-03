<?php  
    $registration = $_POST['registration'];

    if ($registration == "success"){
        include 'fonctionUser.php';
        $userIp = getUserIP();
        $url = "https://ipgeolocation.abstractapi.com/v1/?api_key=8aa482a8a0d3496c83f1e6a6c748f79b&ip_address=".$userIp;
        $json = file_get_contents($url);

        echo json_encode(array("abc"=>'successfuly registered'.$json));
    }

?>