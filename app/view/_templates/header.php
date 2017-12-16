<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Virus Tester</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>

    <!-- navigation -->
    <?php if (isset($_SESSION['userID'])) {
      echo <<<_LOGGEDIN
      <div class="navigation">
          <a class="nav-right" href="/VirusTester/users/logout">Log out</a>
      </div>
_LOGGEDIN;
} else {
      echo <<<_END
      <div class="navigation">
          <a class="nav-right" href="/VirusTester/users/login">Log in</a>
      </div>
_END;
}
    ?>
    <!-- logo -->
    <div class="logo center">
        <a style="text-decoration:none; color: black" class="logo-link" href="<?php echo URL; ?>home">VirusTester</a>
    </div>
    <div class="center">
      <span>Analyze suspicious files and URLs to detect types of malware <br>including viruses, worms, and trojans.</span>
    </div>
