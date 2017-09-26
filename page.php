<?php
/**
 * Main page of PHPCSV Guestbook
 * See settings.php for configuration.
 * For changing appearance you can edit this file like simple html. For example: add css tags.
 */
?><!DOCTYPE html>
<html>
<head>
  <title><?php echo $Titles[HeadTitle];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:regular&amp;subset=Latin,Cyrillic">
  <link rel="stylesheet" type="text/css" href="anthrstlsht.css">
</head>
<body>
<div class="container">
<div style="position: absolute; right: 5px; top: 25px;"><?php /* Absolute position of SearchBar */ ?>
<?php AddSearchBar();?>
</div>
<?php AddEntryView();?>
<hr>
<?php EntriesView();?>
</div>
</body>
</html>
