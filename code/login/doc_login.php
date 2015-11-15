<?php
include_once 'functions.php';
include_once '../dbconfig/link.php';
 
sec_session_start();
 
if (doctor_login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <script type="text/JavaScript" src="sha1.js"></script>
        <script type="text/JavaScript" src="forms.js"></script>
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
        <form action="doc_login_process.php" method="post" name="login_form" id="login_form">
            Doctor ID: <input type="text" name="doctor_id" id='doctor_id' />
            Password: <input type="password" name="password" id="password"/>
            <input type="submit" value="Submit" id="submit" /> 
        </form>
 
<?php
        if (login_check($mysqli) == true) {
            echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
            echo '<p>Do you want to change user? <a href="includes/logout.php">Log out</a>.</p>';
        } else {
                        echo '<p>Currently logged ' . $logged . '.</p>';
                        echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
                }
?>      
    </body>
</html>