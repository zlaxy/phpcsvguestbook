<?php
/**
 * Administration program file of PHPCSV Guestbook version 0.9
 * See settings.php for configuration.
 * Edit page.php for change appearance.
 */
session_start();
include "settings.php";

function ReadEntries() {
    global $GBdata;
    global $DataStatus;
    $fhandle=fopen($GBdata,"r") or $DataStatus="empty";
    for($e=0; $entrydata=fgetcsv($fhandle, 16384, ","); $e++) {
        $Entries["$e"]=$entrydata;
    } fclose($fhandle);
    if (!$Entries[0]) $DataStatus="empty";
    return $Entries;
}

function SaveEntries() {
    global $GBdata;
    global $AdminEntries;
    $fhandle=fopen($GBdata,"w");
    foreach($AdminEntries as $e=>$Entry) fputcsv($fhandle,$Entry);
    fclose($fhandle);
}

function AdminHeaderView() {
    global $Titles;
    global $GBadmin;
    global $GBpassword;
    echo "<h2><a href=\"index.php\">$Titles[AdminHeader]</a></h2>\n";
    if ($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))) {
        echo "<form action=administration.php method=post>\n";
        echo "  <p align=\"right\"><input type=submit name=\"exit\" value=\"$Titles[AdminExit]\"></p>\n";
        echo "</form>\n";
        echo "  $Titles[AdminHello], $GBadmin!\n";
    }
}

function AdminEntriesView() {
    global $Titles;
    global $DataStatus;
    global $GBadmin;
    global $GBpassword;
    global $AdminEntries;
    if ($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))) if ($DataStatus=="empty") echo "$Titles[EmptyFile]\n";
        else if ($_SESSION["DeleteStatus"]=="deletion") {
            echo "  $Titles[AdminSureDel] ",count($_SESSION["DeleteEntries"])," $Titles[AdminSureDelMessages]?\n";
            echo "<form action=administration.php method=post>\n";
            echo "  <input type=submit name=\"applydelete\" value=\"$Titles[AdminDelete]\">\n";
            echo "  <input type=submit name=\"canceldelete\" value=\"$Titles[AdminCancel]\">\n";
            echo "</form>\n";
        } else if ($_SESSION["EditStatus"]) {
            echo "  $Titles[AdminMessage] ", ($_SESSION["EditStatus"]),", ",date("j.m.Y, H:i",$AdminEntries[($_SESSION["EditStatus"]-1)][5]),":<br>\n";
            echo "<form action=administration.php method=post>\n";
            echo "  $Titles[AdminName]: <input type=text name=\"editname\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][0],"\" maxlength=255><br>\n";
            echo "  $Titles[City] <input type=text name=\"editfrom\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][1],"\" maxlength=255><br>\n";
            echo "  $Titles[Link] <input type=text name=\"editlink\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][2],"\" maxlength=255><br>\n";
            echo "  $Titles[Email] <input type=text name=\"editmail\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][3],"\" maxlength=255><br>\n";
            echo "  $Titles[AdminMessage]:<br>\n  <textarea name=\"edittext\" wrap=virtual cols=50 rows=5  maxlength=7168>",$AdminEntries[($_SESSION["EditStatus"]-1)][4],"</textarea><br>\n";
            echo "  $Titles[Response]:<br>\n  <textarea name=\"editresp\" wrap=virtual cols=50 rows=5  maxlength=7168>",$AdminEntries[($_SESSION["EditStatus"]-1)][6],"</textarea><br>\n";
            echo "  <input type=submit name=\"submiteedit\" value=\"$Titles[AdminApply]\"> ";
            echo "<input type=submit name=\"applydelete\" value=\"$Titles[AdminDelete]\"> ";
            echo "<input type=submit name=\"canceledit\" value=\"$Titles[AdminCancel]\">\n";
            echo "</form>\n";
        } else {
            echo "<form action=administration.php method=post>\n";
            echo "<table border=1  width=\"100%\">\n  <tr><th></th><th>$Titles[AdminName]</th><th>$Titles[City]</th><th>$Titles[Link]</th><th>$Titles[Email]</th><th>$Titles[AdminMessage]</th><th>$Titles[Response]</th><th>$Titles[AdminDate]</th><th></th></tr>\n";
            foreach($AdminEntries as $e=>$Entry) echo "  <tr><td>",($e+1),"<input type=checkbox name=\"cb$e\" value=\"checked\"></td><td>$Entry[0]</td><td>$Entry[1]</td><td>$Entry[2]</td><td>$Entry[3]</td><td>",nl2br($Entry[4]),"</td><td>",nl2br($Entry[6]),"</td><td>",date("j.m.Y, H:i",$Entry[5]),"</td><td><input type=submit name=\"submit$e\" value=\"$Titles[AdminEdit]\"></td></tr>\n";
            echo "</table>\n";
            echo "  <input type=submit name=\"submitdelete\" value=\"$Titles[AdminDeleteChecked]\">\n";
            echo "</form>\n";
        } else {
            if (($_POST["login"])&&(!$_SESSION["SessionStatus"])) echo "$Titles[WrongLogin]<br>\n";
            echo "<form action=administration.php method=post>\n";
            echo "  $Titles[Login] <input type=text name=\"adminlogin\" maxlength=255><br>\n";
            echo "  $Titles[Password] <input type=password name=\"adminpass\" maxlength=255><br>\n";
            echo "  <input type=submit name=\"login\" value=\"$Titles[Enter]\">\n";
            echo "</form>\n";
        }
}

