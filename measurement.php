<?php

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

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
    curl_setopt($curl, CURLOPT_USERPWD,'davidg@boundary.com:api.12cdfbe657-7053');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

// Post the data to boundary
$hostname = gethostname();
$data = json_encode(array('source' => $hostname, 'metric' => 'BOUNDARY_MEASUREMENT_TEST', 'measure' => '10000'));
#echo $data;

$result = CallAPI('POST','https://premium-api.boundary.com/v1/measurements',$data);
echo $result;

