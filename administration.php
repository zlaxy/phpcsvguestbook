<?php
/**
 * Administration program file of PHPCSV Guestbook
 * See settings.php for configuration.
 * Edit page.php for change appearance.
 */
session_start();
include "settings.php";

switch($GBlanguage) {
    case "ar": include "settings_ar.php";
    case "ru": include "settings_ru.php";
      default: include "settings_en.php";
}

function ReadEntries() {
    global $GBdata;
    global $DataStatus;
    $fhandle=fopen($GBdata,"r") or $DataStatus="empty";
    for($e=0; $entrydata=fgetcsv($fhandle, 16384, ","); $e++) {
        $Entries["$e"]=$entrydata;
        $Entries["$e"][10]=$e+1;
    } fclose($fhandle);
    if (!isset($Entries[0])) $DataStatus="empty";
        else return $Entries;
}

function SaveEntries() {
    global $GBdata;
    global $AdminEntries;
    $fhandle=fopen($GBdata,"w");
    foreach($AdminEntries as $e=>$Entry) {
        $Entry[10]="";
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
    global $GBcategoryfield;
    if ($GBsearch) if (!(isset($_SESSION["EditStatus"]) or (isset($_SESSION["DeleteStatus"])?($_SESSION["DeleteStatus"]=="deletion"):(false)))) {
        echo "<form action=administration.php method=post>";
        if ($GBcategoryfield) {
            echo "<input type=text name=\"serachq\" value=\"\" maxlength=255 list=\"browsers\">";
            echo "<datalist id=\"browsers\">";
            foreach ($GBcategoryfield as $category) echo "  <option value=\"",$category,"\">";
            echo "</datalist>";
        } else echo "<input type=text name=\"serachq\" value=\"\" maxlength=255>";
        echo "<input type=submit name=\"search\" value=\"",$Titles["Search"],"\">";
        echo "</form>";
    }
}

function AdminHeaderView() {
    global $Titles;
    global $GBadmin;
    global $GBpassword;
    echo "<h2><a href=\"index.php\">",$Titles["AdminHeader"],"</a></h2>\n";
    if (isset($_SESSION["SessionStatus"])?($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))):false) {
        echo "<div style=\"position: absolute; right: 127px; top: 59px;\">",AddSearchBar(),"</div>";
        echo "<form action=administration.php method=post>\n";
        echo "  <p align=\"right\"><input type=submit name=\"exit\" value=\"",$Titles["AdminExit"],"\"></p>\n";
        echo "</form>\n";
        echo "  ",$Titles["AdminHello"],", $GBadmin!\n";
    }
}

