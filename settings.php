<?php
/**
 * Settings file of PHPCSV Guestbook
 * Edit page.php for change appearance.
 * $GBdata parameter for changing entries data file.
 * Please, change $GBadmin and $GBpassword parameters for access to administration page.
 * Change $Titles[HeadTitle] and $Titles[Page] for personal header.
 * You can change $Titles parameters for localization.
 */
$GBdata="gbdb.csv";
$GBadmin="root";
$GBpassword="password";
$GBpagination=10; // pagination for entries, 0 - disabled
$GBreadmore=255; // number of symbols for 'Read More' feature, 0 - shows full entries
$GBsearch=true; // enable or disable search bar
$GBcaptcha=true; // enable or disable captcha
$GBupload=array(  // enable or disable upload feature
    0=>"images",  // $GBupload=false; - disabled
    1=>"pdf",     // $GBupload=true; - enabled for all files
    2=>"odt",     // $GBupload=array(); - enabled for file types from this array
    3=>"odx",
    4=>"doc",
    5=>"docx",
    6=>"xls",
    7=>"xlsx",
    8=>"txt",
    9=>"zip",
    10=>"rar");
$GBfilesize=1048576; // maximum file size
$GBnotificationmailto=""; // leave empty if you don't want send notification
$GBnotificationmailfrom="";
$GBtextlenght=7168; // maximum size of entry text
$GBcityfield=true; // enable or disable 'City' field
$GBlinkfield=true; // enable or disable 'Homepage' field
$GBsubjectfield=true; // enable or disable 'Subject' field
$GBcategoryfield=array(
    0=>"Public",          // Array of categories, if you want to disable
    1=>"Help",            // 'Category' field, just leave
    2=>"Special",         // '$GBcategoryfield=false' string
    3=>"Suppot",
    4=>"Order",
    5=>"Other");
$GBstriptags=true; // enable or disable strip tags function during adding new entry
$GBreplies=true; // enable or disable replies to mwssages
$GBshownumbers=true; // show or not show number of entries (if replies enabled - numbers will not shown anyway)
$GBstickylocked=true; // stick or lock entries in admin panel
$GBfield1=true; // enable or disable special field 1
$GBfield2=true; // enable or disable special field 2
$GBfield3=true; // enable or disable special field 3
$GBemailfield=true; // enable or disable email field
$Titles["HeadTitle"]="Guestbook";
$Titles["Page"]="Guestbook";
$Titles["Name"]="Your name";
$Titles["Required"]="required";
$Titles["City"]="City";
$Titles["Email"]="E-mail";
$Titles["NotPublic"]="will not be published";
$Titles["Link"]="Homepage";
$Titles["Text"]="Your message";
$Titles["Captcha"]="Security question";
$Titles["CaptchaPlus"]="plus";
$Titles["Submit"]="Submit";
$Titles["Added"]="Your message has been added.";
$Titles["EmptyName"]="Please, type your name.";
$Titles["EmptyText"]="Please, type your message.";
$Titles["WrongCaptcha"]="Please, type correct security answer.";
$Titles["From"]="from";
$Titles["Wrote"]="wrote";
$Titles["Response"]="Response";
$Titles["EmptyFile"]="Guestbook is empty yet.";
$Titles["Login"]="Administrator login:";
$Titles["Password"]="Password:";
$Titles["Enter"]="Enter";
$Titles["WrongLogin"]="Wrong login or password.";
$Titles["AdminHeader"]="Guestbook administration";
$Titles["AdminExit"]="Exit";
$Titles["AdminHello"]="Hello";
$Titles["AdminName"]="Name";
$Titles["AdminMessage"]="Message";
$Titles["AdminDate"]="Date";
$Titles["AdminApply"]="Apply changes";
$Titles["AdminDeleteChecked"]="Delete checked";
$Titles["AdminEdit"]="Edit";
$Titles["AdminDelete"]="Delete";
$Titles["AdminCancel"]="Cancel";
$Titles["AdminSureDel"]="Are you sure to delete";
$Titles["AdminSureDelMessages"]="messages";
$Titles["MailSubject"]="New entry in your guestbook";
$Titles["MailAdmin"]="You can edit, delete or reply this message via admin page";
$Titles["First"]="First";
$Titles["Last"]="Last";
$Titles["Previous"]="<<";
$Titles["Next"]=">>";
$Titles["Search"]="Search";
$Titles["NoResult"]="No search result";
$Titles["ReadMore"]="Read more";
$Titles["FileUpload"]="Upload file:";
$Titles["WrongFile"]="Can't upload file.";
$Titles["Subject"]="Subject";
$Titles["Category"]="Category";
$Titles["About"]="about";
$Titles["Reply"]="Reply";
$Titles["Replied"]="replied";
$Titles["Replying"]="Replying to this message:";
$Titles["Locked"]="Locked";
$Titles["Sticky"]="Sticky";
$Titles["AttachedFile"]="Attached file";
$Titles["Field1"]="Field1";
$Titles["PreField1"]="<i>";
$Titles["PostField1"]="</i>";
$Titles["Field2"]="Field2";
$Titles["PreField2"]="<b>";
$Titles["PostField2"]="</b>";
$Titles["Field3"]="Field3";
$Titles["PreField3"]="<i>";
$Titles["PostField3"]="</i>";
?>
