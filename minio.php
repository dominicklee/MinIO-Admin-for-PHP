<?php
/*	
*	MinIO Admin for PHP
*	Class written by Dominick Lee
*
*	This is a PHP wrapper for fundamental MinIO functions for Admins
*	For details, see https://github.com/dominicklee/MinIO-Admin-for-PHP
*/

class MinIO {

	// object properties
	public $alias;
	public $endpoint;
	public $accessKey;
	public $secret;

	// constructor
	public function __construct($alias) {
		$this->alias = $alias;	//copy to object global
		
	}

	/**
	* Name: Add Keys
	* Desc: Adds the server info to the client records
	* 
	* Inputs: endpoint, accessKey, secret
	* Given: alias
	* Outputs: Result info
	*/

	function addKeys($endpoint, $accessKey, $secret)
	{
		$this->endpoint = $endpoint;	//copy to object global
		$this->accessKey = $accessKey;	//copy to object global
		$this->secret = $secret;	//copy to object global
		$output = shell_exec("../minio/mc config host {$this->alias} {$this->endpoint} {$this->accessKey} {$this->secret} 2>&1"); 
		echo $output;
	} 
	
	/**
	* Name: Get Server Info
	* Desc: Gets the server information
	* 
	* Inputs: 
	* Given: alias
	* Outputs: Server info
	*/

	function getServerInfo()
	{ 
		$output = shell_exec("../minio/mc admin info {$this->alias} --json 2>&1"); 
		echo $output;
	} 

	/**
	* Name: Restart Server
	* Desc: Sends a request to reboot the MinIO server
	* 
	* Inputs: 
	* Given: alias
	* Outputs: Status message
	*/

	function restartServer()
	{ 
		$output = shell_exec("../minio/mc admin service restart {$this->alias} 2>&1"); 
		echo $output;
	} 

	/**
	* Name: Stop Server
	* Desc: Terminates the server from running
	* 
	* Inputs: 
	* Given: alias
	* Outputs: Status message
	*/

	function stopServer()
	{ 
		$output = shell_exec("../minio/mc admin service stop {$this->alias} 2>&1"); 
		echo $output;
	} 

	/**
	* Name: Add User
	* Desc: Adds a user to the system
	* 
	* Inputs: accessKey, secret
	* Given: alias
	* Outputs: Status message
	*/

	function addUser($accessKey, $secret)
	{ 
		$output = shell_exec("../minio/mc admin user add {$this->alias}/ {$accessKey} {$secret} 2>&1"); 
		echo $output;
	} 

	/**
	* Name: Remove User
	* Desc: Removes a user from the system
	* 
	* Inputs: accessKey
	* Given: alias
	* Outputs: Status message
	*/

	function removeUser($accessKey)
	{ 
		$output = shell_exec("../minio/mc admin user remove {$this->alias}/ {$accessKey} 2>&1"); 
		echo $output;
	} 

	/**
	* Name: List Users
	* Desc: Gives a list of users on the system
	* 
	* Inputs: 
	* Given: alias
	* Outputs: JSON array
	*/

	function listUsers()
	{ 
		$output = shell_exec("../minio/mc admin user list {$this->alias} --json 2>&1"); 
		echo $output;
	} 

	/**
	* Name: Get User
	* Desc: Gets details about a user
	* 
	* Inputs: accessKey
	* Given: alias
	* Outputs: JSON array
	*/

	function getUser($accessKey)
	{ 
		$output = shell_exec("../minio/mc admin user info {$this->alias} {$accessKey} 2>&1"); 
		echo $output;
	} 
	
	/**
	* Name: Set Policy
	* Desc: Assigns policy to a user (diagnostics, readonly, readwrite, writeonly)
	* 
	* Inputs: accessKey
	* Given: alias
	* Outputs: JSON array
	*/

	function setPolicy($accessKey, $policy)
	{ 
		$output = shell_exec("../minio/mc admin policy set {$this->alias}/ {$policy} user={$accessKey} 2>&1");
		echo $output;
	} 

	/**
	* Name: List Policies
	* Desc: Gives a list of all the policies that can be set
	* 
	* Inputs: 
	* Given: alias
	* Outputs: JSON array
	*/

	function listPolicies()
	{ 
		$output = shell_exec("../minio/mc admin policy list {$this->alias}/ --json 2>&1");
		echo $output;
	} 

}

?>