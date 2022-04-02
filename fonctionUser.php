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
	
	function getUserIPFromProxy(){
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//IP from proxy
			$address=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
		return strval($address);
	}

	function getUserIPFromInternet(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //IP from internet
            $address=$_SERVER['HTTP_CLIENT_IP'];
        }
		return strval($address);
	}

    function getUserPort(){
        return $_SERVER['REMOTE_PORT'];
    }

    function getBrowser(){
        return $_SERVER['HTTP_USER_AGENT'];
    }

    function get_operating_system() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $operating_system = 'Unknown Operating System';

        return $operating_system;
    }
?>
