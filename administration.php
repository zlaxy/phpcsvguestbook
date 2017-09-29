<?php
/**
 * Administration program file of PHPCSV Guestbook
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
        $Entries["$e"][10]=$e+1;
    } fclose($fhandle);
    if (!$Entries[0]) $DataStatus="empty";
    return $Entries;
}

function SaveEntries() {
    global $GBdata;
    global $AdminEntries;
    $fhandle=fopen($GBdata,"w");
    foreach($AdminEntries as $e=>$Entry) {
        unset($Entry[10]);
        fputcsv($fhandle,$Entry);
    }
    fclose($fhandle);
}

function Search($SearchQuery) {
    $Entries=ReadEntries();
    $SearchResultCount=0;
    $SearchResult=false;
    foreach($Entries as $e=>$Entry) {
        for($p=0; $p<9; $p++) {
            if (mb_stristr($Entry[$p],$SearchQuery)) {
                $SearchResult[$SearchResultCount][0]=$e;
                $SearchResult[$SearchResultCount][1]=$Entry;
                $SearchResultCount++;
                break;
            }
        }
    }
    return $SearchResult;
}

function AddSearchBar() {
    global $Titles;
    global $GBsearch;
    if (!(($_SESSION["EditStatus"]) or ($_SESSION["DeleteStatus"]=="deletion"))) if ($GBsearch) {
        echo "<form action=administration.php method=post>";
        echo "<input type=text name=\"serachq\" value=\"\" maxlength=255>";
        echo "<input type=submit name=\"search\" value=\"$Titles[Search]\">";
        echo "</form>";
    }
}

function AdminHeaderView() {
    global $Titles;
    global $GBadmin;
    global $GBpassword;
    echo "<h2><a href=\"index.php\">$Titles[AdminHeader]</a></h2>\n";
    if ($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))) {
        echo "<div style=\"position: absolute; right: 127px; top: 59px;\">",AddSearchBar(),"</div>";
        echo "<form action=administration.php method=post>\n";
        echo "  <p align=\"right\"><input type=submit name=\"exit\" value=\"$Titles[AdminExit]\"></p>\n";
        echo "</form>\n";
        echo "  $Titles[AdminHello], $GBadmin!\n";
    }
}

function SingleEntry($Entry) {
    global $Titles;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    echo "  <tr><td>",($Entry[10]),"<input type=checkbox name=\"cb",($Entry[10]-1),"\" value=\"checked\"></td><td>$Entry[0]</td>";
    if ($GBcityfield) echo "<td>$Entry[1]</td>";
    if ($HBlinkfield) echo "<td>$Entry[2]</td>";
    if ($GBsubjectfield) echo "<td>$Entry[7]</td>";
    if ($GBcategoryfield) echo "<td>$Entry[8]</td>";
    echo "<td>$Entry[3]</td><td>",nl2br($Entry[4]),"</td><td>",nl2br($Entry[6]),"</td><td>",date("j.m.Y, H:i",$Entry[5]),"</td><td><input type=submit name=\"submit",($Entry[10]-1),"\" value=\"$Titles[AdminEdit]\"></td></tr>\n";
}

function AdminEntriesView() {
    global $Titles;
    global $DataStatus;
    global $GBadmin;
    global $GBpassword;
    global $AdminEntries;
    global $GBpagination;
    global $GBtextlenght;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
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
            if ($GBcityfield) echo "  $Titles[City] <input type=text name=\"editfrom\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][1],"\" maxlength=255><br>\n";
            if ($GBlinkfield) echo "  $Titles[Link] <input type=text name=\"editlink\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][2],"\" maxlength=255><br>\n";
            echo "  $Titles[Email] <input type=text name=\"editmail\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][3],"\" maxlength=255><br>\n";
            if ($GBsubjectfield) echo "  $Titles[Subject] <input type=text name=\"editsubj\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][7],"\" maxlength=255><br>\n";
            if ($GBcategoryfield) {
                echo "  $Titles[Category] <select name=\"editcategory\">";
                foreach($GBcategoryfield as $Category) {
                    echo "    <option value=\"$Category\"";
                    if ($AdminEntries[($_SESSION["EditStatus"]-1)][8]==$Category) echo " selected=\"selected\"";
                echo ">$Category</option>";
                }
                echo "</select><br>\n";
            }
            echo "  $Titles[AdminMessage]:<br>\n  <textarea name=\"edittext\" wrap=virtual cols=50 rows=5  maxlength=$GBtextlenght>",$AdminEntries[($_SESSION["EditStatus"]-1)][4],"</textarea><br>\n";
            echo "  $Titles[Response]:<br>\n  <textarea name=\"editresp\" wrap=virtual cols=50 rows=5  maxlength=$GBtextlenght>",$AdminEntries[($_SESSION["EditStatus"]-1)][6],"</textarea><br>\n";
            echo "  <input type=submit name=\"submiteedit\" value=\"$Titles[AdminApply]\"> ";
            echo "<input type=submit name=\"applydelete\" value=\"$Titles[AdminDelete]\"> ";
            echo "<input type=submit name=\"canceledit\" value=\"$Titles[AdminCancel]\">\n";
            echo "</form>\n";
        } else {
            if($_POST['search']&&$_POST['serachq']) {
                $SearchResult=Search($_POST['serachq']);
                if ($SearchResult) {
                    $GBpagination=0;
                    unset($AdminEntries);
                    foreach($SearchResult as $n=>$Entry) $AdminEntries[$n]=$Entry[1];
                } else echo "$Titles[NoResult]: '",$_POST['serachq'],"'.<br>\n";
            }
            if (($GBpagination>0)&&(count($AdminEntries)>$GBpagination)) {
                $Entries=array_reverse($AdminEntries);
                if ($_GET['page']) switch ($_GET['page']) {
                    case $Titles[First]:
                        $CurrentPage=0;
                        break;
                    case $Titles[Last]:
                        $CurrentPage=intdiv(count($Entries),$GBpagination);
                        break;
                    case "$Titles[Previous]":
                        $CurrentPage=$_SESSION['currentpage']-1;
                        break;
                    case "$Titles[Next]":
                        $CurrentPage=$_SESSION['currentpage']+1;
                        break;
                    default:
                        $CurrentPage=$_GET['page']-1;
                } else $CurrentPage=0;
                echo "<form action=administration.php method=\"get\">\n";
                if ($CurrentPage>0) {
                    echo "    <input type=\"submit\" value=\"$Titles[First]\" name=\"page\"/>\n";
                    echo "    <input type=\"submit\" value=\"$Titles[Previous]\" name=\"page\"/>\n";
                }
                for ($p = ($CurrentPage-2); $p <= ($CurrentPage+2); $p++) {
                    $page = $p+1;
                    if (($p>=0)&&($p<(count($Entries)/$GBpagination))) {
                        echo "    <input type=\"submit\" value=\"$page\" name=\"page\"";
                        if ($p==$CurrentPage) echo " disabled";
                        echo "/>\n";
                    }
                }
                if ($CurrentPage<((count($Entries)/$GBpagination)-1)) {
                    echo "    <input type=\"submit\" value=\"$Titles[Next]\" name=\"page\"/>\n";
                    echo "    <input type=\"submit\" value=\"$Titles[Last]\" name=\"page\"/>\n";
                }
                echo "</form>\n";
                echo "<form action=administration.php method=post>\n";
                echo "<table border=1  width=\"100%\">\n  <tr><th></th><th>$Titles[AdminName]</th>";
                if ($GBcityfield) echo "<th>$Titles[City]</th>";
                if ($HBlinkfield) echo "<th>$Titles[Link]</th>";
                if ($GBsubjectfield) echo "<th>$Titles[Subject]</th>";
                if ($GBcategoryfield) echo "<th>$Titles[Category]</th>";
                echo "<th>$Titles[Email]</th><th>$Titles[AdminMessage]</th><th>$Titles[Response]</th><th>$Titles[AdminDate]</th><th></th></tr>\n";
                for ($e = ($GBpagination*$CurrentPage); $e < ($GBpagination*($CurrentPage+1)); $e++) {
                    if ($e>=count($Entries)) break;
                    $Entry = $Entries[$e];
                    SingleEntry($Entry);
                }
                $_SESSION['currentpage']=$CurrentPage;
            } else {
                echo "<form action=administration.php method=post>\n";
                echo "<table border=1  width=\"100%\">\n  <tr><th></th><th>$Titles[AdminName]</th>";
                if ($GBcityfield) echo "<th>$Titles[City]</th>";
                if ($HBlinkfield) echo "<th>$Titles[Link]</th>";
                if ($GBsubjectfield) echo "<th>$Titles[Subject]</th>";
                if ($GBcategoryfield) echo "<th>$Titles[Category]</th>";
                echo "<th>$Titles[Email]</th><th>$Titles[AdminMessage]</th><th>$Titles[Response]</th><th>$Titles[AdminDate]</th><th></th></tr>\n";
                $Entries=array_reverse($AdminEntries);
                foreach($Entries as $e=>$Entry) SingleEntry($Entry);
            }
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
        $AdminEntries[($_SESSION["EditStatus"]-1)][7]=$_POST["editsubj"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][8]=$_POST["editcategory"];
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
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:regular&amp;subset=Latin,Cyrillic">
  <link rel="stylesheet" type="text/css" href="anthrstlsht.css">
</head>
<body>
<div class="container">
<?php AdminHeaderView();?>
<hr>
<?php AdminEntriesView();?>
</div>
</body>
</html>
