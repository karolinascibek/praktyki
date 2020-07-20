<?php 

    $data=[];
    if( isset($employees)){   
        $data = $employees;
    } 
    $holidays_array=[];
    if( isset($holidays)){   
        $holidays_array=$holidays;
    } 
    $isEmployer = $_SESSION['isEmployer'];
    if(!$isEmployer){
        $isEmployer = 0;
    }
    else{
        $isEmployer = 1;
    }
    //var_dump($data);
 ?>
<script>
    let number_of_employees =  <?php  echo count($data);?>;
    let isEmployer = <?php echo $isEmployer?>;
    if(isEmployer){
        isEmployer = true;
    }
    else{
        isEmployer = false;
    }
    let holidays_array =  <?php echo json_encode($holidays_array);?>;
    let holidays_array_db =  <?php echo json_encode($holidays_array);?>;
    let employees_array =  <?php echo json_encode($data);?>;
    let url = '<?php echo base_url(); ?>';
</script>


<div class="calendar-main  ">
    <div class='row   mx-5  my-3  '>

        <h1> <?=esc($title)?></h1>
    </div>
    <div class='row   mx-5  my-3  justify-content-between  '>
        <div class="col-11">
         <p> Właściciel: <?php echo $owner_calendar?></p>
        </div>
        <div class="col-1">
           
        </div>
    </div>
    <hr>
    <div class="row mx-5 mt-0 mb-3">
        <!-- kalendarz -->
        <div class="col-lg-12  calendar pb-2">
            <!-- Nagłówek kalendarza-->
            <div class="row justify-content-end ">
                <div class=" col-lg-12 bg-light month ">
                    <div class="d-flex justify-content-between  py-2 align-items-center">
                        <!-- prev-->
                        <i class="fas fa-angle-left  prev "></i>
                        <div class="data ">
                            <h1> </h1>
                        </div>
                         <!-- next -->
                        <i class="fas fa-angle-right next"></i>
                    </div>
                </div>
            </div>

            <!-- dni miesiąca -->
            <div class="row justify-content-end ">
                <!-- <div class="col-lg-4  col-3  ">

                </div> -->
                <div class="col-lg-12 bg-success m-0 p-0  month-days-header">
                    <div class="d-flex justify-content-between days">
                                         
                    </div>   
                </div>  
            </div> 

            <!-- dni dwie kolumny z lista pracowników i polami kalendarza -->
            <div class="row  ">
                <!-- dni tygodnia -->
                <div class="col-lg-12 col-12 bg-warning m-0 p-0 border-top border-dark month">
                    <div class="d-flex justify-content-between weekdays"> 
                           
                    </div>
                </div>
            </div>
            
            <div class="row border-top border-dark">
                <div class="col-12 bg-light py-1">
                </div>
            </div>

            <div class="row border-bottom border-dark ">
                <!-- pola do wyboru -->
                <div class="col-lg-12 col-12 bg-dark  m-0 p-0 fieldsWorker">
                    <div class="d-flex justify-content-between  border-top border-dark  fieldDays " style="height: 10px;"> 
                            
                    </div>
                </div>         
            </div>
            <div class="row">
                <div class="col-12 bg-light py-5">
                </div>
            </div>
            <div class="row">
                <div class="col-12 py-2 px-0">
                    <div class="row px-3">
                        <div class="col-6">
                            <div class="row py-2">
                                <div class="col-1 red colors">  </div>
                                <div class="col-5">- Urlop</div>

                                <div class="col-1 pink colors"></div>
                                <div class="col-5">- Sobota/Niedziela</div>
                            </div>
                            <div class="row py-2 ustify-content-start">
                                <div class="col-1 dark colors"></div>
                                <div class="col-5 "> - Dni robocze</div>
                                <div class="col-1 purple colors"> </div>
                                <div class="col-5"> - Dni wolne od pracy</div>
                            </div>
                        </div>
                        <div class="col-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Pula</th>
                                    <th scope="col">Wykożystane</th>
                                    <th scope="col">Zostalo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php if(isset($employees)):?>
                                    <th id='pula'><?php echo $employees[0]['number_free_days']?></th>
                                    <td><?php echo $employees[0]['days_used']?></td>
                                    <td><?php echo $employees[0]['number_free_days'] - $employees[0]['days_used']?></td>
                                <?php endif;?>
                                </tr>
                            </tbody>
                            </table>
                      
                        </div>
                       
                     </div>
                </div>
             <!-- koniec kalendarza -->
            </div>
        </div>
    </div>
    <hr>
     <div class="row py-2 mx-5 justify-content-end">
        <div class="col-6">
                     
            <form class="form-inline justify-content-end" action='/calendar/mycalendar' method='post'>
            <div class="form-group mx-sm-3 mb-2 ">
                <label for="inputPassword2" class=""></label>
                <input type="text" class="form-control" id="inputPassword2" name='pula' placeholder="Podaj liczbę dni">
            </div>
            <button type="submit" id='edit'class="btn btn-outline-primary mb-2 ">Zmień</button>
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
    <br>
    <hr>
    
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src='../js/calendar/calendarHorizontal.js'> </script>
<script src='../js/calendar/calenederField.js'> </script> 
<script src='../js/calendar/connection/ajax.js'> </script> 