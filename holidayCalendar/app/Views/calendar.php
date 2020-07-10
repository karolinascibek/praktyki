
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
                 <div class="col-lg-4 col-3 bg-dark" >
                    <div class="row">
                       
                        <div class="col-lg-6 col-10 bg-primary workers">
                            lista pracowników
                        </div>
                        <div class="col-lg-2 col-2  d-none d-lg-block bg-dark holidays">
                            D
                        </div>
                        <div class="col-lg-2 col-2  d-none d-lg-block bg-primary holidays">
                            W
                        </div>
                        <div class="col-lg-2 col-2  bg-dark holidays">
                            Z
                        </div>
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
                    <div class="row">
                       
                        <div class="col-lg-6 col-10 bg-primary workers">
                           Jan kowaski
                        </div>
                        <div class="col-lg-2 col-2  d-none d-lg-block bg-success holidays">
                            20
                        </div>
                        <div class="col-lg-2 col-2  d-none d-lg-block bg-primary holidays">
                            3
                        </div>
                        <div class="col-lg-2 col-2   bg-success holidays">
                            19
                        </div>
                    </div>
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
<script src='js/calendar/calendarHorizontal.js'> </script>
<script src='js/calendar/calenederField.js'> </script>


