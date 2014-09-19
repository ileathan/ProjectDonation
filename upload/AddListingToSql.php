<?php

$session = null;

if ($_GET['a'] == "logout") {
    setcookie("SESSION_ID","",time()-3600);
    header("Location: ../home.php?a=logout");
}
if (!$_COOKIE['SESSION_ID']) { die("You are not logged in, <a href='../CLogin.php'>click here</a> to login."); }

$query = "SELECT username FROM userInfo WHERE sessionID = \"" . $_COOKIE['SESSION_ID'] . "\"";
$con = mysql_connect("localhost", "root", "Br%4#!+^PQ#*qRzOxtp%");
if (!$con) { die("Could not connect to database."); }
if (!mysql_select_db("ProjectDonationdb", $con)) { die("Could not select database."); }
$result = mysql_query($query, $con);
while ($row = mysql_fetch_array($result)) {
    if ($row['username']) {
    $un = $row['username'];


    ?>










<html>
<head>
    <title>PHP Test</title>
</head>
<body>
<?php echo '<p>Hello World</p>'; ?>
</body>
</html>







    <?php
    } else { die("You are not logged in, <a href='../CLogin.php'>click here</a> to login."); }
}

mysql_close($con);

?>