<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/brief06-Medicale/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once '../config/Database.php';
include_once '../models/User.php';

// instantiate DB & connnect to it

$database = new DataBase();
$db = $database->connect();  // connect function is the one we created on Database line 12

$user = new User($db);
 

// get Posted Data

$data = json_decode(file_get_contents("php://input"));

    $user->firstname = $data->firstname;
    $user->lastname  = $data->lastname;
    $user->email     = $data->email;
    $user->password  = $data->password;

    // create the user
if(
    !empty($user->firstname) &&
    !empty($user->lastname) &&
    !empty($user->email) &&
    !empty($user->password) &&
    $user->createUser()
){
 
    // set response code
    http_response_code(200);
 
    // display message !
    echo json_encode(array("message" => "User was created."));
}
 
    // message if unable to create user
else{
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>

