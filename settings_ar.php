<?php
/**
 * Arabic version of settings file PHPCSV Guestbook (change original settings.php with this file for localization)
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
$GBcaptcha=false; // enable or disable captcha
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
$Titles["HeadTitle"]="سجل الزوار";
$Titles["Page"]="سجل الزوار";
$Titles["Name"]="اسمك";
$Titles["Required"]="*";
$Titles["City"]="المدينة";
$Titles["Email"]="البريد الإلكتروني";
$Titles["NotPublic"]="لن يتم نشره";
$Titles["Link"]="رابط صفحتك";
$Titles["Text"]="نص الرسالة";
$Titles["Captcha"]="سؤال الأمان والتحقق";
$Titles["CaptchaPlus"]="+";
$Titles["Submit"]="موافق";
$Titles["Added"]="تمت إضافة رسالتك";
$Titles["EmptyName"]="الرجاء كتابة اسمك";
$Titles["EmptyText"]="الرجاء كتابة رسالتك";
$Titles["WrongCaptcha"]="الرجاء كتابة الإجابة الأمنية الصحيحة";
$Titles["From"]="من";
$Titles["Wrote"]="الكاتب";
$Titles["Response"]="رد الإدارة";
$Titles["EmptyFile"]="سجل الزوار فارغ حتى الآن";
$Titles["Login"]="تسجيل دخول المسؤول:";
$Titles["Password"]="كلمة السر:";
$Titles["Enter"]="دخول";
$Titles["WrongLogin"]="خطا في اسم الدخول او في كلمه المرور";
$Titles["AdminHeader"]="إدارة سجل الزوار";
$Titles["AdminExit"]="خروج";
$Titles["AdminHello"]="مرحباً";
$Titles["AdminName"]="الاسم";
$Titles["AdminMessage"]="الرسالة";
$Titles["AdminDate"]="التاريخ";
$Titles["AdminApply"]="تطبيق التغيرات";
$Titles["AdminDeleteChecked"]="حذف المحدد";
$Titles["AdminEdit"]="تحرير";
$Titles["AdminDelete"]="حذف";
$Titles["AdminCancel"]="إلغاء";
$Titles["AdminSureDel"]="هل انت متأكد من الحذف";
$Titles["AdminSureDelMessages"]="الرسائل";
$Titles["MailSubject"]="إدخال جديد في دفتر الزوار الخاص بك";
$Titles["MailAdmin"]="يمكنك تعديل هذه الرسالة أو حذفها أو الرد عليها عبر صفحة المشرف";
$Titles["First"]="الأولى";
$Titles["Last"]="الأخيرة";
$Titles["Previous"]="<<";
$Titles["Next"]=">>";
$Titles["Search"]="بحث";
$Titles["NoResult"]="لا يوجد نتائج بحث";
$Titles["ReadMore"]="قراءة المزيد";
$Titles["FileUpload"]="رفع ملف:";
$Titles["WrongFile"]="يتعذر تحميل الملف";
$Titles["Subject"]="الموضوع";
$Titles["Category"]="التصنيف";
$Titles["About"]="حول";
$Titles["Reply"]="رد";
$Titles["Replied"]="إجابة";
$Titles["Replying"]="الرد على هذه الرسالة:";
$Titles["Locked"]="قفل";
$Titles["Sticky"]="تثبيت";
$Titles["AttachedFile"]="إضافة مرفقات";
$Titles["Field1"]="حقل 1";
$Titles["PreField1"]="<i>";
$Titles["PostField1"]="</i>";
$Titles["Field2"]="حقل 2";
$Titles["PreField2"]="<b>";
$Titles["PostField2"]="</b>";
$Titles["Field3"]="حقل 3";
$Titles["PreField3"]="<i>";
$Titles["PostField3"]="</i>";
?>
