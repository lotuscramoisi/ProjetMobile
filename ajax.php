<?php  

if(isset($_GET["fname"]) && isset($_GET["lname"])) {
    $fname = htmlspecialchars($_GET["fname"]);
    $lname = htmlspecialchars($_GET["lname"]);
    
    // Creating full name by joining first and last name
    $fullname = $fname . " " . $lname;

    // Displaying a welcome message
    echo "Hello, $fullname! Welcome to our website.";
} else {
    echo "Hi there! Welcome to our website.";
}
    // <script>
    //     $.getJSON("https://ipgeolocation.abstractapi.com/v1/?api_key=8aa482a8a0d3496c83f1e6a6c748f79b&ip_address=166.171.248.255", function(data) {
    //         console.log(data.ip_address);
    //         console.logget(data.country);
    //     })
            
    // </script>
?>