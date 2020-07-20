<div class="">
    <div class="jumbotron ">
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