<?php
  date_default_timezone_set('UTC');
  $day = date('l');
?>
<!doctype html>
<html>
  <head>
    <title>Hello, World! | Test</title>
  </head>
  <body>
    <h1>Hello, World!</h1>
    <p>Welcome to <strong>test</strong>.</p>
    <p>Today is <?php echo $day; ?>.</p>
  </body>
</html>