<?php header('Access-Control-Allow-Origin: *');

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/calendar.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="css/Dashboard/styles.css" >
    
    <title><?=esc($title)?></title>
</head>
<body>
<?php 
  $url = service('url');
?>
<div class='main '>
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
      <a class="navbar-brand" href="<?php echo base_url()?>/dashboard"> <i class="fas fa-calendar-alt"></i> Kalendarz</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-1 mt-lg-0">
        <li class="nav-item active">
            <a class="nav-link" href="/profile">Profil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?php echo $name.' '.$last_name ?></a>
        </li>
      </ul>
      <ul class="navbar-nav  my-lg-0">
      <li class="nav-item ">
          <a class="nav-link " href="<?php echo base_url()?>/employer/logout" tabindex="-1" aria-disabled="true">Wyloguj się </a>
        </li>
      </ul>

    </div>
</nav>
