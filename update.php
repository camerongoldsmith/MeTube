<link rel="stylesheet" type="text/css" href="css/default.css" />
<?php
session_start();

include_once "function.php";
if(isset($_POST['submit'])){
    if($_POST['email'] == "" && $_POST['password'] == ""){
        $update_error = "Update the field you are wanting to change";
    }else{
        //pull username='$_SESSION['username'] from database
        $query = "select 'email', 'password' from account where 'username'='$_SESSION['username']'";
        if($_POST['email'] == "" && $_POST['password'] != ""){
            $updated = update_account($_SESSION['username'], $_POST['password'], $_SESSION['email']);
        }elseif($_POST['password'] == "" && $_POST['email'] != ""){
            $updated = update_account($_SESSION['username'], $_SESSION['password'], $_POST['email']);
        }elseif($_POST['password'] != "" && $_POST['email'] != ""){
            $updated = update_account($_SESSION['username'], $_POST['password'], $_POST['email']);
        }
    }
    if($updated == 1){
        $update_error = "The entered email is not valid";
    }elseif($updated == 0){
        if($_POST['email'] != ""){
            $_SESSION['email'] == $_POST['email'];
        }
        if($_POST['password' != ""]){
            $_SESSION['password'] == $_POST['email'];
        }
        header('Location: update.php');
    }
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
            <td width="10%"></td>
            <td width="90%"><input name="submit" type="submit" value="Submit"></td>
        </tr>
    </table>
</form>

<?php
    if(isset($update_error)){
        echo "<div id='passwd_result'>".$update_error."</div>";
    }
?>