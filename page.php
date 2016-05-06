<?php
/**
 * Main page of PHPCSV Guestbook version 0.9
 * See settings.php for configuration.
 * For changing appearance you can edit this file like simple html. For example: add css tags.
 */
?><html>
<head>
  <title><?php echo $Titles[HeadTitle];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php AddEntryView();?>
<hr>
<?php EntriesView();?>
</body>
</html>
