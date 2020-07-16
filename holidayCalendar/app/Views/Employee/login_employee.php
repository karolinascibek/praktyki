<div class="container">
<h1>Zaloguj się </h1>
pracownik
<form action='/home/login_employee' method='post'>
  <div class="form-group">
    <label for="exampleInputEmail1">Adres email</label>
    <input type="email" class="form-control" name ='email' id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Hasło </label>
    <input type="password"  name = 'password'class="form-control" id="exampleInputPassword1">
  </div>

  <button type="submit" class="btn btn-primary">Zapisz</button>
</form>
<a href="/employee/register_employee">Nie masz konta? Zarejestruj się.</a>
</div>
