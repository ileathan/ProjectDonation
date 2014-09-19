<?php

$session = null;

if ($_GET['a'] == "logout") {
    setcookie("SESSION_ID","",time()-3600);
    header("location: home.php");
}
if ($_COOKIE['SESSION_ID']) {

    $query = "SELECT username FROM userInfo WHERE sessionID = \"" . $_COOKIE['SESSION_ID'] . "\"";
    $con = mysql_connect("localhost", "root", "Br%4#!+^PQ#*qRzOxtp%");
    if (!$con) { die("Could not connect to database."); }
    if (!mysql_select_db("ProjectDonationdb", $con)) { die("Could not select database."); }
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        if ($row['username']) {
            $un = $row['username'];

        }
    }
}
mysql_close($con);
?>

<!DOCTYPE html>
<html>

<head>

    <!-- Author of this document is Horacio Spinelli Copyrighted 2014 -->

    <script src="/jquery-1.11.0.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="main.css" />


    <!-- Some quick jquery to configure search field -->
    <script>
        $(document).ready(function() {
        //    $("#searchField").css("color", "grey")
        //    $("#searchField").val("Search Available Donations...");
        //    $("#searchField").focus(function() {
        //        if ($("#searchField").val() == "Search Available Donations...") {
                    $("#searchField").val("");
        //        }
        //    });


            // if text input field value is not empty show the "X" button
            $("#searchField").keyup(function() {
                $("#x").fadeIn();
                if ($.trim($("#searchField").val()) == "") {
                    $("#x").fadeOut();
                }
            });
            // on click of "X", delete input field value and hide "X"
            $("#x").click(function() {
                $("#searchField").val("");
                $(this).hide();
            });

        });

    </script>




    <!-- Ok lets start with the HTML! -->

    <title>Home Page</title>
</head>

<body>


<!-- <span class=annoyingSpaceByLoginLinkFix>&nbsp;</span> if html, body, table height&width are 100% uncomment this -->
<?php
if ($un) {
    echo "<span class=loginLink>
        <b>$un</b>
        <b> ( <a href='home.php?a=logout'>Log out</a> ) </b></span>";
} else {
    echo "<span class=loginLink>
        <b>$un</b>
        <b> ( <a href='CLogin.php'>Log in</a> ) </b></span>";
}
?>

<link rel="stylesheet" type="text/css" href="main.css" />


<!-- This following div is the container for the banner and posible description text -->
<div id="titleContainer" class="titleContainer_C">
    <div id="titleInfo_ID" class="titleInfo_C"><i></i>
        <!-- Depreciated can delete -->
    </div>
    <div id="title_ID" class="title_C">
        <img src="banner.png"><i><font color="#D26B22">itmark</font></i>
    </div>
    <div id="bannerQuote">
       Please consider a donation for those in need.<br>
        A bitmark will be forever yours as a special thank you.
    </div>
</div>


<!-- Is the container for the entire bottom page which is a 3 part table -->
<div  id="mainTable_ID" class="mainTable_C">
    <table>
        <tr>
            <td></td>
            <!-- Part 1 of table (left empty for later use) -->
            <td>

                <!-- Is the container for the entire searching/uploading section -->
                <div class="mainSearch_C">
                    <div id="searchContainer">
                        <form>
                            <!-- <input type="hidden" name="clickedOnUpload" value="true" /> -->
                            <input type="text" id="searchField" name="field" placeholder="Search Available Donations..." />
                            <div id="delete">
                                <span id="x">x</span>
                            </div>
                            <input id="submit" name="submit" type="submit" value="Search" />
                            <!-- </div> -->
                        </form>
                        <!--<form method="post" action="$PROGNAME" enctype="multipart/form-data">-->
                        <input type="hidden" name="verify" value="verify">

                        <div id="upload" class="upload_ID">
                            <input type="image" src="upload.jpg" name="button" onclick=ProcessUpload();>
                        </div>
                        <div id="vid_ID"></div>



                    </div>
                </div>
            </td>
            <td></td>
            <!-- Part 3 of table (left empty for later use) -->
        </tr>
    </table>
</div>

<!-- The following will appear on the top left of the page since all previous attributes ignore
 the HTML DOM placement conventions (excluding the Log in link -->
<!-- This will be the information video the users can watch or ignore
<table class="aboutTable">
    <tr>
        <td width="200">
            <video style="width: 100%; height: 100%;" controls>
                <source src="Zendaya-MyBaby.webm" type="video/webm">
                <object data="Zendaya-MyBaby.mp4" width="500" height="240">
                    <embed src="Zendaya-MyBaby.mp4" width="500" height="240">
                </object>
            </video>
        </td>
    </tr>
    <tr>
        <td><div class=aboutUs></div></td>
    </tr>
</table>
-->
</body>


</html>
