<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

//require_once('../../inc/Constants.php');
//require_once('../config.php');

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    
    $url = base_url() . 'services/v1/' . $url; // $result = $url;
    
    if ($data == null)
    {
        $data = [];
        $data['head'] = 'MurariM';
    }
    
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
        $apiKey = $_SESSION['api_key'];//'dde9ae0028ffa09742613dc013a65154';
        
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