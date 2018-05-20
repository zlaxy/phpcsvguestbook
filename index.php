<?php
/**
 * Main program file of PHPCSV Guestbook
 * See settings.php for configuration.
 * Edit page.php for change appearance.
 * See LICENSE for licensing information.
 */
session_start();
include "settings.php";

switch($GBlanguage) {
    case "ar": include "settings_ar.php";
    case "ru": include "settings_ru.php";
      default: include "settings_en.php";
}

function SendMail() {
    global $Titles;
    global $GBnotificationmailto;
    global $GBnotificationmailfrom;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    $message=$_POST["name"];
    if ($GBcityfield) $message=$message." ".$Titles["From"]." ".$_POST["from"];
    $message=$message."(";
    if ($GBlinkfield) $message=$message.$_POST["link"].", ";
    $message=$message.$_POST["email"].") ".$Titles["Wrote"];
    if ($GBsubjectfield) $message=$message." ".$_POST["subj"];
    if ($GBcategoryfield) $message=$message." [".$_POST["category"]."]";
    $message=$message.":\r\n\r\n".$_POST["text"]."\r\n\r\n_____\r\n".$Titles["MailAdmin"];
    foreach ($GBnotificationmailto as $email) {
        mail($email, $Titles["MailSubject"], $message,
        "From: ".$GBnotificationmailfrom." \r\n"."Content-type: text/plain; charset=utf-8\r\n"
        ."X-Mailer: PHP/".phpversion());
    }
}

function ReadEntries() {
    global $GBdata;
    global $DataStatus;
    $fhandle=fopen($GBdata,"r") or $DataStatus="empty";
    for($e=0; $entrydata=fgetcsv($fhandle, 16384, ","); $e++) {
        $Entries["$e"]=$entrydata;
        $Entries["$e"][10]=$e+1;
    }
    fclose($fhandle);
    if (!isset($Entries[0])) $DataStatus="empty";
        else return $Entries;
}

function SaveFile() {
    $postuploaddir = substr(md5(uniqid()), 0, 13);
    $preuploaddir = "upload/";
    $filename = $_FILES["uploadedfile"]["name"];
    $uploadfile = $preuploaddir.$postuploaddir."/".$filename;
    mkdir($preuploaddir.$postuploaddir, 0755, true);
    if (move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $uploadfile)) {
        return $uploadfile;
    } else {
        return false;
    }
}

function CheckFile() {
    global $Titles;
    global $GBfilesize;
    global $GBupload;
    if ($GBfilesize>$_FILES["uploadedfile"]["size"] && $_FILES["uploadedfile"]["size"]>0) {
        if (in_array("images",$GBupload)) if (getimagesize($_FILES["uploadedfile"]["tmp_name"]))
            return " <br><img src=\"".SaveFile()."\">";
        if ($GBupload===true)
            return " <br><a href=\"".SaveFile()."\">"."<strong>📎</strong> ".$Titles["AttachedFile"]."</a>";
        if (in_array(mb_strtolower(pathinfo($_FILES["uploadedfile"]["name"], PATHINFO_EXTENSION)),$GBupload))
            return " <br><a href=\"".SaveFile()."\">"."<strong>📎</strong> ".$Titles["AttachedFile"]."</a>";
    } else return false;
    return false;
}

function AddHttp($Link) {
    if (!$Link=="") if (!preg_match("~^(?:f|ht)tps?://~i",$Link)) {
        $Link = "http://".$Link;
    }
    return $Link;
}

