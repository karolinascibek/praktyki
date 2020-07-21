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
 
 ?>
<script>
    let number_of_employees =  <?php  echo count($data);?>;
    console.log(number_of_employees);
    let isEmployer = <?php echo $isEmployer?>;
    if(isEmployer){
        isEmployer = true;
    }
    else{
        isEmployer = false;
    }
    console.log(isEmployer);
        let holidays_array =  <?php echo json_encode($holidays_array);?>;
        let holidays_array_db =  <?php echo json_encode($holidays_array);?>;
        let employees_array =  <?php echo json_encode($data);?>;
        //console.log(holidays_array);
        console.log(employees_array);
    let url = '<?php echo base_url(); ?>';
    console.log(url);
</script>


<div class="calendar-main  ">
    <div class='mx-5  my-3  d-flex justify-content-between   '>
        <div class="">  <h1> <?=esc($title)?></h1>  </div>
        <div class=""> <a href="/calendar/edit"> <i class="fas fa-cog"></i>  </a> </div>
        
    </div>
    <hr>
    <div class="row mx-5 mt-0 mb-3">
        <!-- kalendarz -->
        <div class="col-lg-12  calendar">
            <!-- Nagłówek kalendarza-->
            <div class="row justify-content-end ">
                <div class=" col-lg-8  col-9 bg-light month ">
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
                <div class="col-lg-4  col-3  ">

                </div>
                <div class="col-lg-8 bg-success  col-9 m-0 p-0  month-days-header">
                    <div class="d-flex justify-content-between days">
                                         
                    </div>   
                </div>  
            </div> 

            <!-- dni dwie kolumny z lista pracowników i polami kalendarza -->
            <div class="row ">
                 <!-- nagłowek dla pracowników -->
                 <div class="col-lg-4 col-3 bg-info p-0" >                      
                        <div class="d-flex justify-content-between  header bd-highlight   ">
                            <div class="mr-auto bd-highlight pl-2 d-flex text-center">  Imie i nazwisko </div>
                            <div class="bd-highlight border-left border-right border-dark d-none d-lg-block  holidays"> P</div>
                            <div class="bd-highlight  border-right border-dark  d-none d-lg-block holidays">W</div>
                            <div class="bd-highlight  d-none d-lg-block holidays">Z</div>
                        </div>
        
                </div>
                <!-- dni tygodnia -->
                <div class="col-lg-8 col-9 bg-warning m-0 p-0 border-top border-dark month">
                    <div class="d-flex justify-content-between weekdays"> 
                           
                    </div>
                </div>
            </div>
            
            <div class="row border-bottom">
                 <!-- lista pracowników -->
                <div class="col-lg-4 col-3  hol list  p-0 pl" >
                    
                    <?php $i=1;
                    foreach($data as $emp):?>
                    <div class="d-flex bd-highlight  border-top list-employees">
                        <div class=" mr-auto  pl-2 name-and-last-name ">  
                            <input id="prodId" name="id_employee" type="hidden" value="<?php echo $emp['id_user']; ?>">
                            <a  class="" href='<?php echo base_url()?>/calendar/edit_employee/<?=$i?>' ><?php echo $emp['name'].' '.$emp['last_name']; ?></a>
                        </div>
                        
                        <div class=" bd-highlight   d-none d-lg-block  holidays pula"> <?php echo $emp['number_free_days'] ?></div>
                        <div class="bd-highlight   d-none d-lg-block diffrence_days holidays"> <?php echo $emp['days_used']?> </div>
                        <div class="bd-highlight d-none   d-lg-block  holidays days-left"><?php echo $emp['number_free_days'] - $emp['days_used']?></div>
                    </div>
                    <?php $i++;?> 
                    <?php endforeach;?> 
                    <!-- <div class="d-flex bd-highlight border-top list-employees">
                        <div class=" mr-auto bd-highlight name-and-last-name ">  
                            Lista pracownikow
                            <input id="prodId" name="id_employee" type="hidden" value="<?php //echo $emp['id_user']; ?>">
                            <a  class="btn my-btn " href='<?php //echo base_url()?>/calendar/edit_employee' >lista prac </a>
                        </div>
                        
                        <div class=" bd-highlight  holidays d-none d-lg-block pula "> 12</div>
                        <div class="bd-highlight holidays d-none d-lg-block diffrence_days"> 2 </div>
                        <div class=" bd-highlight d-none d-lg-block  holidays days-left">10</div>
                    </div> -->
                    
                   
                </div>
                <!-- pola do wyboru -->
                <div class="col-lg-8 col-9 bg-dark  m-0 p-0 fieldsWorker">
                    <div class="d-flex justify-content-between  border-top border-dark fieldDays "> 
                            
                    </div>
                </div>         
            </div>
             <!-- koniec kalendarza -->
        
        </div>
    </div>
    <br>
    <hr>
    <div class="row mx-5  my-5   d-flex justify-content-end button-save">
        <div class="col-12 p-0 " >
            <form action="/calendar"  class='justify-content-end ' method='post'>
                <input id="hidden" name="array" type="hidden" value="xm234jq">
                <button id='btn-save-calendar' type="submit" class="btn btn-primary btn-lg  "> Zapisz </button>    
            </form>          
        </div>
    </div>

</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src='../js/calendar/calendarHorizontal.js'> </script>
<script src='../js/calendar/calenederField.js'> </script> 