<?php

	// Fonction de récupération de l'IP
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
	
	// Fonction de récupération du proxy
	function getUserIPFromProxy(){
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//IP from proxy
			$address=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
		return strval($address);
	}

	// Fonction de récupération du proxy
	function getUserIPFromInternet(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //IP from internet
            $address=$_SERVER['HTTP_CLIENT_IP'];
        }
		if($address == ""){
			$address = "Non disponible";
		}
		return strval($address);
	}

	// Fonction de récupération du port
    function getUserPort(){
        return $_SERVER['REMOTE_PORT'];
    }

	// Fonction de renvoi de toutes les informations server
    function all(){
        return strval($_SERVER);
    }

	// Fonction de renvoi du navigateur utilisé
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

	// Fonction de renvoi du système d'exploitation utilisé
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
	
	// Fonction de renvoi de la résolution de l'écran
	function getResol(){
		$resol='<script type="text/javascript">
						document.write(""+screen.width+" X "+screen.height+" pixels");
				</script>';
		return $resol;
	}
	
	// Fonction de renvoi de la profondeur de couleur d'écran
	function getBitsScreen(){
		$bits='<script type="text/javascript">
						document.write(""+screen.colorDepth+" bits");
				</script>';
		return $bits;
	}
	
	// Fonction de renvoi de la langue du navigateur
	function getNavigatorLang(){
		echo substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
	}
	
	// Fonction de renvoi du niveau de batterie sur batterie ou secteur
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
	
	// Fonction de renvoi de la Gio de RAM de l'appareil
	function getMemory(){
		$m = '<script type="text/javascript">
				let m = navigator.deviceMemory
				m += " Gio de RAM"
				document.getElementById("Memoire").innerHTML = m; 
		</script>';
		return $m;
	}
	
	// Fonction de renvoi du nombre de coeurs logiques de l'appareil
	function getNbCoeurs(){
		$c = '<script type="text/javascript">
				let c = navigator.hardwareConcurrency
				c += " coeurs logiques"
				document.getElementById("NbCoeurs").innerHTML = c; 
		</script>';
		return $c;
	}
	
	// Fonction de renvoi du nombre de points simultanés
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
	
	// Fonction de renvoi du nom du fabricant du navigateur
	function getVendor(){
		$v = '<script type="text/javascript">
				let v = navigator.vendor
				document.getElementById("Vendor").innerHTML = v; 
		</script>';
		return $v;
	}

	// Fonction de renvoi du type de connexion mobile
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
	
	// Fonction de renvoi de l'heure locale
	function getTimeLocal(){
		$timeLocal = '<script type="text/javascript">
		var now = new Date();
		var heure = ("0"+now.getHours()  ).slice(-2);
		var minute = ("0"+now.getMinutes()).slice(-2);
		var seconde = ("0"+now.getSeconds()).slice(-2);
		let timeLocal = heure + ":" + minute + ":" + seconde;
		document.getElementById("HeureConnLoc").innerHTML = timeLocal; 
		</script>';
		return $timeLocal;
	}
	
	// Fonction de renvoi du type d'appareil utilisé
	function getDevice(){
		$device = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/iphone/i',$device))
		{
			return "IPhone";
		}
		elseif(preg_match('/android/i',$device))
		{
			return "Android";
		}
		elseif(preg_match('/blackberry/i',$device))
		{
			return "BlackBerry";
		}
		elseif(preg_match('/blackberry/i',$device))
		{
			return "Symbian";
		}
		elseif(preg_match('/ipad/i',$device))
		{
			return "IPad";
		}
		elseif(preg_match('/ipad/i',$device))
		{
			return "IPod";
		}
		elseif(preg_match('/phone/i',$device))
		{
			return "Téléphone";
		}
		else
		{
			return "Ordinateur";
		}
	}
	
	// Fonction de renvoi de la taille de la mémoire cache
	function getCacheSize(){
		return round(realpath_cache_size() / 100) . " Kb";
	}
	
	function getCookies(){
		$cook = '<script type="text/javascript">
					if (!navigator.cookieEnabled) {
						document.getElementById("Cookies").innerHTML = "Activé";
					}
					else {
						document.getElementById("Cookies").innerHTML = "Désactivé";
					}
		</script>';
		return $cook;
	}
	
	// Fonctionde renvoi de la présence d'un visualiseur de pdf dans le navigateur
	function getPdfViewer(){
		$pdf = '<script type="text/javascript">
					if (!navigator.pdfViewerEnabled) {
						document.getElementById("PdfViewer").innerHTML = "Désactivé";
					}
					else {
						document.getElementById("PdfViewer").innerHTML = "Activé";
					}
		</script>';
		return $pdf;
	}
	
	// Fonction de renvoi de la présence d'un bloqueur de pub avec simulation d'une pub 
	function getPub(){
		$pub = '<script>
					let fakeAd = document.createElement("div");
					fakeAd.className = "textads banner-ads banner_ads ad-unit ad-zone ad-space adsbox"
						  
					fakeAd.style.height = "1px"
						
					document.body.appendChild(fakeAd)
						
					let x_width = fakeAd.offsetHeight;
					let msg = document.getElementById("msg")
							  
					if(x_width){
						document.getElementById("Pub").innerHTML = "Désactivé";
					}
					else{
						document.getElementById("Pub").innerHTML = "Activé";
					}
				</script>';
		return $pub;
	}
	
	// Fonction de renvoi de l'orientation de l'écran
	function getOrient(){
		$orient = '<script>
					var orient = screen.orientation.type;
					var orientDeg = screen.orientation.angle + "°";
					if(orient == "landscape-primary" || orient == "landscape-secondary") {
						orient = "Paysage";
					}
					else {
						orient = "Portrait";
					}
					document.getElementById("Orient").innerHTML = orient + " (" + orientDeg + ")";
					screen.orientation.onchange = function(e) {
						orient = screen.orientation.type;
						orientDeg = screen.orientation.angle + "°";
						if(orient == "landscape-primary" || orient == "landscape-secondary") {
						orient = "Paysage";
						}
						else {
							orient = "Portrait";
						}
						document.getElementById("Orient").innerHTML = orient + " (" + orientDeg + ")";
					}
				</script>';
		return $orient;
	}
	
	// Fonction de renvoi de la gyroscopie en X
	function getGyroX(){
		$gyroX = '<script>
					function process(event) {
					  var beta = event.beta;
					  if(beta != null) {
						document.getElementById("GyroX").innerHTML = "X : " + beta.toFixed(2) + "°"; 
					  }
					  else {
						document.getElementById("GyroX").innerHTML = "Technologie non disponible";
					  }
					}
					if(window.DeviceOrientationEvent) {
					  window.addEventListener("deviceorientation", process);
					}
				</script>';
		return $gyroX;
	}
	
	// Fonction de renvoi de la gyroscopie en Y
	function getGyroY(){
		$gyroY = '<script>
					function process(event) {
					  var gamma = event.gamma;
					  if(gamma != null) {
						document.getElementById("GyroY").innerHTML = "Y : " + gamma.toFixed(2) + "°"; 
					  }
					  else {
						document.getElementById("GyroY").innerHTML = "Technologie non disponible";
					  }
					}
					if(window.DeviceOrientationEvent) {
					  window.addEventListener("deviceorientation", process);
					}
				</script>';
		return $gyroY;
	}
	
	// Fonction de renvoi de la gyroscopie en Z
	function getGyroZ(){
		$gyroZ = '<script>
					function process(event) {
					  var alpha = event.alpha;
					  if(alpha != null) {
						document.getElementById("GyroZ").innerHTML = "Z : " + alpha.toFixed(2) + "°"; 
					  }
					  else {
						document.getElementById("GyroZ").innerHTML = "Technologie non disponible";
					  }
					}
					if(window.DeviceOrientationEvent) {
					  window.addEventListener("deviceorientation", process);
					}
				</script>';
		return $gyroZ;
	}
	
	// Fonction de renvoi de la valeur de l'accéléromètre en X
	function getAccelX(){
		$accelX = '<script>
					function motion(event){
						var accelX = event.accelerationIncludingGravity.x;
						if(accelX != null) {
							document.getElementById("AccelX").innerHTML = "X : " + accelX.toFixed(2) + " m/s²";
						}
						else {
							document.getElementById("AccelX").innerHTML = "Technologie non disponible";
						}
					}
					if(window.DeviceMotionEvent) {
					  window.addEventListener("devicemotion", motion);
					}
				</script>';
		return $accelX;
	}
	
	// Fonction de renvoi de la valeur de l'accéléromètre en Y
	function getAccelY(){
		$accelY = '<script>
					function motion(event){
						var accelY = event.accelerationIncludingGravity.y;
						if(accelY != null) {
							document.getElementById("AccelY").innerHTML = "Y : " + accelY.toFixed(2) + " m/s²";
						}
						else {
							document.getElementById("AccelY").innerHTML = "Technologie non diponible";
						}
					}
					if(window.DeviceMotionEvent) {
					  window.addEventListener("devicemotion", motion);
					}
				</script>';
		return $accelY;
	}
	
	// Fonction de renvoi de la valeur de l'accéléromètre en Z
	function getAccelZ(){
		$accelZ = '<script>
					function motion(event){
						var accelZ = event.accelerationIncludingGravity.z;
						if(accelZ != null) {
							document.getElementById("AccelZ").innerHTML = "Z : " + accelZ.toFixed(2) + " m/s²";
						}
						else {
							document.getElementById("AccelZ").innerHTML  = "Technologie non disponible";
						}
					}
					if(window.DeviceMotionEvent) {
					  window.addEventListener("devicemotion", motion);
					}
				</script>';
		return $accelZ;
	}
?>
