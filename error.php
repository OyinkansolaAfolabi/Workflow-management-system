<?php
  // $errorPath = ini_get('error_log');
  // echo "$errorPath";

  $error = pathinfo(phpinfo('error_log'),PATHINFO_DIRNAME);
  echo "$error";
?>