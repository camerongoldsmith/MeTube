<link rel="stylesheet" type="text/css" href="css/default.css"/>
<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])){
    if($_POST['username'] == "" || $_POST['email'] == "" || $_POST['password'] == "" || $_POST['verifyPass'] == ""){
        $register_error = "One or more fields are missing.";
    }elseif($_POST['password'] != $_POST['verifyPass']){
        $register_error = "Create Password and Verify Password do not match.";
    }else{
        $check = add_account_to_db($_POST['username'], $_POST['password'], $_POST['email']);//Call to function in function.php
        if($check == 1){
            $register_error = "That username is already taken.";
        }elseif($check == 2){
            $register_error = "That email address isn't valid.";
        }elseif($check == 0){
            $_SESSION['username']=$_POST['username'];
            header('Location: browse.php');
        }
    }
}

?>

<h3>Register for MeTube:</h3>
<form method="post" action="<?php echo "register.php"; ?>">
    <table width="100%">
        <tr>
            <td width="10%">Username:</td>
            <td width="90%"><input class="text" type="text" name="username"><br /></td>
        </tr>
        <tr>
            <td width="10%">Email:</td>
            <td width="90%"><input class="text" type="text" name="email"><br /></td>
        </tr>
        <tr>
            <td width="10%">Create Password:</td>
            <td width="90%"><input class="text" type="password" name="password"><br /></td>
        </tr>
        <tr>
            <td width="10%">Verify Password:</td>
            <td width="90%"><input class="text" type="password" name="verifyPass"><br /></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="90%"><input name="submit" type="submit" value="Submit"></td>
        </tr>
    </table>
</form>

<?php
    if(isset($register_error)){
        echo "<div id='passwd_result'>".$register_error."</div>";
    }
?>