<?php
/**
 * Settings file of PHPCSV Guestbook
 * Edit page.php for change appearance.
 * $GBdata parameter for changing entries data file.
 * Please, change $GBadmin and $GBpassword parameters for access to administration page.
 */

$GBdata=".htgbdb.csv";
$GBadmin="root";
$GBpassword="password";

$GBpagination=10; // pagination for entries, 0 - disabled
                  // عدد الإدخالات في الصفحة الواحدة, 0 - معطل
                  // количество записей на странице, 0 - все записи на одной странице
$GBreadmore=255; // number of symbols for 'Read More' feature, 0 - shows full entries
                 // عدد الحروف التي تظهر في المزيد من القراءة, 0 - إظهار كامل النص
                 // количество символов для функции 'Читать далее', 0 - показывать записи полностью
$GBsearch=true; // enable or disable search bar
                // تفعيل أو تعطيل شريط البحث
                // включение или отключение строки поиска
$GBcaptcha=true; // enable or disable captcha
                 // تفعيل أو تعطيل التحقق كابتشا
                 // включение или отключение капчи
$GBupload=array(  // enable or disable upload feature
    0=>"images",  // $GBupload=false; - disabled
    1=>"pdf",     // $GBupload=true; - enabled for all files
    2=>"odt",     // $GBupload=array(); - enabled for file types from this array
    3=>"odx",     // تفعيل أو تعطيل خيارات التحميل
    4=>"doc",     // $GBupload=false; - تعطيل
    5=>"docx",    // $GBupload=true; - تفعيل كل الملفات
    6=>"xls",     // $GBupload=array(); - تفعيل أنواع محددة من الملفات
    7=>"xlsx",    // включение или отключение функции загрузки файлов
    8=>"txt",     // $GBupload=false; - отключено
    9=>"zip",     // $GBupload=true; - включено для всех файлов
    10=>"rar");   // $GBupload=array(); - включено для типов перечисленных в этом массиве
$GBfilesize=1048576; // maximum file size
                     // أقصى حجم ملف
                     // максимальный размер загружаемого файла
$GBnotificationmailto=array(    // enable or disable email notifications, false - disabled, array - addresses
    0=>"somemail@mail.com",     // تمكين أو تعطيل إعلامات البريد الإلكتروني، كاذبة - تعطيل، مجموعة من العناوين.
    1=>"anothermail@mail.com"); // включение или отключение уведомлений на почту, false - отключено, array - список адресов
$GBnotificationmailfrom="gb@mail.com"; // mailfrom field for notifications
                                       // البريد من الميدان للإشعارات
                                       // поле mailfrom для уведомленеий
$GBtextlenght=7168; // maximum size of entry text
                    // أقصى حجم نص مدخل
                    // максимальное количество символов для текста записи
$GBcityfield=true; // enable or disable 'City' field
                   // تفعيل أو تعطيل حقل المدينة
                   // включение или отключение поля 'Город'
$GBlinkfield=true; // enable or disable 'Homepage' field
                   // تفعيل أو تعطيل حقل الصفحة الرئيسية
                   // включение или отключение поля 'Домашняя страница'
$GBsubjectfield=true; // enable or disable 'Subject' field
                      // تفعيل أو تعطيل حقل الموضوع
                      // включение или отключение поля 'Тема'
$GBemailfield=true; // enable or disable email field
                // تفعيل أو تعطيل حقل البريد الإلكتروني
                // включить или отключить поле электронной почты
$GBfield1=true; // enable or disable special field 1
                // تمكين أو تعطيل حقل خاص 1
                // включить или отключить специальное поле 1
$GBfield2=true; // enable or disable special field 2
                // تمكين أو تعطيل حقل خاص 2
                // включить или отключить специальное поле 2
$GBfield3=true; // enable or disable special field 3
                // تمكين أو تعطيل حقل خاص 3
                // включить или отключить специальное поле 3
$GBcategoryfield=array(   // Array of categories, if you want to disable
    0=>"Public",          // 'Category' field, just leave
    1=>"Help",            // '$GBcategoryfield=false' string
    2=>"Special",         // مجموعة الفئات إذا كنت ترغب بتعطليها
    3=>"Suppot",          // Список категорий, если вы хотите удалить
    4=>"Order",           // поле 'Категории', просто оставьте строку
    5=>"Other");          // '$GBcategoryfield=false'
$GBstriptags=true; // enable or disable strip tags function during adding new entry
                   // مكين أو تعطيل وظيفة tags أثناء إضافة إدخال جديد 
                   // включение или отключение функции обрезания тегов при добавлении новой записи
$GBreplies=true; // enable or disable replies to messages
                 // تمكين أو تعطيل الردود على الرسائل
                 // включение или отключение ответов на сообщения
$GBshownumbers=true; // show or not show number of entries (if replies enabled - numbers will not shown anyway)
                     // إظهار أو عدم إظهار عدد من الإدخالات: إذا تم تمكين الردود - لن تظهر الأرقام على أي حال 
                     // показывать или не показывать номера сообщений (если включены ответы - номера сообщений не будут показываться)
$GBstickylocked=true; // stick or lock entries in admin panel
                      // تثبيت أو قفل الإدخالات في لوحة الادارة
                      // приклеивать или лочить записи через панель администратора
$GBlanguage="en"; // "en" for include english settings_en.php
                  // "ar" لاستخدام النسخة العربية settings_ar.php
                  // "ru" для использования русской версии settings_ru.php
?>