function SingleEntry($Entry) {
    global $Titles;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    global $GBemailfield;
    echo "  <tr><td>",($Entry[10]),"<input type=checkbox name=\"cb",($Entry[10]-1),"\" value=\"checked\"></td><td>$Entry[0]</td>";
    if ($GBcityfield) echo "<td>$Entry[1]</td>";
    if ($GBlinkfield) echo "<td>$Entry[2]</td>";
    if ($GBsubjectfield) echo "<td>$Entry[7]</td>";
    if ($GBcategoryfield) echo "<td>$Entry[8]</td>";
    if ($GBemailfield) echo "<td>$Entry[3]</td>";
    echo "<td>",nl2br($Entry[4]),"</td><td>",nl2br($Entry[6]),"</td><td>",date("j.m.Y, H:i",$Entry[5]),"</td><td><input type=submit name=\"submit",($Entry[10]-1),"\" value=\"",$Titles["AdminEdit"],"\"></td></tr>\n";
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
    global $GBstickylocked;
    global $GBfield1;
    global $GBfield2;
    global $GBfield3;
    global $GBemailfield;
    if (isset($_SESSION["SessionStatus"])?($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))):false) if ($DataStatus=="empty") echo $Titles["EmptyFile"],"\n";
        else if (isset($_SESSION["DeleteStatus"])) {
            if ($_SESSION["DeleteStatus"]=="deletion") {
                echo "  ",$Titles["AdminSureDel"]," ",count($_SESSION["DeleteEntries"])," ",$Titles["AdminSureDelMessages"],"?\n";
                echo "<form action=administration.php method=post>\n";
                echo "  <input type=submit name=\"applydelete\" value=\"",$Titles["AdminDelete"],"\">\n";
                echo "  <input type=submit name=\"canceldelete\" value=\"",$Titles["AdminCancel"],"\">\n";
                echo "</form>\n";
            }
        } else if (isset($_SESSION["EditStatus"])) {
            echo "  ",$Titles["AdminMessage"]," ", ($_SESSION["EditStatus"]),", ",date("j.m.Y, H:i",$AdminEntries[($_SESSION["EditStatus"]-1)][5]),":<br>\n";
            echo "<form action=administration.php method=post>\n";
            echo "  ",$Titles["AdminName"],": <input type=text name=\"editname\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][0],"\" maxlength=255><br>\n";
            if ($GBcityfield) echo "  ",$Titles["City"]," <input type=text name=\"editfrom\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][1],"\" maxlength=255><br>\n";
            if ($GBlinkfield) echo "  ",$Titles["Link"]," <input type=text name=\"editlink\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][2],"\" maxlength=255><br>\n";
            if ($GBemailfield) echo "  ",$Titles["Email"]," <input type=text name=\"editmail\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][3],"\" maxlength=255><br>\n";
            if ($GBsubjectfield) echo "  ",$Titles["Subject"]," <input type=text name=\"editsubj\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][7],"\" maxlength=255><br>\n";
            if ($GBcategoryfield) {
                echo "  ",$Titles["Category"]," <select name=\"editcategory\">";
                foreach($GBcategoryfield as $Category) {
                    echo "    <option value=\"$Category\"";
                    if ($AdminEntries[($_SESSION["EditStatus"]-1)][8]==$Category) echo " selected=\"selected\"";
                echo ">$Category</option>";
                }
                echo "</select><br>\n";
            }
            if ($GBfield1) echo "  ",$Titles["Field1"],": <input type=text name=\"field1\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][13],"\" maxlength=255><br>\n";
            if ($GBfield2) echo "  ",$Titles["Field2"],": <input type=text name=\"field2\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][14],"\" maxlength=255><br>\n";
            if ($GBfield3) echo "  ",$Titles["Field3"],": <input type=text name=\"field3\" value=\"",$AdminEntries[($_SESSION["EditStatus"]-1)][15],"\" maxlength=255><br>\n";
            echo "  ",$Titles["AdminMessage"],":<br>\n  <textarea name=\"edittext\" wrap=virtual cols=50 rows=5  maxlength=$GBtextlenght>",$AdminEntries[($_SESSION["EditStatus"]-1)][4],"</textarea><br>\n";
            echo "  ",$Titles["Response"],":<br>\n  <textarea name=\"editresp\" wrap=virtual cols=50 rows=5  maxlength=$GBtextlenght>",$AdminEntries[($_SESSION["EditStatus"]-1)][6],"</textarea><br>\n";
            if ($GBstickylocked) {
                echo "  <input type=\"checkbox\" name=\"lock\" ";
                if ($AdminEntries[($_SESSION["EditStatus"]-1)][11]) echo "checked";
                echo "> ",$Titles["Locked"],"  <input type=\"checkbox\" name=\"sticky\" ";
                if ($AdminEntries[($_SESSION["EditStatus"]-1)][12]) echo "checked";
                echo "> ",$Titles["Sticky"],"<br>\n";
            }
            echo "  <input type=submit name=\"submiteedit\" value=\"",$Titles["AdminApply"],"\"> ";
            echo "<input type=submit name=\"applydelete\" value=\"",$Titles["AdminDelete"],"\"> ";
            echo "<input type=submit name=\"canceledit\" value=\"",$Titles["AdminCancel"],"\">\n";
            echo "</form>\n";
        } else {
            if(isset($_POST["search"])&&$_POST["serachq"]) {
                $SearchResult=Search($_POST["serachq"]);
                if ($SearchResult) {
                    $GBpagination=0;
                    Unset($AdminEntries);
                    foreach($SearchResult as $n=>$Entry) $AdminEntries[$n]=$Entry[1];
                } else echo $Titles["NoResult"],": '",$_POST["serachq"],"'.<br>\n";
            }
            if (($GBpagination>0)&&(count($AdminEntries)>$GBpagination)) {
                $Entries=array_reverse($AdminEntries);
                if (isset($_GET["page"])) switch ($_GET["page"]) {
                    case $Titles["First"]:
                        $CurrentPage=0;
                        break;
                    case $Titles["Last"]:
                        $CurrentPage=intdiv(count($Entries),$GBpagination);
                        break;
                    case $Titles["Previous"]:
                        $CurrentPage=$_SESSION["currentpage"]-1;
                        break;
                    case $Titles["Next"]:
                        $CurrentPage=$_SESSION["currentpage"]+1;
                        break;
                    default:
                        $CurrentPage=$_GET["page"]-1;
                } else $CurrentPage=0;
                echo "<form action=administration.php method=\"get\">\n";
                if ($CurrentPage>0) {
                    echo "    <input type=\"submit\" value=\"",$Titles["First"],"\" name=\"page\"/>\n";
                    echo "    <input type=\"submit\" value=\"",$Titles["Previous"],"\" name=\"page\"/>\n";
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
                    echo "    <input type=\"submit\" value=\"",$Titles["Next"],"\" name=\"page\"/>\n";
                    echo "    <input type=\"submit\" value=\"",$Titles["Last"],"\" name=\"page\"/>\n";
                }
                echo "</form>\n";
                echo "<form action=administration.php method=post>\n";
                echo "<table border=1  width=\"100%\">\n  <tr><th></th><th>",$Titles["AdminName"],"</th>";
                if ($GBcityfield) echo "<th>",$Titles["City"],"</th>";
                if ($GBlinkfield) echo "<th>",$Titles["Link"],"</th>";
                if ($GBsubjectfield) echo "<th>",$Titles["Subject"],"</th>";
                if ($GBcategoryfield) echo "<th>",$Titles["Category"],"</th>";
                if ($GBemailfield) echo "<th>",$Titles["Email"],"</th>";
                echo "<th>",$Titles["AdminMessage"],"</th><th>",$Titles["Response"],"</th><th>",$Titles["AdminDate"],"</th><th></th></tr>\n";
                for ($e = ($GBpagination*$CurrentPage); $e < ($GBpagination*($CurrentPage+1)); $e++) {
                    if ($e>=count($Entries)) break;
                    $Entry = $Entries[$e];
                    SingleEntry($Entry);
                }
                $_SESSION["currentpage"]=$CurrentPage;
            } else {
                echo "<form action=administration.php method=post>\n";
                echo "<table border=1  width=\"100%\">\n  <tr><th></th><th>",$Titles["AdminName"],"</th>";
                if ($GBcityfield) echo "<th>",$Titles["City"],"</th>";
                if ($GBlinkfield) echo "<th>",$Titles["Link"],"</th>";
                if ($GBsubjectfield) echo "<th>",$Titles["Subject"],"</th>";
                if ($GBcategoryfield) echo "<th>",$Titles["Category"],"</th>";
                if ($GBemailfield) echo "<th>",$Titles["Email"],"</th>";
                echo "<th>",$Titles["AdminMessage"],"</th><th>",$Titles["Response"],"</th><th>",$Titles["AdminDate"],"</th><th></th></tr>\n";
                $Entries=array_reverse($AdminEntries);
                foreach($Entries as $e=>$Entry) SingleEntry($Entry);
            }
            echo "</table>\n";
            echo "  <input type=submit name=\"submitdelete\" value=\"",$Titles["AdminDeleteChecked"],"\">\n";
            echo "</form>\n";
        } else {
            if (isset($_POST["login"])&&(!$_SESSION["SessionStatus"])) echo $Titles["WrongLogin"],"<br>\n";
            echo "<form action=administration.php method=post>\n";
            echo "  ",$Titles["Login"]," <input type=text name=\"adminlogin\" maxlength=255><br>\n";
            echo "  ",$Titles["Password"]," <input type=password name=\"adminpass\" maxlength=255><br>\n";
            echo "  <input type=submit name=\"login\" value=\"",$Titles["Enter"],"\">\n";
            echo "</form>\n";
        }
}

