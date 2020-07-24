<?php

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 ">
            <h2>Wniosek o urlop</h2>
            <hr>
            <form action='/formPDF/generate_pdf' method='post' >
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="inputState">Typ urlopu</label>
                        <select id="inputState" class="form-control">
                            <option selected></option>
                            <option>Wypoczynkowy</option>
                            <option>Okazjonalny</option>
                            <option>Macierzyński</option>
                        </select>
                    </div>
                </div>
            <h4>Od</h4>
            <hr>
            <div class="form-row pb-4">
                <div class="form-group col-2">
                    <label for="inputAddress">Dzień</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="dd">
                </div>
                <div class="form-group col-2">
                    <label for="inputAddress2">Miesiąc</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="mm">
                </div>
                <div class="form-group col-2">
                    <label for="inputAddress2">Rok</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="rrrr">
                </div>
            </div>
            <h4>Do</h4>
            <hr>
            <div class="form-row pb-2">
                <div class="form-group col-2">
                    <label for="inputAddress">Dzień</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="dd">
                </div>
                <div class="form-group col-2">
                    <label for="inputAddress2">Miesiąc</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="mm">
                </div>
                <div class="form-group col-2">
                    <label for="inputAddress2">Rok</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="rrrr">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generuj</button>
            </form>
        </div>
    </div>
</div>