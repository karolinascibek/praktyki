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
                            <div class="form-group mb-2 pr-1">
                            <label for="name" class="sr-only">Nazwa</label>
                                <input type="text" name='name' class="form-control" id="name" placeholder="Nazwa"  value="<?=set_value('name');?>">
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
        <div class="col-8  ">
            <div class="list-group py-2 border-bottom border-warning">
                <button type="button" class="list-group-item list-group-item-action active">
                    Twoje Kalendarze
                </button>
                <?php if(isset($calendars)): ?>
                    <?php $i = 1; ?>
                    <?php foreach($calendars as $calendar): ?>
                        <a href='<?=base_url()?>/Dashboard/single_calendar/<?=$i?>' class="list-group-item list-group-item-action"><?php echo $calendar->name ?></a>
                    <?php $i++ ; ?>
                    <?php endforeach ?>
                <?php endif;?>
            </div>
            
        </div>
    </div>
</div>