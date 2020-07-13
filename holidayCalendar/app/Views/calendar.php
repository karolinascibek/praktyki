<?php 

    $data=[];
    if( isset($employees)){   
        $data = $employees;
    } 
    $holidays_array=[];
    if( isset($holidays)){   
        $holidays_array=$holidays;
    } 
 
 ?>


<script>
    let number_of_employees =  <?php  echo count($data);?>;
        //console.log(number_of_employees);

        let holidays_array =  <?php echo json_encode($holidays_array);?>;
        let holidays_array_db =  <?php echo json_encode($holidays_array);?>;
        let employees_array =  <?php echo json_encode($data);?>;
        //console.log(holidays_array);
    
    let url = '<?php echo base_url(); ?>';
    console.log(url);
</script>


<div class="calendar-main ">
    <div class='row  mt-3 mr-5 ml-5 d-flex text-center  '>
    <h1> <?=esc($title)?></h1>
    </div>
    <div class="row mx-5 mt-0 mb-3">
        <!-- kalendarz -->
        <div class="col-lg-12  calendar">
            <!-- Nagłówek kalendarza-->
            <div class="row justify-content-end ">
                <div class=" col-lg-8  col-9 bg-info month ">
                    <div class="d-flex justify-content-between  py-2 align-items-center">
                        <!-- prev-->
                        <i class="fas fa-angle-left  prev "></i>
                        <div class="data">
                            <h1>May</h1>
                        </div>
                         <!-- next -->
                        <i class="fas fa-angle-right next"></i>
                    </div>
                </div>
            </div>

            <!-- dni miesiąca -->
            <div class="row justify-content-end ">
                <div class="col-lg-4  col-3  ">

                </div>
                <div class="col-lg-8 bg-success  col-9 month-days-header">
                    <div class="d-flex justify-content-between days">
                                         
                    </div>   
                </div>  
            </div> 

            <!-- dni dwie kolumny z lista pracowników i polami kalendarza -->
            <div class="row ">
                 <!-- nagłowek dla pracowników -->
                 <div class="col-lg-4 col-3 bg-info " >                      
                        <div class="d-flex bd-highlight  ">
                            <div class=" mr-auto bd-highlight  ">  Imie i nazwisko </div>
                            <div class=" bd-highlight  border-left holidays d-none d-lg-block"> D</div>
                            <div class="bd-highlight holidays border-left d-none d-lg-block">W</div>
                            <div class=" bd-highlight  border-left d-none d-lg-block holidays">Z</div>
                        </div>
        
                </div>
                <!-- dni tygodnia -->
                <div class="col-lg-8 col-9 bg-warning month">
                    <div class="d-flex justify-content-between weekdays"> 
                           
                    </div>
                </div>
            </div>
            
            <div class="row">
                 <!-- lista pracowników -->
                <div class="col-lg-4 col-3  hol " >
                    
                    <?php
                    foreach($data as $emp):?>
                    <div class="d-flex bd-highlight border-top">
                        <div class=" mr-auto bd-highlight  list-employees"> 
                            <form action="/calendar/edit_employee" method='post'>   
                                    <input id="prodId" name="id_employee" type="hidden" value="<?php echo $emp['id_user']; ?>">
                                    <button type="submit" class="btn my-btn"><?php echo $emp['name'].' '.$emp['last_name']; ?></button>
                             <form>
                        </div>
                        
                        <div class=" bd-highlight  holidays d-none d-lg-block"> <?=$emp['number_free_days'] ?></div>
                        <div class="bd-highlight holidays d-none d-lg-block"> <?=$emp['days_used']?> </div>
                        <div class=" bd-highlight d-none d-lg-block  holidays"><?=$emp['number_free_days'] - $emp['days_used']?></div>
                    </div>
                    <?php endforeach;?>
                   
                </div>
                <!-- pola do wyboru -->
                <div class="col-lg-8 col-9 bg-danger fieldsWorker">
                    <div class="d-flex justify-content-between fieldDays"> 
                            
                    </div>
                </div>         
            </div>
             <!-- koniec kalendarza -->
        </div>
    </div>
    <div class="row mx-5  my-3">
        <!-- <div class="col-12"> -->
            <button id='btn-save-calendar' type="button" class="btn btn-primary btn-lg btn-block ">Zapisz</button>
        <!-- </div> -->
    </div>
    <div class="ok"></div>
    
</div>


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src='../js/calendar/calendarHorizontal.js'> </script>
<script src='../js/calendar/calenederField.js'> </script> 
<script src='../js/calendar/connection/ajax.js'> </script> 





