<?php  
    $registration = $_POST['registration'];

    if ($registration == "success"){
        include 'fonctionUser.php';
        $userIp = getUserIP();
        $url = "https://ipgeolocation.abstractapi.com/v1/?api_key=8aa482a8a0d3496c83f1e6a6c748f79b&ip_address=166.171.248.255";
        $json = file_get_contents($url);
        // <script>
        //     $.getJSON("https://ipgeolocation.abstractapi.com/v1/?api_key=8aa482a8a0d3496c83f1e6a6c748f79b&ip_address=166.171.248.255", function(data) {
        //          console.log(data.ip_address);
        //      })   
        // </script>
        echo json_encode(array("abc"=>'successfuly registered'.$json));
    }

?>