if (isset($_POST["adminlogin"]))
    if ((($_POST["adminlogin"])==$GBadmin)&&(($_POST["adminpass"])==$GBpassword)) $_SESSION["SessionStatus"]=(md5($GBadmin.$GBpassword));
if (isset($_POST["exit"])) $_SESSION["SessionStatus"]="";
if (isset($_POST["canceldelete"])) {
    $_SESSION["DeleteStatus"]="";
    Unset($_SESSION["DeleteEntries"]);
    }
if (isset($_POST["canceledit"])) Unset($_SESSION["EditStatus"]);
if (isset($_SESSION["SessionStatus"])?($_SESSION["SessionStatus"]==(md5($GBadmin.$GBpassword))):false) {
    $AdminEntries=ReadEntries();
    if (isset($_POST["submitdelete"])) {
        $_SESSION["DeleteStatus"]="deletion";
        foreach($AdminEntries as $e=>$Entry) if (isset($_POST["cb$e"])) $_SESSION["DeleteEntries"][]=$e;
        if (isset($_SESSION["DeleteEntries"])) if (!count($_SESSION["DeleteEntries"])) $_SESSION["DeleteStatus"]="";
    } if (isset($_POST["submiteedit"])) if (($_POST["submiteedit"])&&(isset($_SESSION["EditStatus"]))) {
        $AdminEntries[($_SESSION["EditStatus"]-1)][0]=$_POST["editname"];
        if (isset($_POST["editfrom"])) $AdminEntries[($_SESSION["EditStatus"]-1)][1]=$_POST["editfrom"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][1]="";
        if (isset($_POST["editlink"])) $AdminEntries[($_SESSION["EditStatus"]-1)][2]=$_POST["editlink"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][2]="";
        $AdminEntries[($_SESSION["EditStatus"]-1)][3]=$_POST["editmail"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][4]=$_POST["edittext"];
        $AdminEntries[($_SESSION["EditStatus"]-1)][6]=$_POST["editresp"];
        if (isset($_POST["editsubj"])) $AdminEntries[($_SESSION["EditStatus"]-1)][7]=$_POST["editsubj"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][7]="";
        if (isset($_POST["editcategory"])) $AdminEntries[($_SESSION["EditStatus"]-1)][8]=$_POST["editcategory"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][8]="";
        if (isset($_POST["field1"])) $AdminEntries[($_SESSION["EditStatus"]-1)][13]=$_POST["field1"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][13]="";
        if (isset($_POST["field2"])) $AdminEntries[($_SESSION["EditStatus"]-1)][14]=$_POST["field2"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][14]="";
        if (isset($_POST["field3"])) $AdminEntries[($_SESSION["EditStatus"]-1)][15]=$_POST["field3"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][15]="";
        if (isset($_POST["lock"])) $AdminEntries[($_SESSION["EditStatus"]-1)][11]=$_POST["lock"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][11]="";
        if (isset($_POST["sticky"])) $AdminEntries[($_SESSION["EditStatus"]-1)][12]=$_POST["sticky"];
            else $AdminEntries[($_SESSION["EditStatus"]-1)][12]="";
        SaveEntries();
        Unset($_SESSION["EditStatus"]);
        $AdminEntries=ReadEntries();
    } if (isset($_POST["applydelete"])) if ($_POST["applydelete"]) {
        if (isset($_SESSION["EditStatus"])) {
            Unset($AdminEntries[($_SESSION["EditStatus"]-1)]);
            SaveEntries();
            Unset($_SESSION["EditStatus"]);
            $AdminEntries=ReadEntries();
        } if (isset($_SESSION["DeleteStatus"])?($_SESSION["DeleteStatus"]):(false)) {
            foreach($_SESSION["DeleteEntries"] as $e=>$DelEnt) Unset($AdminEntries[$DelEnt]);
            SaveEntries();
            Unset($_SESSION["DeleteEntries"]);
            
            Unset($_SESSION["DeleteStatus"]);
            //$_SESSION["DeleteStatus"]="";
            $AdminEntries=ReadEntries();
        }
    } if (!isset($_SESSION["EditStatus"])) for ($e=0;$e<count($AdminEntries);$e++) if (isset($_POST["submit$e"])) $_SESSION["EditStatus"]=($e+1);
}
?><html>
<head>
  <title><?php echo $Titles["HeadTitle"];?></title>
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
