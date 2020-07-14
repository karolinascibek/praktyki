<div class='mx-3'>
    <h1>Edytuj </h1>

    <form action='/calendar/edit_employee' method='post'>
        <div class="form-group">
            <label for="exampleInputEmail1">Pula</label>
            <input type="text" class="form-control" name='pula' id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <form action='/calendar/edit_employee' method='post'>
        <div class="form-group">
            <label for="exampleInputEmail1">Usuń z listy</label>
            <input type="hidden" class="form-control" name='delete' id="exampleInputEmail1" value="<?php// echo $_SESSION['id_employee']?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>