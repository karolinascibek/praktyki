
<div class="container py-5">
  <div class="row justify-content-md-center text-center">
    <div class="col-lg-7 my-4">
      <h1>Zarejestruj się jako pracodawca  </h1>
      <hr>
    </div>
  </div>
 
  <div class="row justify-content-md-center">
    <div class="col-lg-7">
      <form action='/employer/register_employer' method='post'>

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
          <input type="text" class="form-control" name ='email' id="exampleInputEmail1" aria-describedby="emailHelp">
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
        
     <div class="row justify-content-center text-center">
       <div class="col-lg-7">
        <?php if(isset($validation)): ?>
          <div class="alert alert-danger" role='alert'>
              <?= $validation->listErrors()?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row justify-content-md-center text-center my-3">
      <div class="col-lg-7 ">
        <button type="submit" class="btn btn-primary btn-md btn-block">Zarejestruj się </button>
         
      </div>
    </div>
    <hr>
  </form>
  </div>
  </div>
</div>
</div>