
<div class="container   my-5">
<div class="card  ">
  <h5 class="card-header bg-dark text-light">Ustawienia</h5>
  <div class="card-body">
    <form action='/calendar/edit' method='post' >
        <div class="form-group">
            <label for="exampleInputEmail1">Tytuł kalendarza</label>
            <input type="name" class="form-control" name='name' id="exampleInputEmail1" value ="<?=$title?>" >
        </div>
        <div class="">
            <?php if(isset($validation)): ?>
                <div class="alert alert-danger" role='alert'>      
                <?= $validation->listErrors()?>
                </div>
            <?php endif; ?>  
        </div>
        <button type="submit" class="btn btn-primary ">Zmień</button>
    </form>
        <hr>
        <p>
        <a class="btn btn-light" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Pokaż kod</a>
        </p>
        <div class="row ">
            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <div class="card card-body">
                        <?php echo $code ?>
                    </div>
                </div>
            </div>
        </div>


     <form action='/calendar/edit' method='post' class='my-5 '>
        <div class="form-group">
            <h4>Usuń kalendarz</h4>
            <hr>
            <input type="hidden" class="form-control" name='delete' id="exampleInputEmail1" value ="1" >
        </div>
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