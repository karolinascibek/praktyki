<?php

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 ">
            <h2>Wniosek o urlop</h2>
            <hr>
            <form action='/formPDF' method='post' >
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="inputState">Typ urlopu</label>
                        <select id="inputState" class="form-control" name='type'>
                            <option selected></option>
                            <option >wypoczynkowy</option>
                            <option>okazjonalny</option>
                            <option>macierzyński</option>
                        </select>
                    </div>
                </div>
            <h4>Od</h4>
            <hr>
            <div class="form-row pb-4">
                <div class="form-group col-2">
                    <label for="from_day">Dzień</label>
                    <input type="text" class="form-control" name='from_day' placeholder="dd" value="<?=set_value('from_day')?>">
                </div>
                <div class="form-group col-2">
                    <label for="from_month">Miesiąc</label>
                    <input type="text" class="form-control" name='from_month' placeholder="mm" value="<?=set_value('from_month')?>">
                </div>
                <div class="form-group col-2">
                    <label for="from_year">Rok</label>
                    <input type="text" class="form-control" name='from_year' placeholder="rrrr" value="<?=$year?>">
                </div>
            </div>
            <h4>Do</h4>
            <hr>
            <div class="form-row pb-2">
                <div class="form-group col-2">
                    <label for="to_day">Dzień</label>
                    <input type="text" class="form-control" name='to_day' placeholder="dd" value="<?=set_value('to_day')?>">
                </div>
                <div class="form-group col-2">
                    <label for="to_month">Miesiąc</label>
                    <input type="text" class="form-control" name='to_month' placeholder="mm"  value="<?=set_value('to_month')?>">
                </div>
                <div class="form-group col-2">
                    <label for="to_year">Rok</label>
                    <input type="text" class="form-control" name='to_year' placeholder="rrrr" value="<?=$year?>">
                </div>
            </div>
            <div class="row justify-content-center ">
                <div class="col-12">
                    <?php if(isset($validation)): ?>
                    <div class="alert alert-danger" role='alert'>
                        <?= $validation->listErrors()?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generuj</button>
            </form>
        </div>
    </div>
</div>