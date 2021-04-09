<?php
include "mysqlClass.inc.php";

function user_pass_check ($username, $password )
{
     global $db;
     $query = "select * from account where username='$username'";
     $result = mysqli_query($db->db_connect_id, $query);
     if  (!$result)
    {
        die("user_pass_check() failed. Could not query the database: <br />" . mysqli_error ($db->db_connect_id));

    }
     else {
         $row = mysqli_fetch_row($result);
         if (strcmp($row[0], $username)){
             return 1;  //wrong password
		 }elseif(strcmp($row[1], $password)){
			 return 2; //username not found
		 }else{
			 return 0; //checks out
		 }
    }   
}

function updateMediaTime($mediaid)
{
	global $db;
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysqli_query($db->db_connect_id, $query);
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysqli_error($db->db_connect_id));
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function add_account_to_db($username, $password, $email)
{
	global $db;
    $exists = user_exists_check($username, $email);
	if($exists == 1){
		//Tell user that that user already exists and exit
		return 1;
	}elseif($exists == 2){
		//Inform user that email address isn't valid
		return 2;
	}else{
		$query = "insert into account (username, password, email, type) values ('$username', '$password', '$email', '1')";
		$result = mysqli_query($db->db_connect_id, $query);
		if(!$result){
			die("add_account_to_db() failed. Could not query the database: <br />".mysqli_error($db->db_connect_id));
		}
		return 0; //Adding new user to db was successful
	}
}

function user_exists_check($username, $email)
{
	global $db;
    $query = "select * from account where username='$username'";
	$result = mysqli_query($db->db_connect_id, $query);
	$exists = mysqli_num_rows($result);
    if  (!$result)
    {
        die("user_exists_check() failed. Could not query the database: <br />" . mysqli_error ($db->db_connect_id));
    }
     else {
         if($exists > 0){
			 return 1; //User exists so can't register acct with $username
		 //Validating email using builtin php function
		 }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return 2; //The email given isn't a valid email
		 }else{
			 return 0; //User doesn't exist so add to db
		 }
    }
}

function update_account($username, $password, $email){
	//UPDATE `account` SET `username`='test',`password`='pass',`email`='test4@test.com',`type`='1' WHERE 'username' = 'test'
	global $db;
	$query = "UPDATE account SET email = '$email', pword = '$password' WHERE username = '$username'";
	if($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)){
		return 1; // Email isn't valid
	}else{
		$result = mysqli_query($db->db_connect_id, $query);
		if(!$result){
			die("update_account() failed. Could not query the database: <br />" . mysqli_error ($db->db_connect_id));
		}else{
			return 0; //Update successful
		}
	}
}
?>