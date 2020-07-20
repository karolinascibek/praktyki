<div class=' container  '>
    <div class="row  justify-content-md-center">
        <div class="col-8">
            <form class='' action='<?=$_SERVER['PHP_SELF']?>' method='post'>
                <div class='my-3'>
                <h3>Dane pracownika</h3>
                
                </div>
                <hr>
                <div class="form-group row">
                    <label for="staticEmail" class="col-md-2 col-4 col-form-label text-right p-2">Imie:</label>
                    <div class="col-md-10 col-8 ">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?=$name_employee?>">
                    </div>
                    <label for="staticLast_name" class="col-md-2 col-4 col-form-label text-right p-2 ">Nazwisko:</label>
                    <div class="col-md-10 col-8 justify-content-start ">
                    <input type="text" readonly class="form-control-plaintext" id="staticLast_name" value="<?=$last_name_employee?>">
                    </div>
                </div>
                <div class='my-4'>
                <h3>Ustawnienia</h3>
                <hr>
                </div>
                <div class="form-group row">
                    <label for="pula" class="col-sm-2 col-form-label">Pula</label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" name='pula' id="pula" value="<?=$number_free_days?>">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Zmień</button>
                </div>
            </form>
            <hr>
        </div>

    </div>
    <div class="row my-5  justify-content-md-center">
        <div class='col-8'>
        <h4>Usuń z kalendarza</h4>
        <hr>
            <form action="<?=$_SERVER['PHP_SELF']?>" method='post'>
                <button type="button" id= 'btn-delete' class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Usuń</button>
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
                            <input type="hidden" name='delete' value='1'>
                            <button type="submit" class="btn btn-danger btn-lg btn-block " >  Usuń  </button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </form>
        </div>

    </div>

</div>