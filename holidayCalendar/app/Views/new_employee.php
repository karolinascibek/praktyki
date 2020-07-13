
<?php if(isset($validation)):?>
    <div>
        <?=$validation->listerrors(); ?>
    </div>
<?php endif ;?>
<div class="container">
<h1>Dodaj pracownika </h1>
<form action='/calendar/new_employee' method='post'>
   <div class="form-group">
    <label for="name">imie</label>
    <input type="text" class="form-control" name='name'id="name" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="last_name">last names</label>
    <input type="text" class="form-control" name='last_name' id="last_name" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">adres email</label>
    <input type="email" class="form-control" name ='email' id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password"  name = 'password'class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="holidays">ile dni przysługuje urlopu</label>
    <input type="text"  name = 'number_free_days'class="form-control" id="holidays">
  </div>
  <button type="submit" class="btn btn-primary">Zapisz</button>
</form>
</div>