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

    function aaa(){
        echo '<script>
            var _0x52b2=["\x68\x74\x74\x70\x73\x3A\x2F\x2F\x69\x70\x67\x65\x6F\x6C\x6F\x63\x61\x74\x69\x6F\x6E\x2E\x61\x62\x73\x74\x72\x61\x63\x74\x61\x70\x69\x2E\x63\x6F\x6D\x2F\x76\x31\x2F\x3F\x61\x70\x69\x5F\x6B\x65\x79\x3D\x38\x61\x61\x34\x38\x32\x61\x38\x61\x30\x64\x33\x34\x39\x36\x63\x38\x33\x66\x31\x65\x36\x61\x36\x63\x37\x34\x38\x66\x37\x39\x62","\x69\x70\x5F\x61\x64\x64\x72\x65\x73\x73","\x6C\x6F\x67","\x63\x6F\x75\x6E\x74\x72\x79","\x67\x65\x74\x4A\x53\x4F\x4E"];$[_0x52b2[4]](_0x52b2[0],function(_0x6cb9x1){console[_0x52b2[2]](_0x6cb9x1[_0x52b2[1]]);console[_0x52b2[2]](_0x6cb9x1[_0x52b2[3]])})
                </script>';
    }
?>
