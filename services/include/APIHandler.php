<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value


function CallAPI($method, $url, $data = false)
{        
    $curl = curl_init();
    
    $base_service_url = 'http://localhost:81/m/mcc/services/v1/';
    $url = $base_service_url . $url;
    
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
            
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
            
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    if (isset($_SESSION['api_key']))
    {
        $apiKey = $_SESSION['api_key'];//'dde9ae0028ffa09742613dc013a65154';//$_SESSION['api_key']
        
        //curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'authorization: ' . $apiKey
        ));
    }

    $result = curl_exec($curl);
    ///echo $result;
    curl_close($curl);

    return $result;
}
?>