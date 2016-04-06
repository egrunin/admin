<?php 
$page_title = 'Saving your Registration..';
require('header.php');

//random user id 
$user_id = rand(1000000000,9999999999);

// store the form inputs in variables
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;

// validation
if (empty($email)){
    echo 'Email is required<br />';
    $ok = false;
}

if (empty($password)){
    echo 'Password is required<br />';
    $ok = false;
}

if ($password != $confirm){
    echo 'Passwords must match<br />';
    $ok = false;
}

// save if the form is ok 
if($ok == true){
    require('db.php'); // connection 
    
    $sql = "INSERT INTO admins (user_id, email, password) VALUES (:user_id, :email, :password)";
    
    // check user_id
    $sql_IDverify = "SELECT user_id FROM admins WHERE user_id = $user_id";
    
    // user_id check
    if ($sql_IDverify == $user_id){
      $user_id = rand(1000000000,9999999999);
    }
    
    // hash password 
    $hashed_password = hash('sha512', $password);
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_STR, 10);
    $cmd->bindParam(':email', $email, PDO::PARAM_STR, 100);
    $cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
    $cmd->execute();
    
    $conn = null; // disonnect
    
}
?>

<div class="jumbotron">
<h1> Registration Saved</h1>
<p> You may now login using your administrator credentials <a href="adminlogin.php" title="Login">Here<i class="fa fa-sign-in"></i></a></P>
</div>

<?php require('footer.php'); ?>