function AddEntry() {
    global $GBdata;
    global $Titles;
    global $PageStatus;
    global $UploadedFile;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    global $GBstriptags;
    global $GBfield1;
    global $GBfield2;
    global $GBfield3;
    if (!$GBstriptags) $NewEntry["name"]=$_POST["name"];
        else $NewEntry["name"]=strip_tags($_POST["name"]);
    if ($GBcityfield) {
        if (!$GBstriptags) $NewEntry["from"]=$_POST["from"];
            else $NewEntry["from"]=strip_tags($_POST["from"]);
        } else $NewEntry["from"]="";
    if ($GBlinkfield) {
        if (!$GBstriptags) $NewEntry["link"]=AddHttp($_POST["link"]);
            else $NewEntry["link"]=AddHttp(strip_tags($_POST["link"]));
        } else $NewEntry["link"]="";
    $NewEntry["email"]=$_POST["email"];
    if (!$GBstriptags) $NewEntry["text"]=$_POST["text"];
        else $NewEntry["text"]=strip_tags($_POST["text"]);
    if ($UploadedFile) $NewEntry["text"]=$NewEntry["text"].$UploadedFile;
    $NewEntry["datetime"]=time();
    $NewEntry["response"]="";
    if ($GBsubjectfield) {
        if (!$GBstriptags) $NewEntry["subj"]=$_POST["subj"];
            else $NewEntry["subj"]=strip_tags($_POST["subj"]);
        } else $NewEntry["subj"]="";
    if ($GBcategoryfield) $NewEntry["category"]=strip_tags($_POST["category"]);
        else $NewEntry["category"]="";
    if (isset($_SESSION["reply"])) {
        $NewEntry["reply"]=$_SESSION["reply"][5];
        unset($_SESSION["reply"]);
    } else $NewEntry["reply"]="";
    $NewEntry["number"]="";
    $NewEntry["lock"]="";
    $NewEntry["sticky"]="";
    if ($GBfield1) {
        if (!$GBstriptags) $NewEntry["field1"]=$_POST["field1"];
            else $NewEntry["field1"]=strip_tags($_POST["field1"]);
        } else $NewEntry["field1"]="";
    if ($GBfield2) {
        if (!$GBstriptags) $NewEntry["field2"]=$_POST["field2"];
            else $NewEntry["field2"]=strip_tags($_POST["field2"]);
        } else $NewEntry["field2"]="";
    if ($GBfield3) {
        if (!$GBstriptags) $NewEntry["field3"]=$_POST["field3"];
            else $NewEntry["field3"]=strip_tags($_POST["field3"]);
        } else $NewEntry["field3"]="";
    $fhandle=fopen($GBdata,"a");
    fputcsv($fhandle,$NewEntry);
    fclose($fhandle);
    $PageStatus="added";
    $_SESSION["captcha"]="";
}

