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
    
    echo '</br>User IP Address is'.getUserIP();
    echo '</br>User Port:'.getUserPort();
    echo '</br>User Port:'.getBrowser();
    echo '</br>Navigateur par défaut:'.get_operating_system();
?>

