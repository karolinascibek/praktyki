
<div class="container-fluid p-0 ">
<div class="jumbotron ">
    <div class="d-flex-column justify-content-center text-center">
        <h2 class="display-4">Dołącz do Kalendarza!</h2>
        <p class="lead">Aby dołączyć należy podać kod.</p>
        <hr class="my-4">
        <p></p>


        <form class="form-inline justify-content-center" action='/dashboard' method='post'>
        <div class="form-group mx-sm-3 mb-2">
            <label for="code" class="sr-only">Kod</label>
            <input type="text" class="form-control"  name = 'code' id="code" placeholder="Kod">
            <input type="hidden" class="form-control"  name = 'id_employee' value='<?=$_SESSION['id']?>'>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Dołącz</button>
        </form>
        <div class="">
             <?php if(isset($validation)): ?>
                <div class="alert alert-danger" role='alert'>      
                   <?= $validation->listErrors()?>
                </div>
          <?php endif; ?>  
        </div>
  </div>
</div>

<div class="row justify-content-center my-3">
    </div>
    <div class="row justify-content-center">
        <div class="col-8 ">
            <div class="list-group">
                 <?php if(isset($calendars)): ?>
                    <button type="button" class="list-group-item list-group-item-action active">
                        Twoje Kalendarze
                    </button>
                
                    <?php $i = 1; ?>
                    <?php foreach($calendars as $calendar): ?>

                        <a href='<?=base_url()?>/dashboard/single_calendar/<?=$i?>' class="list-group-item list-group-item-action"><?php echo $calendar['name'] ?></a>
                    <?php $i++ ; ?>
                    <?php endforeach ?>
                <?php else:?>
                        Nie dołączyłeś do żadnego kalendarza.
                <?php endif;?>
            </div>
        </div>
    </div>
</div>