function AddEntryView() {
    global $Titles;
    global $Values;
    global $PageStatus;
    global $GBcaptcha;
    global $GBtextlenght;
    global $GBupload;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    global $GBfilesize;
    global $GBfield1;
    global $GBfield2;
    global $GBfield3;
    global $GBemailfield;
    global $singleEntry;
    if ($singleEntry) {
        echo "<a href=\".\"><h2>",$Titles["Page"],"</h2></a><br>\n";
        return;
    }
    echo "<h2>",$Titles["Page"],"</h2><br>\n";
    if ($PageStatus=="added") echo $Titles["Added"]."<br>\n";
    $captchanumber11=rand(1, 4);
    $captchanumber12=rand(0, 9);
    $captchanumber21=rand(1, 4);
    $captchanumber22=rand(0, 9);
    $_SESSION["captcha"]=md5(base64_encode(($captchanumber11.$captchanumber12)+($captchanumber21.$captchanumber22)));
    echo "<form action=index.php method=post enctype=\"multipart/form-data\">\n";
    echo "  ",$Titles["Name"],": <input type=text name=\"name\" value=\"",$Values["name"],"\" maxlength=255> (",$Titles["Required"],")<br>\n";
    if ($GBcityfield) echo "  ",$Titles["City"],": <input type=text name=\"from\" value=\"",$Values["from"],"\" maxlength=255><br>\n";
    if ($GBlinkfield) echo "  ",$Titles["Link"],": <input type=text name=\"link\" value=\"",$Values["link"],"\" maxlength=255><br>\n";
    if ($GBemailfield) echo "  ",$Titles["Email"],": <input type=text name=\"email\" value=\"",$Values["email"],"\" maxlength=255> ($Titles[NotPublic])<br>\n";
    if ($GBsubjectfield) {
        echo "  ",$Titles["Subject"],": <input type=text name=\"subj\" value=\"";
        if(isset($_POST["reply"])) echo $_SESSION["reply"][7];
            else echo $Values["subj"];
        echo "\" maxlength=255><br>\n";
    }
    if ($GBcategoryfield) {
        echo "  ",$Titles["Category"],": <select name=\"category\">";
        foreach($GBcategoryfield as $Category) {
            echo "    <option value=\"$Category\"";
            if ($Values["category"]==$Category) echo " selected=\"selected\"";
            echo ">$Category</option>";
        }
        echo "</select><br>\n";
    }
    if ($GBfield1) echo "  ",$Titles["Field1"],": <input type=text name=\"field1\" value=\"",$Values["field1"],"\" maxlength=255><br>\n";
    if ($GBfield2) echo "  ",$Titles["Field2"],": <input type=text name=\"field2\" value=\"",$Values["field2"],"\" maxlength=255><br>\n";
    if ($GBfield3) echo "  ",$Titles["Field3"],": <input type=text name=\"field3\" value=\"",$Values["field3"],"\" maxlength=255><br>\n";
    echo "  ",$Titles["Text"],":<br>\n  <textarea name=\"text\" wrap=virtual cols=50 rows=5  maxlength=$GBtextlenght>",$Values["text"],"</textarea><br>\n";
    if ($GBupload) {
        echo "  <label for=\"file\">".$Titles["FileUpload"]."</label>\n";
        echo "  <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$GBfilesize."\" />\n";
        echo "  <input type=\"file\" name=\"uploadedfile\"><br>\n";
    }
    if ($GBcaptcha) echo "  ",$Titles["Captcha"],": <font class=\"text\">$captchanumber11</font><font>$captchanumber11</font><font>$captchanumber12</font> ",$Titles["CaptchaPlus"]," <font>$captchanumber21</font><font>$captchanumber22</font><font class=\"text\">$captchanumber21</font> = <input type=text name=\"captcha\" size=2 maxlength=2> ?<br>\n";
    echo "  <input type=submit name=\"submit\" value=\"",$Titles["Submit"],"\">\n";
    echo "</form>\n";
    if ($PageStatus=="emptyname") echo $Titles["EmptyName"],"<br>\n";
    if ($PageStatus=="emptytext") echo $Titles["EmptyText"],"<br>\n";
    if ($PageStatus=="wrongfile") echo $Titles["WrongFile"],"<br>\n";
    if ($PageStatus=="wrongcaptcha") echo $Titles["WrongCaptcha"],"<br>\n";
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
    global $GBfeedbackFormMode;
    if (!$GBfeedbackFormMode) {
        if ($GBsearch) {
            echo "<form action=index.php method=post>";
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
}

function SinlgeEntry($Entry) {
    global $Titles;
    global $GBreplies;
    global $GBreadmore;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    global $GBshownumbers;
    global $GBreplies;
    global $GBfield1;
    global $GBfield2;
    global $GBfield3;
    echo "  ";
    if ($GBreplies&&isset($Entry[9])&&$Entry[9]) echo "<div class=\"reply\">";
    echo "<div class=\"entry\"><div class=\"messages_header\"><h4>";
    if ($Entry[11]) echo "[",$Titles["Locked"],"] ";
    if ($Entry[12]) echo "[",$Titles["Sticky"],"] ";
    if ($GBreplies&&isset($Entry[9])&&$Entry[9]) echo "⤷ ";
        else echo "◦ ";
    if ($GBshownumbers) echo $Entry[10],". ";
    if ($Entry[2]) echo "<a href=\"",$Entry[2],"\">";
    echo "<b>",$Entry[0],"</b>";
    if ($Entry[2]) echo "</a>";
    if ($Entry[1]) echo " ",$Titles["From"]," <b>",$Entry[1],"</b>";
    echo ", ";
    echo "<a href=\"?entry=",$Entry[5],"\">";
    echo date("j.m.Y, H:i",$Entry[5]);
    echo "</a>, ";
    if ($GBreplies&&isset($Entry[9])&&$Entry[9]) {
        echo $Titles["Replied"];
    } else echo $Titles["Wrote"];
    if (($GBsubjectfield)&&($Entry[7])) echo " ",$Titles["About"]," '",$Entry[7],"'";
    if (($GBcategoryfield)&&($Entry[8])) echo " [",$Entry[8],"]";
    if (($GBfield1)&&($Entry[13])) echo $Titles["PreField1"],$Entry[13],$Titles["PostField1"];
    echo ":</div></h4><br>\n";
    if (($GBfield2)&&($Entry[14])) echo $Titles["PreField2"],$Entry[14],$Titles["PostField2"];
    if ($GBreadmore>0) {
        $Message=strip_tags($Entry[4]);
        if (strlen($Message)>$GBreadmore) {
            $readmorenumber="readmore".$Entry[10];
            if ($_POST[$readmorenumber]) echo "  ",nl2br($Entry[4]),"<br>\n";
                else {
                    $Message = substr($Message, 0, $GBreadmore);
                    $Message = substr($Message, 0, strrpos($Message, ' '))."... <form action=\"\" method=\"post\"><button type=\"submit\" name=\"readmore".$Entry[10]."\" value=\"read\" class=\"btn-link\">".$Titles["ReadMore"]."</button></form>";
                    echo "  ",nl2br($Message),"<br>\n";
                }
        } else echo "  ",nl2br($Entry[4]),"<br>\n";
    } else echo "  ",nl2br($Entry[4]),"<br>\n";
    if (($GBfield3)&&($Entry[15])) echo $Titles["PreField3"],$Entry[15],$Titles["PostField3"];
    if ($Entry[6]) echo "<br><i><b>",$Titles["Response"],":</b><br>\n";
    if ($Entry[6]) echo nl2br($Entry[6]),"</i><br>\n";
    if ($GBreplies&&!($Entry[11])) {
        echo "<form action=index.php method=post>";
        echo "<p align=\"right\"><button type=submit name=\"reply\" value=\"",$Entry[10],"\">",$Titles["Reply"],"</button></p>";
        echo "</form>";
    }
    echo "</div>";
    if ($GBreplies&&isset($Entry[9])&&$Entry[9]) echo "</div>";
    echo "<hr>\n";
}

function EntriesView() {
    global $Titles;
    global $DataStatus;
    global $Entries;
    global $GBpagination;
    global $GBreadmore;
    global $GBcityfield;
    global $GBlinkfield;
    global $GBsubjectfield;
    global $GBcategoryfield;
    global $GBreplies;
    global $GBstickylocked;
    global $GBfeedbackFormMode;
    if ($GBfeedbackFormMode) return;
    if (isset($_SESSION["reply"])) {
        echo $Titles["Replying"],"<br>\n";
    }
    if ($GBstickylocked) {
        if (isset($Entries)) {
            $EntriesStickySorted=$Entries;
            $i = count($Entries);
            while (--$i >= 0) {    
            if (isset($EntriesStickySorted[$i][12])&&($EntriesStickySorted[$i][12]=="on")) {
                $item = $EntriesStickySorted[$i];
                unset($EntriesStickySorted[$i]);
                array_push($EntriesStickySorted, $item); 
            }
        }
        $Entries=array_values($EntriesStickySorted);
        }
    }
    if ($GBreplies) {
        if (isset($Entries)) {
            $EntriesReplySorted=$Entries;
            foreach($Entries as $Entry) {
                if (isset($Entry[9])) {
                    unset($a); unset($b);
                    foreach($EntriesReplySorted as $n=>$EntrySort) if ($EntrySort[5]==$Entry[5]) $a=$n;
                    foreach($EntriesReplySorted as $n=>$EntrySort) if ($EntrySort[5]==$Entry[9]) {
                        if (isset($EntrySort[12])&&$EntrySort[12]=="on") $b=$n-1;
                            else $b=$n;
                    }
                    if (isset($b)) {
                        if (!(isset($Entry[12])&&$Entry[12]=="on")) {
                            $out=array_splice($EntriesReplySorted, $a, 1);
                            array_splice($EntriesReplySorted, $b, 0, $out);
                        }
                    }
                }
            }
            $Entries=$EntriesReplySorted;
        }
    }
    if ($DataStatus=="empty") echo $Titles["EmptyFile"];
        else if(isset($_POST["search"])&&isset($_POST["serachq"])) {
            $SearchResult=Search($_POST["serachq"]);
            if ($SearchResult) {
                $GBpagination=0;
                unset($Entries);
                foreach($SearchResult as $n=>$Entry) $Entries[$n]=$Entry[1];
            } else echo $Titles["NoResult"].": '",$_POST["serachq"],"'.<br>\n";
        }
        if (($GBpagination>0)&&(count($Entries)>$GBpagination)) {
            $Entries=array_reverse($Entries);
            if (isset($_GET["page"])) switch ($_GET["page"]) {
                case $Titles["First"]:
                    $CurrentPage=0;
                    break;
                case $Titles["Last"]:
                    $CurrentPage=(int)((count($Entries)-1)/$GBpagination);
                    break;
                case $Titles["Previous"]:
                    $CurrentPage=$_SESSION["currentpage"]-1;
                    break;
                case $Titles["Next"]:
                    $CurrentPage=$_SESSION["currentpage"]+1;
                    break;
                default:
                    $CurrentPage=$_GET["page"]-1;
            }
                else $CurrentPage=0;
            for ($e = ($GBpagination*$CurrentPage); $e < ($GBpagination*($CurrentPage+1)); $e++) {
                if ($e>=count($Entries)) break;
                SinlgeEntry($Entries[$e]);
            }
            echo "<form action=index.php method=\"get\">\n";
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
            $_SESSION["currentpage"]=$CurrentPage;
        } else {
            if (isset($Entries[0])) {
                $Entries=array_reverse($Entries);
                foreach($Entries as $e=>$Entry) SinlgeEntry($Entry);
            }
        }
}

if ($GBreplies) $GBshownumbers=false;

if(isset($_POST["submit"])) {
    if (!$_POST["text"]) $PageStatus="emptytext";
    if (!$_POST["name"]) $PageStatus="emptyname";
    if ($GBupload) {
        if ($_FILES["uploadedfile"]["name"]) {
            $UploadedFile=CheckFile();
            if ($UploadedFile==false) {
                $PageStatus="wrongfile";
            }
        }
    }
    if (($_POST["name"])&&($_POST["text"]))
        if (isset($_POST["captcha"])&&(md5(base64_encode($_POST["captcha"]))==$_SESSION["captcha"])) {
            if (!isset($PageStatus)=="wrongfile") {
                AddEntry();
                if ($GBnotificationmailto) SendMail();
            }
        } else if (!$GBcaptcha) {
                if (!isset($PageStatus)=="wrongfile") {
                    AddEntry();
                    if ($GBnotificationmailto) SendMail();
                }
            } else $PageStatus="wrongcaptcha";
    if (($PageStatus)&&!($PageStatus=="added")) {
        $_SESSION["value"]["name"]=$_POST["name"];
        $_SESSION["value"]["from"]=$_POST["from"];
        $_SESSION["value"]["link"]=$_POST["link"];
        if ($GBsubjectfield) $_SESSION["value"]["subj"]=$_POST["subj"];
            else $_SESSION["value"]["subj"]="";
        if ($GBcategoryfield) $_SESSION["value"]["category"]=$_POST["category"];
            else $_SESSION["value"]["category"]="";
        $_SESSION["value"]["email"]=$_POST["email"];
        $_SESSION["value"]["text"]=$_POST["text"];
        $_SESSION["value"]["field1"]=$_POST["field1"];
        $_SESSION["value"]["field2"]=$_POST["field2"];
        $_SESSION["value"]["field3"]=$_POST["field3"];
        $Values=$_SESSION["value"];
    } else if (isset($_SESSION["value"])) Unset($_SESSION["value"]);
}

$Entries=ReadEntries();

if (isset($_POST["reply"])) {
    $_SESSION["reply"]=$Entries[$_POST["reply"]-1];
    $GBsearch=false;
    unset($Entries);
    $GBreplies=false;
    $Entries[0]=$_SESSION["reply"];
} else unset($_SESSION["reply"]);

if (isset($_GET["entry"])) {
    foreach($Entries as $Entry) {
        if ($Entry[5] == $_GET["entry"]) {
            $newEntries[0] = $Entry;
        }
    }
    foreach($Entries as $Entry) {
        if ($Entry[9] == $_GET["entry"]) {
            $newEntries[] = $Entry;
        }
    }
    $GBsearch=false;
    $singleEntry = true;
    $Entries = $newEntries;
}

include "page.php";

?>
