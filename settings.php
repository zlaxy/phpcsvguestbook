<?php
/**
 * Settings file of PHPCSV Guestbook version 0.94
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
$GBnotificationmailto=""; // leave empty if you don't want send notification
$GBnotificationmailfrom="";
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
?>
