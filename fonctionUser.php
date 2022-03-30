<?php
    function getUserIP(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //IP from internet
            $address=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //IP from proxy
            $address=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            $address=$_SERVER['REMOTE_ADDR'];
        }
        return strval($address);
    }

    function getUserPort(){
        return $_SERVER['REMOTE_PORT'];
    }

    function getBrowser(){
        return "Safari";
    }

    function get_operating_system() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $operating_system = 'Unknown Operating System';

        return $operating_system;
    }
?>

<script>
    $.getJSON("https://ipgeolocation.abstractapi.com/v1/?api_key=8aa482a8a0d3496c83f1e6a6c748f79b", function(data) {
    console.log(data.ip_address);
    console.log(data.country);
    })
</script>