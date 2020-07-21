<div class="">
    <div class="jumbotron ">
    <div class='d-flex justify-content-end '> 
        <form action="/calendar/delete_empty_calendar" method='post'>
            <button type="button" id= 'btn-delete' class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" ><i class="fas fa-trash-alt"></i></button>
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
    <div class='d-flex-column justify-content-center text-center'>
        <h2 class="display-4">Nikt jeszcze nie dołączył do twojego kaledarza!</h2>
        <h2 class="display-4">:-(</h2>
        <hr class="my-4">
        <p>Udostępnij kod swoim pracownikom aby mogli dołączyć do tego kalendarza.</p>
        <div class="">
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Zobacz kod</button>
            </p>
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body ">
                            <?php if(isset($code)):?>
                            <h3><?php echo $code; ?></h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
    </div>
    </div>

    
</div>