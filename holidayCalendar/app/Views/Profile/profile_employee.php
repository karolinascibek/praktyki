
<div class="container pb-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header bg-dark text-light">Ustawienia</h5>
                <div class="card-body">
                    <div class="row py-4">
                        <div class="col-12">
                        <!-- Imie i nazwisko-->
                        <h3 class=''>Dane użytkownika</h3>
                        <hr>
                        <form action='/profile/edit_name_employee' method='post'>
                            <div class="row justify-content-center py-2">
                                <div class="col-6">
                                    <input type="text" class="form-control" placeholder="Imie" name='name' value="<?=$name?>">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" placeholder="Nazwsko" name='last_name' value="<?=$last_name?>">
                                </div>
                            </div>
                            <fieldset disabled>
                            <div class="form-group">
                                <label for="disabledTextInput">Email</label>
                                <input type="text" id="disabledTextInput" class="form-control bg-light" placeholder="<?=$email?>">
                            </div>
                            </fieldset>
                            <div class="row ">
                                <div class="col-12 text-center">
                                <?php if(isset($_SESSION['validation_name'])): ?>
                                    <div class="alert alert-danger" role='alert'>
                                        
                                        <?= $_SESSION['validation_name']->listErrors()?>
                                        
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 text-center">
                                     <input type="submit" class='btn btn-primary btn-md'value='Zapisz'>  
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-12">
                        <!-- hasło-->
                        <h3 class=''>Zmień hasło</h3>
                        <hr>
                        <form class='' action='/profile/edit_password_employee' method='post'>

                            <div class="row  justify-content-center  py-2">
                                <div class="col-8">
                                <input type="password" class="form-control"name='password' placeholder="Nowe hasło">
                                </div>
                            </div>
                            <div class="row  justify-content-center  py-2">
                                <div class="col-8">
                                <input type="password" class="form-control" name='confirm_password' placeholder="Powtórz hasło">
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12 text-center">
                                <?php if(isset($_SESSION['validation'])): ?>
                                    <div class="alert alert-danger" role='alert'>
                                        
                                        <?= $_SESSION['validation']->listErrors()?>
                                        
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12 text-center">
                                     <input type="submit" class='btn btn-primary btn-md'value='Zapisz'>  
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="row pb-1 ">
                        <div class="col-12">
                        <!-- konto-->
                        <h3 class=''>Usuń konto</h3>
                        <hr>
                        <form action='/profile/delete_account_employee' method='post' class='my-5 '>
                            <div class="row pl-3 ">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name='delete' id="exampleInputEmail1" value ="1" >
                                </div>
                                <button type="button" id= 'btn-delete' class="btn btn-primary " data-toggle="modal" data-target="#exampleModal" >Usuń</button>
                            </div>             
                                <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Czy na pewno chcesz usunąć? </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around">
                                        <div>
                                            <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal">  Anuluj  </button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-danger btn-lg btn-block ">  Usuń  </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>