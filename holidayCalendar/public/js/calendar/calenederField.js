const activFields = true;
const numberOfEmployees = number_of_employees;
const arrayChoiceDay = holidays_array;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
const renderFieldsCalender=(activFields, numberOfEmployees)=>{


    date.setDate(1);
    const weekdays = date.getDay();

    let daysMonth = new Date(date.getFullYear(), date.getMonth()+1,0).getDate();

    let fields = ""; 
    let idx=weekdays;
    // przydzielenie odpowienich kolorów polu z kalendarza
        for(let w=0; w <  daysMonth ; w++){

            if( idx === 7){
                idx = 0;
            } 
            let month = date.getMonth()
            let y = date.getFullYear()
            //niedziele i soboty
            if( idx ===  0 || idx === 6){
                
                fields+= `<div id='${(w+1)}-${month}-${y}' class='saturdayOrSunday'></div>`;
            }
            else{
                fields+= `<div id="${(w+1).toString()}-${month}-${y}" ></div>`;
            }
            //calenderFields.innerHTML = fields;
            idx ++;
        }
            
    let calenderFields = document.querySelector('.fieldsWorker');
    let fieldCalenderWorker = "";


    //
    //bedzie potrzebna liczba pracowników z bazy do petli aby wygeberować odpowiednio liczbę kratek
    //
    for(let fw=0; fw < numberOfEmployees; fw++)
    {
        fieldCalenderWorker+=`<div id='${fw}' class='d-flex justify-content-between fieldDays'> ${fields}</div>`;
        calenderFields.innerHTML = fieldCalenderWorker;
    }

    //pobieramy wszystkie pola kalendarza
    let calender = document.querySelectorAll(".fieldsWorker .fieldDays div");

    //dni wolne od pracy
    const calender2 = document.querySelectorAll('.fieldsWorker .fieldDays');
    //console.log(calender);
    
    // wyswietlenie dni wolnych od pracy
    displayFreeDays(calender2);

    showChoiceFields(holidays_array);
    console.log(holidays_array);
    //aktywne pola kalendarza
    if(activFields === true){
        //po kliknieciu na pole zmieni się kolor
        changeFieldColor(calender,arrayChoiceDay);
            
        //showChoiceFields();
        //wyswietlenie zaznaczonych pol 
        showChoiceFields(arrayChoiceDay);
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//
//wyswietlenie dni wolnych od pracy 
//
const displayFreeDays =(calender)=>{
    const freedaysArray = nonWorkingDays(date);

    freedaysArray.forEach( day =>{
        // format daty dd-mm-rrrr 
        let str = day.split('-');
        let dateWithArray = new Date(str[2],str[1]-1,str[0]);
        if(dateWithArray.getMonth() === date.getMonth() && dateWithArray.getFullYear() === date.getFullYear()){
            //console.log(dateWithArray);
            //.${dateWithArray.getDate()}-${dateWithArray.getMonth()}-${dateWithArray.getFullYear()}
            let takeDiv = document.querySelectorAll(` .fieldsWorker .fieldDays [id='${dateWithArray.getDate()}-${dateWithArray.getMonth()}-${dateWithArray.getFullYear()}']`);

            takeDiv.forEach( day =>{
                day.classList.add('freeDay');
                //console.log(day);
            });
            //console.log(takeDiv);
            //takeDiv.classList.add('choiceDay');
        }
        //console.log( day);
    })
}

//
// zmiana kolor dla wybranego pola i zapisnie go w tablicy
//
const changeFieldColor =(calender,arrayChoiceDay)=>{
    calender.forEach(day =>{
        //wiersz
        //dni
            day.addEventListener('click', function(){
                let x = event.currentTarget.classList.toggle('choiceDay');
                //lista z identyfikatorami zaznaczonych pól
                const ob_day = {
                    id_day:day.id,
                    id_row:day.parentNode.id,
                };
                if( !x ){
                    //usunięcie odkliknietego pola z tablicy
                    for(let i=0; i <  arrayChoiceDay.length; i++){
                        if(arrayChoiceDay[i].id_day == day.id && arrayChoiceDay[i].id_row == day.parentNode.id){
                            arrayChoiceDay.splice(i,1);
                            break;
                        }
                    }
                }
                else{
                    //okreslamy z którego wiersza i kolumny pochodzi zaznaczone pole

                    arrayChoiceDay[ arrayChoiceDay.length] = ob_day;
                }
                console.log(arrayChoiceDay);
            });
        });
}



//
// wyswietlenie pol zaznaczonych w kalendarzu 
//
const showChoiceFields=( arrayChoiceDay)=>{
    //pola zaznaczone w kalendarzu ale jeszcze nie zapisane -> podaczas przełączania 
    // na inny miesiąc tracimy zaznaczone pola, aby ich nie stracić nadpisujemy tablice która przechowuje 
    // te pola

    arrayChoiceDay.forEach( ob_day => {
        //let strToDate = `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
        //zmieniamy id obiektu na typ data

        // format daty dd-mm-rrrr 
        let str = ob_day.id_day.split('-');
        let dateWithArray = new Date(str[2],str[1]  ,str[0]);
        if(dateWithArray.getMonth()  === date.getMonth() && dateWithArray.getFullYear() === date.getFullYear()){
            //console.log(dateWithArray);
            //.${dateWithArray.getDate()}-${dateWithArray.getMonth()}-${dateWithArray.getFullYear()}
            let takeDiv = document.querySelector(`[id = "${ob_day.id_row}"] [id = "${ob_day.id_day}"]`);
            //console.log(takeDiv);
            takeDiv.classList.add('choiceDay');
        }
        
    });
}


///////////////////////////////////// wyznaczenie dni wolnych od pracy /////////////////////
//
// funkcja obliczająca kiedy wypada wielkanoc
//

const whenIsEaster=(date)=>{
    let year = date.getFullYear();
    let a = year % 19;
    let b = parseInt( year / 100 );
    let c = year % 100;
    let d = parseInt(b/4);
    let e = b % 4;
    let f = parseInt( (b+8) / 25 );
    let g = parseInt( (b-f+1)/3);
    let h = ( 19*a+b-d-g+15) % 30;
    let i = parseInt( c / 4);
    let k = c % 4;
    let l = ( 32+2*e+2*i-h-k) % 7;
    let m = parseInt( (a+11+h+22*l) / 451);
    let p = ( h + l - 7*m + 114 ) %  31;

    //dzień
    p = p+1;

    //miesiąc
    n = parseInt( (h+l-7*m+114)/31 );

    let easter = new Date(date.getFullYear(), n-1 , p);
    //console.log( easter);
    return  easter; 
}

const nonWorkingDays = (date) =>{
    //wielkanoc
    const easter = whenIsEaster(date);

    // poniedziałek wielkanocny
    const easterMonday = new Date(easter.getFullYear(), easter.getMonth(), easter.getDate()+1);

    //Zielone Światki 
    const pentecost = new Date(easter.getFullYear(), easter.getMonth(), easter.getDate()+49);

    //Boże Ciało
    const corpusChristi = new Date(easter.getFullYear(), easter.getMonth(), easter.getDate()+60);
    
    const year = date.getFullYear();
    const freeDays = [
        `1-1-${year}`,
        `6-1-${year}`,
        `${easter.getDate()}-${easter.getMonth()+1}-${year}`,  // wielkanoc
        `${easterMonday.getDate()}-${easterMonday.getMonth()+1}-${year}`,  // poniedziałek wielkanocny
        `1-5-${year}`,  
        `3-5-${year}`,
        `${pentecost.getDate()}-${pentecost.getMonth()+1}-${year}`,  //zielone światki
        `${corpusChristi.getDate()}-${corpusChristi.getMonth()+1}-${year}`, // boże ciało
        `15-8-${year}`,
        `1-11-${year}`,
        `11-11-${year}`,
        `25-12-${year}`,
        `26-12-${year}`,
    ]
    //console.log(freeDays);
    return freeDays;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

renderFieldsCalender(activFields, numberOfEmployees);