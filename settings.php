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
$GBupload=true; // enable or disable upload image feature
$GBimagesize=1048576; // maximum image size
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
$Titles[HeadTitle]="Guestbook";
$Titles[Page]="Guestbook";
$Titles[Name]="Your name";
$Titles[Required]="required";
$Titles[City]="City";
$Titles[Email]="E-mail";
$Titles[NotPublic]="will not be published";
$Titles[Link]="Homepage";
$Titles[Text]="Your message";
$Titles[Captcha]="Security question";
$Titles[CaptchaPlus]="plus";
$Titles[Submit]="Submit";
$Titles[Added]="Your message has been added.";
$Titles[EmptyName]="Please, type your name.";
$Titles[EmptyText]="Please, type your message.";
$Titles[WrongCaptcha]="Please, type correct security answer.";
$Titles[From]="from";
$Titles[Wrote]="wrote";
$Titles[Response]="Response";
$Titles[EmptyFile]="Guestbook is empty yet.";
$Titles[Login]="Administrator login:";
$Titles[Password]="Password:";
$Titles[Enter]="Enter";
$Titles[WrongLogin]="Wrong login or password.";
$Titles[AdminHeader]="Guestbook administration";
$Titles[AdminExit]="Exit";
$Titles[AdminHello]="Hello";
$Titles[AdminName]="Name";
$Titles[AdminMessage]="Message";
$Titles[AdminDate]="Date";
$Titles[AdminApply]="Apply changes";
$Titles[AdminDeleteChecked]="Delete checked";
$Titles[AdminEdit]="Edit";
$Titles[AdminDelete]="Delete";
$Titles[AdminCancel]="Cancel";
$Titles[AdminSureDel]="Are you sure to delete";
$Titles[AdminSureDelMessages]="messages";
$Titles[MailSubject]="New entry in your guestbook";
$Titles[MailAdmin]="You can edit, delete or reply this message via admin page";
$Titles[First]="First";
$Titles[Last]="Last";
$Titles[Previous]="<<";
$Titles[Next]=">>";
$Titles[Search]="Search";
$Titles[NoResult]="No search result";
$Titles[ReadMore]="Read more";
$Titles[FileUpload]="Upload image:";
$Titles[WrongImage]="Can't upload image.";
$Titles[Subject]="Subject";
$Titles[Category]="Category";
$Titles[About]="about";
?>
