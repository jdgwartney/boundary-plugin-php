#!/usr/bin/env php
<?php

function CreateMeasurement($user,$password,$data)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_POST, 1);
    if ($data) {
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD,$user . ':' . $password);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    curl_setopt($curl, CURLOPT_URL,'https://premium-api.boundary.com/v1/measurements');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

# Get default credentials from environment
$email = $_ENV['BOUNDARY_EMAIL'];
$api_token = $_ENV['BOUNDARY_API_TOKEN'];

# Set up the options needed for getopt() call
$shortopts  = "";
$shortopts .= "e:";
$shortopts .= "n:";
$shortopts .= "m:";
$shortopts .= "s:";
$shortopts .= "t:";

# Provided corresponding long options
$longopts  = array(
    "email:",
    "metric-name:",
    "measurement:",
    "source:",
    "api-token:",
);
$options = getopt($shortopts, $longopts);

# Extract the command line options
if(isset($options['e'])) {
  $email = $options['e'];
}
if(isset($options['n'])) {
  $metric_id = $options['n'];
}
if(isset($options['m'])) {
  $measurement = $options['m'];
}
if(isset($options['s'])) {
  $source = $options['s'];
} else {
  # Default to the localhost we are running on
  $source = gethostname();
}
if(isset($options['t'])) {
  $api_token = $options['t'];
}

# Check to see if we have the required data to make the Boundary measurement API call
if (isset($email) && isset($metric_id) && isset($measurement) && isset($source) && isset($api_token)) {
  # Post the data to Boundary
  $data = json_encode(array('source' => $source, 'metric' => $metric_id , 'measure' => $measurement));
#  $data = '{"source":"lerma","metric":"BOUNDARY_MEASUREMENT_TEST","measure": 10000}';
#  echo "$data\n";
  $result = CreateMeasurement($email,$api_token,$data);
  echo $result;
} else {
  $program=basename(__FILE__);
  print("usage: $program [-e <e-mail>] -n <metric-id> -m <measurement> [-s <source>] [-t <api-token>]\n");
  print("The environment variables BOUNDARY_EMAIL and BOUNDARY_API_TOKEN can bet set the values required for the -e and -t arguments respectfully\n");
  exit(1);
}
?>

