<?php
    require __DIR__. '/vendor/autoload.php';
    $registration = $_POST['registration'];

    if ($registration == "success"){
        include 'fonctionUser.php';
        $userIp = getUserIP(); 

        // Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute the request.
        $data = curl_exec($ch);

        // Close the cURL handle.
        curl_close($ch);
        //test
        // Print the data out onto the page.
        echo json_encode(array("abc"=>'successfuly registered'.$data));
    }

?>