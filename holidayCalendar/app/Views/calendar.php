<script>
let number_of_employees =  <?php echo count($employees);?>;
console.log(number_of_employees);
</script>

<div class="calendar-main ">
    <div class='row  mt-3 mr-5 ml-5 d-flex text-center  '>
    <h1> <?=esc($title)?></h1>
    </div>
    <div class="row m-5 mt-0 ">
        <!-- kalendarz -->
        <div class="col-lg-12  calendar">
            <!-- Nagłówek kalendarza-->
            <div class="row justify-content-end ">
                <div class=" col-lg-8  col-9 bg-info month ">
                    <div class="d-flex justify-content-between align-items-center">
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
            <div class="row justify-content-end">
                <div class="col-lg-4  col-3  bg-warning">
                    cos tam 
                </div>
                <div class="col-lg-8  col-9 bg-success">
                    <div class="d-flex justify-content-between days">
                                         
                    </div>   
                </div>  
            </div> 

            <!-- dni dwie kolumny z lista pracowników i polami kalendarza -->
            <div class="row ">
                 <!-- nagłowek dla pracowników -->
                 <div class="col-lg-4 col-3 bg-warning" >                      
                        <div class="d-flex bd-highlight  ">
                            <div class=" mr-auto bd-highlight ">  Lista pracowników </div>
                            <div class=" bd-highlight bg-warning border-left holidays d-none d-lg-block"> D</div>
                            <div class="bd-highlight holidays border-left d-none d-lg-block">W</div>
                            <div class=" bd-highlight bg-warning border-left  holidays">Z</div>
                        </div>
                </div>
                <!-- dni tygodnia -->
                <div class="col-lg-8 col-9 bg-warning">
                    <div class="d-flex justify-content-between weekdays"> 
                           
                    </div>
                </div>
            </div>
            
            <div class="row">
                 <!-- lista pracowników -->
                <div class="col-lg-4 col-3  bg-dark" >
                    
                    <?php foreach($employees as $emp):?>
                    <div class="d-flex bd-highlight hol ">
                        <div class=" mr-auto bd-highlight ">  <?=$emp['name'] .' '. $emp['last_name'] ?> </div>
                        <div class=" bd-highlight bg-success holidays d-none d-lg-block"> <?=$emp['number_free_days']?></div>
                        <div class="bd-highlight holidays d-none d-lg-block"><?=$emp['number_free_days'] - $emp['days_used'] ?></div>
                        <div class=" bd-highlight bg-primary holidays"><?=$emp['days_used']?></div>
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
    <div class='row '></div>
    
</div>
<?php  var_dump($employees) ?>


klkl
<script src='../js/calendar/calendarHorizontal.js'> </script>
<script src='../js/calendar/calenederField.js'> </script> 


