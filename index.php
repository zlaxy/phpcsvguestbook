<?php
/**
 * Main program file of PHPCSV Guestbook version 0.9
 * See settings.php for configuration.
 * Edit page.php for change appearance.
 * See license.txt for licensing information.
 */
session_start();
include "settings.php";

function ReadEntries() {
    global $GBdata;
    global $DataStatus;
    $fhandle=fopen($GBdata,"r") or $DataStatus="empty";
    for($e=0; $entrydata=fgetcsv($fhandle, 16384, ","); $e++) {
        $Entries["$e"]=$entrydata;
        $Entries["$e"][7]=$e+1;
    }
    fclose($fhandle);
    if (!$Entries[0]) $DataStatus="empty";
    return $Entries;
}

function AddEntry() {
    global $GBdata;
    global $Titles;
    global $PageStatus;
    $NewEntry[name]=$_POST['name'];
    $NewEntry[from]=$_POST['from'];
    $NewEntry[link]=$_POST['link'];
    $NewEntry[email]=$_POST['email'];
    $NewEntry[text]=$_POST['text'];
    $NewEntry[datetime]=time();
    $NewEntry[response]="";
    $fhandle=fopen($GBdata,"a");
    fputcsv($fhandle,$NewEntry);
    fclose($fhandle);
    $PageStatus="added";
    $_SESSION['captcha']="";
}

function AddEntryView() {
    global $Titles;
    global $Values;
    global $PageStatus;
    echo "<h2>",$Titles[Page],"</h2><br>\n";
    if ($PageStatus=="added") echo "$Titles[Added]"; else {
        $captchanumber11=rand(1, 4);
        $captchanumber12=rand(0, 9);
        $captchanumber21=rand(1, 4);
        $captchanumber22=rand(0, 9);
        $_SESSION['captcha']=md5(base64_encode(($captchanumber11.$captchanumber12)+($captchanumber21.$captchanumber22)));
        echo "<form action=index.php method=post>\n";
        echo "  $Titles[Name]: <input type=text name=\"name\" value=\"",$Values["name"],"\" maxlength=255> ($Titles[Required])<br>\n";
        echo "  $Titles[City]: <input type=text name=\"from\" value=\"",$Values["from"],"\" maxlength=255><br>\n";
        echo "  $Titles[Link]: <input type=text name=\"link\" value=\"",$Values["link"],"\" maxlength=255><br>\n";
        echo "  $Titles[Email]: <input type=text name=\"email\" value=\"",$Values["email"],"\" maxlength=255> ($Titles[NotPublic])<br>\n";
        echo "  $Titles[Text]:<br>\n  <textarea name=\"text\" wrap=virtual cols=50 rows=5  maxlength=7168>",$Values["text"],"</textarea><br>\n";
        echo "  $Titles[Captcha]: <font color=\"transparent\">$captchanumber11</font><font>$captchanumber11</font><font>$captchanumber12</font> $Titles[CaptchaPlus] <font>$captchanumber21</font><font>$captchanumber22</font><font color=\"transparent\">$captchanumber21</font> = <input type=text name=\"captcha\" size=2 maxlength=2> ?<br>\n";
        echo "  <input type=submit name=\"submit\" value=\"$Titles[Submit]\">\n";
        echo "</form>\n";
        if ($PageStatus=="emptyname") echo "$Titles[EmptyName]<br>\n";
        if ($PageStatus=="emptytext") echo "$Titles[EmptyText]<br>\n";
        if ($PageStatus=="wrongcaptcha") echo "$Titles[WrongCaptcha]<br>\n";
    }
}

function EntriesView() {
    global $Titles;
    global $DataStatus;
    global $Entries;
    if ($DataStatus=="empty") echo "$Titles[EmptyFile]";
        else {
            $Entries=array_reverse($Entries);
            foreach($Entries as $e=>$Entry) {
                echo "  ",$Entry[7],". ";
                if ($Entry[2]) echo "<a href=\"$Entry[2]\">";
                echo "<b>",$Entry[0],"</b>";
                if ($Entry[2]) echo "</a>";
                if ($Entry[1]) echo " ",$Titles[From]," <b>",$Entry[1],"</b>";
                echo ", ",date("j.m.Y, H:i",$Entry[5]),", ",$Titles[Wrote],":<br>\n";
                echo "  ",nl2br($Entry[4]),"<br>\n";
                if ($Entry[6]) echo "<br><i><b>$Titles[Response]:</b><br>\n";
                if ($Entry[6]) echo nl2br($Entry[6]),"</i><br>\n";
                echo "<hr>\n";
            }
        }
}

if($_POST['submit']) {
    if(!$_POST['text']) $PageStatus="emptytext";
    if(!$_POST['name']) $PageStatus="emptyname";
    if(($_POST['name'])&&($_POST['text']))
        if ($_POST["captcha"]&&(md5(base64_encode($_POST["captcha"]))==$_SESSION["captcha"])) AddEntry();
            else $PageStatus="wrongcaptcha";
    if (($PageStatus)&&!($PageStatus=="added")) {
        $SESSION["value"]["name"]=$_POST['name'];
        $SESSION["value"]["from"]=$_POST['from'];
        $SESSION["value"]["link"]=$_POST['link'];
        $SESSION["value"]["email"]=$_POST['email'];
        $SESSION["value"]["text"]=$_POST['text'];
        $Values=$SESSION["value"];
    } else Unset($SESSION["value"]);
}

$Entries=ReadEntries();

include "page.php";
?>
