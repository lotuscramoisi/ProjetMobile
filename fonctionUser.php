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

    function all(){
        return strval($_SERVER);
    }

    function getBrowser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = "N/A";
        
        $browsers = array(
        '/msie/i' => 'Internet explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/mobile/i' => 'Mobile browser'
        );
        
        foreach ($browsers as $regex => $value) {
        if (preg_match($regex, $user_agent)) { $browser = $value; }
        }
        
        return $browser;
    }

    function getOS(){
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $operating_system = 'Unknown Operating System';

        //Get the operating_system name
        if (preg_match('/linux/i', $u_agent)) {
            $operating_system = 'Linux';
        } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
            $operating_system = 'Mac';
        } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
            $operating_system = 'Windows';
        } elseif (preg_match('/ubuntu/i', $u_agent)) {
            $operating_system = 'Ubuntu';
        } elseif (preg_match('/iphone/i', $u_agent)) {
            $operating_system = 'IPhone';
        } elseif (preg_match('/ipod/i', $u_agent)) {
            $operating_system = 'IPod';
        } elseif (preg_match('/ipad/i', $u_agent)) {
            $operating_system = 'IPad';
        } elseif (preg_match('/android/i', $u_agent)) {
            $operating_system = 'Android';
        } elseif (preg_match('/blackberry/i', $u_agent)) {
            $operating_system = 'Blackberry';
        } elseif (preg_match('/webos/i', $u_agent)) {
            $operating_system = 'Mobile';
        }
        
        return $operating_system;
    }
	
	function getResol(){
		$resol='<script type="text/javascript">
						document.write(""+screen.width+"*"+screen.height+" pixels");
				</script>';
		return $resol;
	}
	
	function getBitsScreen(){
		$bits='<script type="text/javascript">
						document.write(""+screen.colorDepth+" bits");
				</script>';
		return $bits;
	}
	
	function getNavigatorLang(){
		echo substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
	}
	
	function getBattery(){
		$b = '<script type="text/javascript">
				navigator.getBattery().then(battery => {
				let b = ""
				b = Math.floor(battery.level * 100) + "%"

				if (battery.charging) {
					b+=" sur secteur"
				}
				else{
					b+=" sur batterie"
				} 
				document.getElementById("Batterie").innerHTML = b; 
			})
		</script>';
		return $b;
	}
	
	function getMemory(){
		$m = '<script type="text/javascript">
				let m = navigator.deviceMemory
				m += " Gio de RAM"
				document.getElementById("Memoire").innerHTML = m; 
		</script>';
		return $m;
	}
	
	function getNbCoeurs(){
		$c = '<script type="text/javascript">
				let c = navigator.hardwareConcurrency
				c += " coeurs logiques"
				document.getElementById("NbCoeurs").innerHTML = c; 
		</script>';
		return $c;
	}
	
	function getMultiTouch(){
		$mt = '<script type="text/javascript">
				let mt = navigator.maxTouchPoints
				if(mt > 0 && mt <= 10) {
					mt += " points simultanés"
				}
				else {
					mt = "Pas de Multi-Touch"
				}
				document.getElementById("MultiTouch").innerHTML = mt; 
		</script>';
		return $mt;
	}
	
	function getVendor(){
		$v = '<script type="text/javascript">
				let v = navigator.vendor
				document.getElementById("Vendor").innerHTML = v; 
		</script>';
		return $v;
	}

	function getNetworkInformation(){
		$network = '<script type="text/javascript">
		let NetworkInformation = navigator.connection.type;
		if(NetworkInformation == null) {
			NetworkInformation = "Pas sur mobile";
		}
		document.getElementById("NetworkInformation").innerHTML = NetworkInformation; 
		</script>';
		return $network;
	}
	
	function getTimeLocal(){
		$date = date('h:i:s');
		return $date;
	}
?>
