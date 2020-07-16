
<?php if(isset($validation)):?>
    <div>
        <?=$validation->listerrors(); ?>
        <?= form_open( base_url().`/calendar/new_employee`) ?>
    </div>
<?php endif ;?>
<div class="container">
<h1>Dodaj pracownika </h1>
<form action='/calendar/new_employee' method='post'>
   <div class="form-group">
    <label for="name">Imie</label>
    <input type="text" class="form-control" name='name'id="name" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="last_name">Nazwisko </label>
    <input type="text" class="form-control" name='last_name' id="last_name" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Adres email</label>
    <input type="email" class="form-control" name ='email' id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Hasło </label>
    <input type="password"  name = 'password'class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword2">Powtórz hasło </label>
    <input type="password"  name = 'password_confirm'class="form-control" id="exampleInputPassword2">
  </div>
  <div class="form-group">
    <label for="holidays">Ile dni urlopu przysługuje?</label>
    <input type="text"  name = 'number_free_days'class="form-control" id="holidays">
  </div>
  <button type="submit" class="btn btn-primary">Zapisz</button>
</form>
</div>