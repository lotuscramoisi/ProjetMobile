<?php 
    $registration = $_POST['registration'];

    if ($registration == "success"){
        include 'fonctionUser.php';
        require_once realpath(__DIR__ . '/vendor/autoload.php');
        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Retrive env variable
        $userName = $_ENV['PRIVATE_KEY'];
        $userIp = getUserIP(); 

        $url = $userName.'&ip_address='.$userIp;

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
        echo json_encode($data);
    }

?>