# MinIO Admin for PHP

Finally, a PHP wrapper for MinIO Admin!

## About MinIO ##
MinIO is a cloud storage server compatible with Amazon S3, released under Apache License v2. As an object store, MinIO can store unstructured data such as photos, videos, log files, backups and container images. The maximum size of an object is 5 TB. MinIO's High Performance Object Storage is Open Source, Amazon S3 compatible, Kubernetes Friendly and is designed for cloud native workloads like AI.

MinIO provides great official documentation and I really like this wonderful platform. However, there were some demands for a complete REST API integration for MinIO Admin functions that are only accessible via the command line.

## Overview ##
At the time of writing, the only programmatic options for invoking the MinIO admin is by using a [limited REST API document](https://gist.github.com/krishnasrinivas/ea5603d16e6d706793332af674df83e3) that does not include how to CRUD users, and an [official repository written in Go language](https://github.com/minio/minio/tree/master/pkg/madmin). 

The technical team behind MinIO has [indicated in one of their posts](https://github.com/minio/minio/issues/7539#issuecomment-482898917) that they do not intend to expand the Admin API to other languages other than the provided Golang implementation. Therefore, I am here to provide the community with a wrapper that hopefully will be helpful for all the LAMP stack developers out there.

Essentially, this wrapper is for PHP users. You can also run this as a fully fledged REST API if you so desire!

## Installation ##

1. Run `git clone https://github.com/dominicklee/MinIO-Admin-for-PHP.git` into a directory of your choice, but not inside the MinIO directory. You can download this repo and extract the contents. Ideally both the MinIO directory and this wrapper's directory should **be in the same parent directory**. (For example, if you installed MinIO in `/www/html/minio/`, then this wrapper should be `/www/html/admin/`.

2. Make sure your LAMP or WAMP server is effectively running and not in safe-mode. The wrapper will run shell commands as defined by your REST request. Therefore, it makes sense to keep this wrapper in a publicly accessible directory.

3. Change the `apiSecret` variable in `index.php` with your desired value. To authenticate all your API requests, you will need to specify in **Authentication** in the header. The value of the authentication is the MD5 result your `apiSecret` and `action`. Assuming you use SSL (highly recommended), this is slightly more secure than basic authentication.

	In PHP, this is written as: `$authKey = md5($apiSecret.$action); `

	The examples in the Postman collection will show you how the authentication works.

## REST API Usage ##

I have made it easy to start with REST API functionality. Download the included **Postman collection** for examples. The REST API will use the `index.php` as an endpoint. For security, please ensure you use SSL when running this in production.

Before importing the Postman collection, first create an environment in Postman with the following variables: **secret, authorization, endpoint**.

You must fill out the **secret** with the same text you provided in `$apiSecret` inside `index.php`.

You must fill out **endpoint** with the public URL that points to where you uploaded `index.php`.

You can leave **authorization** blank as that will be filled out by Postman later on.

## PHP Usage ##

If you just want to interact with the functions in PHP instead of using the REST API, just put in your PHP code `include("minio.php")` and thats it! You can now instantiate the class and start calling the functions.

### Example ###
```php
<?php 
	include("minio.php");

	$mcAdmin = new MinIO($alias, $endpoint, $accessKey, $secret);

	$mcAdmin->getServerInfo();	//gets server information

	$mcAdmin->addUser("testuser", "secret123456");	//adds a new user

	$mcAdmin->listUsers();	//lists all users
?>
```

## Functions Implemented ##

This project is a work in progress that will be fully functional soon. This list is not exhaustive of all the commands but feel free to request if you need something.

- [Done] addKeys(alias, endpoint, accessKey, secret)
- [Done] getServerInfo()
- [Done] restartServer()
- [Done] stopServer()
- [Done] addUser(accessKey, secret)
- [Done] removeUser(accessKey)
- [Done] listUsers()
- [Done] getUser(accessKey)
- [Done] listPolicies()
- [Done] setPolicy(accessKey, policy)
- [WIP] updateServer()
- [WIP] disableUser(accessKey)
- [WIP] enableUser(accessKey)
- [WIP] addUsersGroup(groupName, accessKeys)
- [WIP] removeUsersGroup(groupName, accessKeys)
- [WIP] removeGroup(groupName)
- [WIP] getGroup(groupName)
- [WIP] listGroups()
- [WIP] disableGroup(groupName)
- [WIP] enableGroup(groupName)
- [WIP] getQuota(bucketName)
- [WIP] setQuota(bucketName)
- [WIP] resetQuota(bucketName)

## Disclaimer ##
All code in this repository is given "AS-IS" with no warranty. The author is not affiliated with MinIO. The author shall not be responsible for any misuse as a result of users running this code. Use at your own risk.