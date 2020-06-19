<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("minio.php");

$apiSecret = "Zeblok5103203128";	//CHANGE this with your secret for accessing this API
$alias = "myminio";		//CHANGE this alias to the name you gave


$headers = apache_request_headers();
$myAuth = $headers["Authorization"];
$mcAdmin = new MinIO($alias);	//instantiate the object
$action = $_GET['action'];	//get the action

if (!isset($myAuth)) {	//Authorization must be set in headers
	header('HTTP/1.0 403 Forbidden');
	echo "Access Denied";
}
else {
	$authKey = md5($apiSecret.$action);	//what we are expecting
	if ($myAuth == $authKey) {


		//route the API request to correct function
		switch ($action) {
			case "addKeys":
				if (isset($_GET['endpoint']) && isset($_GET['accessKey']) && isset($_GET['secret'])) {
					$mcAdmin->addKeys($_GET['endpoint'], $_GET['accessKey'], $_GET['secret']);	//sets info
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "getServerInfo":
				$mcAdmin->getServerInfo();	//gets server information
				break;
			case "restartServer":
				$mcAdmin->restartServer();	//reboots the server
				break;
			case "stopServer":
				$mcAdmin->stopServer();	//stops the server
				break;
			case "addUser":
				if (isset($_GET['accessKey']) && isset($_GET['secret'])) {
					$mcAdmin->addUser($_GET['accessKey'], $_GET['secret']);	//adds a new user
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "removeUser":
				if (isset($_GET['accessKey'])) {
					$mcAdmin->removeUser($_GET['accessKey']);	//removes a user
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "listUsers":
				$mcAdmin->listUsers();	//lists the users
				break;
			case "getUser":
				if (isset($_GET['accessKey'])) {
					$mcAdmin->getUser($_GET['accessKey']);	//get user details
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "setPolicy":
				if (isset($_GET['accessKey']) && isset($_GET['policy'])) {
					$mcAdmin->setPolicy($_GET['accessKey'], $_GET['policy']);	//set user policy
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "listPolicies":
				$mcAdmin->listPolicies();	//lists the policies in this minio
				break;
			case "addPolicy":
				if (isset($_GET['path'])) {
					$mcAdmin->addPolicy($_GET['path']);	//add new policy from file
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			case "removePolicy":
				if (isset($_GET['policy'])) {
					$mcAdmin->removePolicy($_GET['policy']);	//add new policy from file
				}
				else {
					header('HTTP/1.0 403 Bad Request');
					echo "wrong parameters";
				}
				break;
			default:
				header('HTTP/1.0 403 Bad Request');
				echo "wrong parameters";
		}
	
	
	}
	else {
		header('HTTP/1.0 403 Forbidden');
		echo "Access Denied";
	}
}


?>

