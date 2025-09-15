<!--
1. Init
$ch = curl_init();

2. Options set করো
curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/posts/1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

3. Execute request
$response = curl_exec($ch);

4. Close
curl_close($ch);

5. Response দেখা
/echo $response;



  $ch =  curl_init(); 
  
   curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1' );
   
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $RESPONSE =  curl_exec($ch); 
   
   curl_close($ch);

  echo $RESPONSE;
 

API Config

-->


<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://pyncparcel.com/rpc/public.v1.PublicService/ListCourierCustomers");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Logis-Auth:pub_key_b69a6da70a88c9680b3da6f104762be443843d107673686491",
    "Content-Type: application/json"
]);

$body = [
    "cursor" => "",
    "limit" => 10
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "HTTP Status: " . $statusCode . "\n\n";

    $decoded = json_decode($response, true);
    if ($decoded) { 
	
	
       print_r($decoded); 
       echo $decoded['customers'][0]['id']; 
		
		
    } else {
        echo "Raw Response:\n" . $response;
    }
}

curl_close($ch); 


 
 
 
 
 
 
 
 
 
?>

 
 
 