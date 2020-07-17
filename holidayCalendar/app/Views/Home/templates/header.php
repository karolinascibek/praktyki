<?php header('Access-Control-Allow-Origin: *');?>
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
    

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light ">
 <div class="mx-4">
   
  </div>
  <nav class="nav">
  <a class="navbar-brand" href="<?php base_url()?>/home">   <i class="fas fa-calendar-alt"> </i>  <span>Kalendarz</span></a>
  <a class="nav-link" href="<?php base_url()?>/employer">Pracodawca</a>
  <a class="nav-link" href="<?php base_url()?>/employee">Pracownik</a>
</nav>
</nav>