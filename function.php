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
         if (strcmp($row[1], $password))
             return 2;  //wrong password
         else  
             return 0;  //Checked.
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
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysqli_error());
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
    $exists = user_exists_check($username);
	if($exists == 1){
		//Tell user that that user already exists and exit
	}else{
		
	}
}

function user_exists_check($username)
{
	global $db;
     $query = "select * from account where username='$username'";
     $result = mysqli_query($db->db_connect_id, $query);
	 $exists = mysqli_num_ros($result);
     if  (!$result)
    {
        die("user_pass_check() failed. Could not query the database: <br />" . mysqli_error ($db->db_connect_id));
    }
     else {
         if($exists > 0){
			 return 1; //User exists
		 }else{
			 return 0; //User doesn't exist
		 }
    }
}
?>
