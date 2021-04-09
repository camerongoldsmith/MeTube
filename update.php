<link rel="stylesheet" type="text/css" href="css/default.css" />
<?php
session_start();

include_once "function.php";
if(isset($_POST['submit'])){
    if($_POST['email'] == "" && $_POST['password'] == ""){
        $update_error = "Update the field you are wanting to change";
    }else{
        //pull username='$_SESSION['username'] from database
        $currUser = $_SESSION['username'];
        $query = "select * from account where username='$currUser'";
        $result = mysqli_query($db->db_connect_id, $query);
        if  (!$result)
        {
            die("updating user profile failed. Could not query the database: <br />" . mysqli_error ($db->db_connect_id));
        }
         else {
             $row = mysqli_fetch_row($result);
             $currPass = $row[1];
             $currEmail = $row[2];
        }

        if($_POST['email'] == "" && $_POST['password'] != ""){
            $updated = update_account($_SESSION['username'], $_POST['password'], $currEmail);
        }elseif($_POST['password'] == "" && $_POST['email'] != ""){
            $updated = update_account($_SESSION['username'], $currPass, $_POST['email']);
        }elseif($_POST['password'] != "" && $_POST['email'] != ""){
            $updated = update_account($_SESSION['username'], $_POST['password'], $_POST['email']);
        }
    }
    if($updated == 1){
        $update_error = "The entered email is not valid";
    }elseif($updated == 0){
        //Update was successful return to browse page
        //Possibly add some code to inform user that the update was successful
        header('Location: browse.php');
    }
}

if(isset($_POST['back'])){
    header('Location: browse.php');
}

?>
<h3>Update profile for MeTube:</h3>
<form method="post" action="<?php echo "update.php"; ?>">
    <table width="100%">
        <tr>
            <td width="10%">Change Email:</td>
            <td width="90%"><input class="text" type="text" name="email"><br /></td>
        </tr>
        <tr>
            <td width="10%">Change Password:</td>
            <td width="90%"><input class="text" type="password" name="password"><br /></td>
        </tr>
        <tr>
            <td width="10%"><input name="back" type="submit" value="Back to browse"></td>
            <td width="60%"><input name="submit" type="submit" value="Submit"></td>
        </tr>
    </table>
</form>

<?php
    if(isset($update_error)){
        echo "<div id='passwd_result'>".$update_error."</div>";
    }
?>