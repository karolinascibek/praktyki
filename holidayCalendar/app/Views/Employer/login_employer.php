
  <div class="container  py-5">
  <div class="row justify-content-md-center">
    <div class="col-lg-6  col-md-6">
      <div class="row justify-content-center text-center">
        <div class="col-12">
          <h2> Zaloguj się jako pracodawca</h2>

            <?php if(session()->get('success')): ?>
              <div class="alert alert-success" role='alert'>
                  <?= session()->get('success');?>
              </div>
            <?php endif; ?>
        </div>
      </div>
      <div class="row ">
        <div class="col-12">
        <hr>
            <form action='/employer' method='post'>

              <div class="form-group justify-content-center ">
                <label for="exampleInputEmail1">Adres email</label>
                <input type="email" class="form-control" name ='email' id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted"></small>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Hasło </label>
                <input type="password"  name = 'password'class="form-control" id="exampleInputPassword1">
              </div>

              <div class="row">
                <div class="col-12">
                <?php if(isset($validation)): ?>
                  <div class="alert alert-danger" role='alert'>
                    
                          <?= $validation->listErrors()?>
                    
                    </div>
                    <?php endif; ?>
                  </div>
              </div>
              <button type="submit" class="btn btn-primary btn-md btn-block">Zaloguj się </button>
            </form>
        </div>
      </div>
      <hr>
      <div class="row justify-content-center text-center my-2">
        <div class="col-12">
          <a href="/employer/register_employer">Nie masz konta? Zarejestruj się.</a>
          
        </div>
      </div>

      </div>
  </div>
  </div>
