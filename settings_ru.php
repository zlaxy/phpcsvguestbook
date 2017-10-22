<?php
/**
 * Russian version of settings file PHPCSV Guestbook
 * Для руссификации гостевой книги замените оригинальный settings.php на содержимое этого файла.
 * Редактируйте page.php для изменения внешнего вида.
 * $GBdata параметр служит для смены файла данных записей гостевой книги.
 * Пожалуйста, измените $GBadmin и $GBpassword параметры для доступа к странице администрирования.
 * $Titles[HeadTitle] и $Titles[Page] позволит сделать вам персональные заголовки.
 * Также можно менять все $Titles параметры для изменения отображения текста в гостевой книге.
 */
$GBdata="gbdb.csv";
$GBadmin="root";
$GBpassword="password";
$GBpagination=10; // количество записей на странице, 0 - все записи на одной странице
$GBreadmore=0; // количество символов для функции 'Читать далее', 0 - показывать записи полностью
$GBsearch=true; // включение или отключение строки поиска
$GBcaptcha=true; // включение или отключение капчи
$GBupload=array(  // включение или отключение функции загрузки файлов
    0=>"images",  // $GBupload=false; - отключено
    1=>"pdf",     // $GBupload=true; - включено для всех файлов
    2=>"odt",     // $GBupload=array(); - включено для типов перечисленных в этом массиве
    3=>"odx",
    4=>"doc",
    5=>"docx",
    6=>"xls",
    7=>"xlsx",
    8=>"txt",
    9=>"zip",
    10=>"rar");
$GBfilesize=1048576; // максимальный размер загружаемого файла
$GBnotificationmailto=""; // оставьте поле пустым, если не хотите отправки уведомлений о новых записях
$GBnotificationmailfrom="";
$GBtextlenght=7168; // максимальное количество символов для текста записи
$GBcityfield=true; // включение или отключение поля 'Город'
$GBlinkfield=true; // включение или отключение поля 'Домашняя страница'
$GBsubjectfield=true; // включение или отключение поля 'Тема'
$GBcategoryfield=array(
    0=>"Public",          // Список категорий, если вы хотите удалить
    1=>"Help",            // поле 'Категории', просто оставьте строку
    2=>"Special",         // '$GBcategoryfield=false'
    3=>"Suppot",
    4=>"Order",
    5=>"Other");
$GBstriptags=true; // включение или отключение функции обрезания тегов при добавлении новой записи
$GBreplies=true; // включение или отключение ответов на сообщения
$GBshownumbers=true; // показывать или не показывать номера сообщений (если включены ответы - номера сообщений не будут показываться)
$GBstickylocked=true; // приклеивать или лочить записи через панель администратора
$GBfield1=true; // включить или отключить специальное поле 1
$GBfield2=true; // включить или отключить специальное поле 2
$GBfield3=true; // включить или отключить специальное поле 3
$GBemailfield=true; // включить или отключить поле электронной почты
$Titles["HeadTitle"]="Гостевая книга";
$Titles["Page"]="Гостевая книга";
$Titles["Name"]="Ваше имя";
$Titles["Required"]="обязательно";
$Titles["City"]="Город";
$Titles["Email"]="Электронная почта";
$Titles["NotPublic"]="не будет публиковаться";
$Titles["Link"]="Домашняя страница";
$Titles["Text"]="Ваше сообщение";
$Titles["Captcha"]="Вопрос безопасности";
$Titles["CaptchaPlus"]="плюс";
$Titles["Submit"]="Отправить";
$Titles["Added"]="Ваше сообщение было добавлено.";
$Titles["EmptyName"]="Пожалуйста, введите Ваше имя.";
$Titles["EmptyText"]="Пожалуйста, введите текст сообщения.";
$Titles["WrongCaptcha"]="Пожалуйста, введите верный ответ на вопрос безопасности.";
$Titles["From"]="из";
$Titles["Wrote"]="написал";
$Titles["Response"]="Ответ";
$Titles["EmptyFile"]="Гостевая книга пока пуста.";
$Titles["Login"]="Имя администратора:";
$Titles["Password"]="Пароль:";
$Titles["Enter"]="Войти";
$Titles["WrongLogin"]="Неверные имя администратора или пароль.";
$Titles["AdminHeader"]="Администрация гостевой книги";
$Titles["AdminExit"]="Выход";
$Titles["AdminHello"]="Приветствую";
$Titles["AdminName"]="Имя";
$Titles["AdminMessage"]="Сообщение";
$Titles["AdminDate"]="Дата";
$Titles["AdminApply"]="Принять изменения";
$Titles["AdminDeleteChecked"]="Удалить отмеченные";
$Titles["AdminEdit"]="Редактирование";
$Titles["AdminDelete"]="Удалить";
$Titles["AdminCancel"]="Отменить";
$Titles["AdminSureDel"]="Вы уверены, что хотите удалить";
$Titles["AdminSureDelMessages"]="сообщений";
$Titles["MailSubject"]="Новая запись в вашей гостевой книге";
$Titles["MailAdmin"]="Вы можете редактировать, удалить или ответить на эту запись через страницу администрирования";
$Titles["First"]="В начало";
$Titles["Last"]="В конец";
$Titles["Previous"]="Назад";
$Titles["Next"]="Вперед";
$Titles["Search"]="Поиск";
$Titles["NoResult"]="Ничего не найдено";
$Titles["ReadMore"]="Читать далее";
$Titles["FileUpload"]="Загрузить файл:";
$Titles["WrongFile"]="Не могу загрузить файл.";
$Titles["Subject"]="Тема";
$Titles["Category"]="Категория";
$Titles["About"]="о";
$Titles["Reply"]="Ответить";
$Titles["Replied"]="ответил";
$Titles["Replying"]="Ответ на это сообщение:";
$Titles["Locked"]="Нельзя ответить";
$Titles["Sticky"]="Закрепленное сверху";
$Titles["AttachedFile"]="Прикрепленный файл";
$Titles["Field1"]="Поле1";
$Titles["PreField1"]="<i>";
$Titles["PostField1"]="</i>";
$Titles["Field2"]="Поле2";
$Titles["PreField2"]="<b>";
$Titles["PostField2"]="</b>";
$Titles["Field3"]="Поле3";
$Titles["PreField3"]="<i>";
$Titles["PostField3"]="</i>";
?>
