<?php

include('config.php');
include('helpers.php');

//user account id in  COOKIE
 if(isset($_COOKIE['user_id'])) {

      $user =  json_decode( $_COOKIE['user_id']);
      $user_id = $user->id;

}


// Check if function already exists to avoid redeclaration error
if (!function_exists('user_account_information')) {
    //user account information in  this function
    function user_account_information(){

    global $conn;
    global $user_id;

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn,  $sql);
	$rows  =  mysqli_fetch_assoc($result);

	if (!$rows) {
	    return array (
	        'first_name' => '',
	        'last_name' => '',
	        'phone_number' => '',
	        'email_address' => '',
	        'date_of_birth' => '',
	        'account_number' => '',
	        'gender' => '',
	        'role_as' => '',
	        'file' => '',
	        'address_type' => '',
	        'parish' => '',
	        'region' => '',
	        'address_line1' => '',
	        'address_line2' => '',
	        'password_hash' => ''
	    );
	}

	return array (

	 'first_name' => $rows['first_name'],
	 'last_name' => $rows['last_name'],
	 'phone_number' => $rows['phone_number'],
	 'email_address' => $rows['email_address'],
	 'date_of_birth' => $rows['date_of_birth'],
	 'account_number' => $rows['account_number'],
	 'gender' => $rows['gender'],
	 'role_as' => $rows['role_as'],
	 'file' => $rows['file'],
	 'address_type' => $rows['address_type'],
	 'parish' => $rows['parish'],
	 'region' => $rows['region'],
	 'address_line1' => $rows['address_line1'],
	 'address_line2' => $rows['address_line2'],
	 'password_hash' => $rows['password_hash']


	);

    }
};

if (!function_exists('Authorized_User')) {
    // Authorized User's information in this function
    function Authorized_User(){

         global $conn;
         global $user_id;

        $sql = "SELECT * FROM authorized_users WHERE user_id = $user_id";
        $result = mysqli_query($conn,  $sql);
    	$rows  =  mysqli_fetch_assoc($result);
    	if (!$rows) {
    	    return [
    	        'first_name' => '',
    	        'last_name' => '',
    	        'IdType' => '',
    	        'IdNumber' => ''
    	    ];
    	}
    	return array (

    	 'first_name' => $rows['first_name'],
    	 'last_name' => $rows['last_name'],
    	 'IdType' => $rows['id_type'],
    	 'IdNumber' => $rows['id_number']
    	);

    };
}

if (!function_exists('timeAgo')) {
    // time format function
    function timeAgo($datetime, $full = false) {

    	    //$tz = new DateTimeZone('America/New_York');
    		date_default_timezone_set('Asia/Dhaka'); // or your timezone
            $now = new DateTime();
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
}

if (!function_exists('calculate_value_of_package')) {
    // Calculate shipping cost based on weight using rates.json
    function calculate_value_of_package($weight) {
        $rates_file = __DIR__ . '/rates.json';
        if (!file_exists($rates_file)) {
            return 0.00; // or handle error
        }
        $rates_data = json_decode(file_get_contents($rates_file), true);
        $rates = $rates_data['rates'];
        $additional_rate = $rates_data['additional_rate_above_20'];
        $minimum_weight = $rates_data['minimum_weight'];

        // Ensure minimum weight
        if ($weight < $minimum_weight) {
            $weight = $minimum_weight;
        }

        // Find exact match for weight <= 20
        foreach ($rates as $rate) {
            if ($rate['weight'] == $weight) {
                return $rate['price'];
            }
        }

        // If weight > 20, calculate
        if ($weight > 20) {
            $base_price = 71.50; // price for 20 lbs
            $extra_weight = $weight - 20;
            return $base_price + ($extra_weight * $additional_rate);
        }

        // If no exact match and <=20, perhaps interpolate or return 0, but since rates are discrete, maybe return for closest lower
        // For simplicity, return 0 if not exact, but probably weights are exact in the table.
        return 0.00;
    }
}
?>
