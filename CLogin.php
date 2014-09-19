<?php

if (!$_POST['type']) {
    if ($_COOKIE['SESSION_ID']) {

        $query = "SELECT username FROM userInfo WHERE sessionID = \"" . $_COOKIE['SESSION_ID'] . "\"";
        $con = mysql_connect("localhost", "root", "Br%4#!+^PQ#*qRzOxtp%");
        if (!$con) { die("Could not connect to database."); }
        if (!mysql_select_db("ProjectDonationdb", $con)) { die("Could not select database."); }
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            if ($row['username']) {
                die("You are already logged in, <a href='home.php'>click here</a> to return home.");
            } else { }
        }
    }
    mysql_close($con);
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Account login/create</title>
    </head>
    <BODY bgcolor="#FFFFE0">
    <H2><FONT COLOR="BLUE"><div id="type">Account login</div></FONT></H2>
    <HR WIDTH="75%" ALIGN="Left" COLOR="Black">
    <BR>
    <FORM NAME="loginForm" METHOD="POST" ACTION="CLogin.php" onsubmit="return process()">
        <?php if (preg_match("/upload\/index\.php/i", $_SERVER['HTTP_REFERER'])) {
            echo "<input type=hidden name=clickedOnUpload value=true>";
        } ?>
        <input type="hidden" value="login" name="type">
        <TABLE BORDER="0" CELLSPACING="6" CELLPADDING="10">
            <TR>
                <TD><FONT COLOR="#636363">Username:</FONT></TD>
                <TD><INPUT TYPE="TEXT" NAME="username"></TD>
            </TR><TR>
                <TD><FONT COLOR="#636363">Password:</FONT></TD>
                <TD><INPUT TYPE="PASSWORD" NAME="password"></TD>
            </TR><TR>
                <TD><div ID="repeatPassword" STYLE="display:none;"><FONT COLOR="#636363">Repeat PW:</FONT></div></TD>
                <td><div ID="repeatPasswordText" STYLE="display:none;"><INPUT TYPE="PASSWORD" NAME="password2"></div></td>
            </TR><TR>
                <TD COLSPAN=2><CENTER><INPUT TYPE="SUBMIT" VALUE="Submit"></CENTER></TD>
            </TR><TR>
                <td colspan="2"><center><font size="6"></font><B> ( </B></font>
                        <a href="#" id="link" onclick="return toggle();">Create account</a>
                        <font size="6"></font><B> ) </B></font></center>
                </td>
            </TR>
        </TABLE></FORM>
    <BR>


    </body>
    </html>

    <script>

        function toggle() {
            rp = document.getElementById("repeatPassword");
            rp2 = document.getElementById("repeatPasswordText");

            if (rp.style.display == "none") {
                rp.style.display = "block";
                rp2.style.display = "block";
                document.getElementById("link").innerHTML = "Login";
                document.getElementById("type").innerHTML = "Create account";
                document.loginForm.type.value = "create";
            } else {
                rp.style.display = "none";
                rp2.style.display = "none";
                document.getElementById("link").innerHTML = "Create account";
                document.getElementById("type").innerHTML = "Account login";
                document.loginForm.type.value = "login";
            }
        }

        function process() {
            if ((document.loginForm.password.value == document.loginForm.password2.value) || (document.loginForm.type.value == "login")) { return true; }
            else { alert("Passwords don't match."); return false; }
        }

    </script>
<?php
die();
}
if (!$_POST['username'] || !$_POST['password']) {
    die("Invalid values submited, <a href='CLogin.php'>try again</a>.");
}
if (((strpos($_POST['username'], '"') !== false) || (strpos($_POST['username'], '"') !== false) ||
        (strpos($_POST['password'], "'") !== false) || (strpos($_POST['password'], "'") !== false)) &&
        ($_POST['type'] == "create")) {
    die("The password and/or username cannot contain the characters ' or \" <a href='CLogin.php'>try again</a>.");
}

//$pos = strpos($mystring, $findme);


$con = mysql_connect("localhost", "root", "Br%4#!+^PQ#*qRzOxtp%");
if (!$con) {
    die("Could not connect to database.");
}
if (!mysql_select_db("ProjectDonationdb", $con)) {
    die("Could not select database.");
}

if ($_POST['type'] == "create") {
    $query = "SELECT username FROM userInfo WHERE username = \"" . strtolower($_POST['username']) . "\"";
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        if ($row['username'] == $_POST['username']) {
            die("That username is taken, <a href='CLogin.php'>try another</a>.");
        }
    }
    $query = "INSERT INTO userInfo (U_Id, username, password, sessionID) VALUES (U_Id, \"" .
        strtolower($_POST['username']) . "\", \"" . $_POST['password'] . "\", NULL)";

    mysql_query($query, $con);

    echo "Account created <a href='CLogin.php'>click here</a> to login.";
} else {

    $query = "SELECT username, password FROM userInfo WHERE username = \"" . strtolower($_POST['username']) . "\" AND password = \"" . $_POST['password'] . "\"";
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        if ($row['username'] == strtolower($_POST['username']) && $row['password'] == $_POST['password']) {
            setcookie("SESSION_ID", "", time() - 3600);
            $session = uniqid("");
            setcookie("SESSION_ID", $session, time() + 3600);
            $query = "UPDATE userInfo SET sessionID = \"" . $session . "\" WHERE username = \"" . $_POST['username'] . "\" AND password = \"" . $_POST['password'] . "\"";
            mysql_query($query, $con);
            if ($_POST['clickedOnUpload'] == "true") { header("Location: upload/index.php"); }
            else { header("Location: home.php"); }
        } else {
            die("Incorrect username and/or password, <a href='CLogin.php'>try again</a>.");
        }
    }
    die("Incorrect username and/or password, <a href='CLogin.php'>try again</a>.");
}
mysql_close($con);
?>