if ((($_POST["adminlogin"])==$GBadmin)&&(($_POST["adminpass"])==$GBpassword)) $_SESSION["SessionStatus"]=(md5($GBadmin.$GBpassword));
if ($_POST["exit"]) $_SESSION["SessionStatus"]="";
if ($_POST["canceldelete"]) {
    $_SESSION["DeleteStatus"]="";
    Unset($_SESSION["DeleteEntries"]);
    }
if ($_POST["canceledit"]) Unset($_SESSION["EditStatus"]);
if ($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))) {
    $AdminEntries=ReadEntries();
    if ($_POST["submitdelete"]) {
        $_SESSION["DeleteStatus"]="deletion";
        foreach($AdminEntries as $e=>$Entry) if ($_POST["cb$e"]) $_SESSION["DeleteEntries"][]=$e;
        if (!count($_SESSION["DeleteEntries"])) $_SESSION["DeleteStatus"]="";
    } if (($_POST["submiteedit"])&&($_SESSION["EditStatus"])) {
        $AdminEntries[($_SESSION["EditStatus"]-1)][0]=$_POST["editname"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][1]=$_POST["editfrom"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][2]=$_POST["editlink"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][3]=$_POST["editmail"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][4]=$_POST["edittext"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][6]=$_POST["editresp"];
        SaveEntries();
        Unset($_SESSION["EditStatus"]);
        $AdminEntries=ReadEntries();
    } if ($_POST["applydelete"]) {
        if ($_SESSION["EditStatus"]) {
            Unset($AdminEntries[($_SESSION["EditStatus"]-1)]);
            SaveEntries();
            Unset($_SESSION["EditStatus"]);
            $AdminEntries=ReadEntries();
        } if ($_SESSION["DeleteStatus"]) {
            foreach($_SESSION["DeleteEntries"] as $e=>$DelEnt) Unset($AdminEntries[$DelEnt]);
            SaveEntries();
            Unset($_SESSION["DeleteEntries"]);
            $_SESSION["DeleteStatus"]="";
            $AdminEntries=ReadEntries();
        }
    } if (!$_SESSION["EditStatus"]) for ($e=0;$e<count($AdminEntries);$e++) if ($_POST["submit$e"]) $_SESSION["EditStatus"]=($e+1);
}
?><html>
<head>
  <title><?php echo $Titles[HeadTitle];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php AdminHeaderView();?>
<hr>
<?php AdminEntriesView();?>
</body>
</html>
