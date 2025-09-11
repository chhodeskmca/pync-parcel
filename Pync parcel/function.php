<?php 
 

//user account id in  COOKIE
 if(isset($_COOKIE['user_id'])) {
	 
      $user =  json_decode( $_COOKIE['user_id']);  
      $user_id = $user->id;
	
};
 //user account information in  this function
function user_account_information(){  

    global $conn;  
    global $user_id; 
	
    $sql = "SELECT * FROM users WHERE id = $user_id";  
    $result = mysqli_query($conn,  $sql);
	$rows  =  mysqli_fetch_assoc($result); 
	
	return array ( 
	
	 'FName' => $rows['FName'],
	 'LName' => $rows['LName'],
	 'PhoneNumber' => $rows['PhoneNumber'],
	 'EmailAddress' => $rows['EmailAddress'],
	 'DateOfBirth' => $rows['DateOfBirth'],
	 'AccountNumber' => $rows['AccountNumber'],
	 'Gender' => $rows['Gender'],
	 'Role_As' => $rows['Role_As'],
	 'file' => $rows['file'],
	 'AddressType' => $rows['AddressType'],
	 'Parish' => $rows['Parish'],
	 'Region' => $rows['Region'],
	 'AddressLine1' => $rows['AddressLine1'],
	 'AddressLine2' => $rows['AddressLine2'],
	 'userPwd' => $rows['Password_Hash']
	
	
	);

}; 

// Authorized User's information in  this function
function Authorized_User(){  

     global $conn;  
     global $user_id; 
	
    $sql = "SELECT * FROM authorized_users WHERE id = $user_id";  
    $result = mysqli_query($conn,  $sql);
	$rows  =  mysqli_fetch_assoc($result); 
	return array ( 
	
	 'FName' => $rows['FName'],
	 'LName' => $rows['LName'],
	 'IdType' => $rows['IdType'],
	 'IdNumber' => $rows['IdNumber']
	);

}; 

// time format function

function timeAgo($datetime, $full = false) {
	
	    //$tz = new DateTimeZone('America/New_York');
		date_default_timezone_set('Asia/Dhaka'); // or your timezone
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
};












 
?>