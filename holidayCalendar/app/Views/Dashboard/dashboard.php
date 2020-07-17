<div class='mx-3 my-3'>
    <div class="row justify-content-center">
        <div class="cal-8 ">
            <h1>  Dzień dobry  <?=$_SESSION['name']?>! </h1>
        </div>
    </div>
    <br>
    <div class='row justify-content-center'>
        <div class="col-8 ">
            <div class="row d-flex justify-content-center text-center">                
                <div class="col-6">
                    <p>Stwórz nowy kalendarz <p> 
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <form class="form-inline justify-content-center" action='/dashboard' method='post'>
                            <div class="form-group mb-2">
                            <label for="name" class="sr-only">Nazwa</label>
                                <input type="text" name='name' class="form-control" id="name" placeholder="Nazwa"   ?>'>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="code" class="sr-only">Nazwa</label>
                                <input type="text" name='code' class="form-control" id="code" placeholder="Kod dostępu" >
                                <button type="button" class="btn btn-sm" data-toggle="tooltip" data-placement="bottom" title="
                                Kod ustalsz sam, nastepnie udostępnij go pracownikom aby mogli dołączyć do kalendarza.">
                                <i class="far fa-question-circle"  id='info'style="font-size: 1.1rem;"></i></button>
                                </button>
                                <script> 
                                    $('#info').tooltip(options)
                                </script>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Dodaj</button>        
                    </form>
            <div class="row justify-content-center">
                 <div class="col-lg-6">
                   <?php if(isset($validation)): ?>
                        <div class="alert alert-danger" role='alert'>      
                           <?= $validation->listErrors()?>
                        </div>
                   <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    <div class="row justify-content-center">
        <div class='col-8'>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8 ">
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action active">
                    Twoje Kalendarze
                </button>
                <?php if(isset($calendars)): ?>
                    <?php $i = 1; ?>
                    <?php foreach($calendars as $calendar): ?>
                        <a href='<?=base_url()?>/Dashboard/mycalendar/<?=$i?>' class="list-group-item list-group-item-action"><?php echo $calendar->name ?></a>
                    <?php $i++ ; ?>
                    <?php endforeach ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>