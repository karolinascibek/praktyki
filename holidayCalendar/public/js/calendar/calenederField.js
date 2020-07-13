const activFields = true;
const numberOfEmployees = number_of_employees;
const arrayChoiceDay = holidays_array;
const arrayDB = holidays_array_db;  // zawartoć z db

let dataToBeDeleted = [];
let dataToBeAdded = [];



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
                
                fields+= `<div id='${y}-${month +1 }-${(w+1)}' class='saturdayOrSunday'></div>`;
            }
            else{
                fields+= `<div id="${y}-${month +1 }-${(w+1)}" ></div>`;
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
    
    // wyswietlenie dni wolnych od pracy pobranych z bazy danych
    //console.log(calender2);
    displayFreeDays(calender2);
    //console.log(arrayChoiceDay);
    //showChoiceFields(holidays_array);
    //console.log(holidays_array);
    //aktywne pola kalendarza
    if(activFields === true){
        //po kliknieciu na pole zmieni się kolor
        changeFieldColor(calender,arrayChoiceDay);
            
        //showChoiceFields();
        //wyswietlenie zaznaczonych pol 
        showChoiceFields(arrayChoiceDay);

        const btn_save = document.querySelector('#btn-save-calendar');
        //porównanie tablic 
        btn_save.addEventListener('click',function(){
                    //const toAdd = [];  // tablica z obiektami do dodania do bazy danych 
                    //const toDelete = [];  // do susnięcy
                    //const tmp = [];
                
            console.log('jestem tu');
            createJSON();
            //console.log(document.writeln(JSON.stringify( dataToBeAdded)));
            console.log(arrayChoiceDay);
            jsToPhp(dataToBeDeleted, dataToBeAdded);
        });

    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//
//wyswietlenie dni wolnych od pracy 
//
const displayFreeDays =(calender)=>{
    const freedaysArray = nonWorkingDays(date);
    //console.log(freedaysArray);

    freedaysArray.forEach( day =>{
        // format daty dd-mm-rrrr 
        //format daty-rrrr-mm-dd
        let str = day.split('-');
        let dateWithArray = new Date(str[0],str[1],str[2]);
        if(dateWithArray.getMonth() - 1 === date.getMonth() && dateWithArray.getFullYear() === date.getFullYear()){
            //console.log(dateWithArray);
            //.${dateWithArray.getDate()}-${dateWithArray.getMonth()}-${dateWithArray.getFullYear()}
            let takeDiv = document.querySelectorAll(` .fieldsWorker .fieldDays [id='${dateWithArray.getFullYear()}-${dateWithArray.getMonth()}-${dateWithArray.getDate()}']`);

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

console.log(employees_array);
console.log(holidays_array_db);
const changeFieldColor =(calender,arrayChoiceDay)=>{
    calender.forEach(day =>{
        //wiersz
        //dni
            day.addEventListener('click', function(){
                let x = event.currentTarget.classList.toggle('choiceDay');
                //lista z identyfikatorami zaznaczonych pól
                let ob_day = {
                    id_row: day.parentNode.id,
                    id_day:  day.id,
                    id_user:'',
                    
                };
                //console.log(ob);
                if( !x ){
                    //usunięcie odkliknietego pola z tablicy
                    for(let i=0; i <  arrayChoiceDay.length; i++){
                        if(arrayChoiceDay[i].id_day == day.id && arrayChoiceDay[i].id_row == day.parentNode.id){
                            //deletedFields[deletedFields.length]=arrayChoiceDay[i];
                            arrayChoiceDay.splice(i,1);
                            break;
                        }
                    }
                }
                else{
                    //okreslamy z którego wiersza i kolumny pochodzi zaznaczone pole
                    //addFields[addFields.length]=ob_day;
                    arrayChoiceDay[ arrayChoiceDay.length] = ob_day;
                }
                
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
        let dateWithArray = new Date(str[0],str[1]-1  ,str[2]);
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
        `${year}-1-1`,
        `${year}-1-6`,
        `${year}-${easter.getMonth()+1}-${easter.getDate()}`,  // wielkanoc
        `${year}-${easterMonday.getMonth()+1}-${easterMonday.getDate()}`,  // poniedziałek wielkanocny
        `${year}-5-1`,  
        `${year}-5-3`,
        `${year}-${pentecost.getMonth()+1}-${pentecost.getDate()}`,  //zielone światki
        `${year}-${corpusChristi.getMonth()+1}-${corpusChristi.getDate()}`, // boże ciało
        `${year}-8-15`,
        `${year}-11-1`,
        `${year}-11-11`,
        `${year}-12-25`,
        `${year}-12-26`,
    ]
    //console.log(freeDays);
    return freeDays;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//porównanie tablicy pobranej z bazy danych z tablicą zaznaczonych pól

//
//buduje jsona do wyłania na backend , bedzie posaidał tablice dat usunietych ( które przyszły z bazy ale zostały odznaczone)
// i dodanych 
const createJSON = ()=>{
    //dane do dodania 
    const toAdd=[];

    //zawarte w choiceDay ale nie w holidays_array_db
    const inArrayChoiceDays=[];
    for(let i =0; i < arrayChoiceDay.length ; i++){
        let equal=false;
        for(let j =0; j < holidays_array_db.length ; j++){
            if(arrayChoiceDay[i].id_day === holidays_array_db[j].id_day  && arrayChoiceDay[i].id_row === holidays_array_db[j].id_row  ){
                equal = true;
                inArrayChoiceDays[inArrayChoiceDays.length] = arrayChoiceDay[i];
                break;
            }
        }
        if(!equal){
            toAdd[toAdd.length]=arrayChoiceDay[i];
        }
    }
    dataToBeAdded = toAdd;
    //dane do usuniecia w bazie danych 
    const toDelate=[];
    for(let i =0; i < holidays_array_db.length ; i++){
        let equal=false;
        for(let j =0; j < inArrayChoiceDays.length ; j++){
            if(inArrayChoiceDays[j].id_day === holidays_array_db[i].id_day  && inArrayChoiceDays[j].id_row === holidays_array_db[i].id_row  ){
                equal = true;
                break;
            }
        }
        if(!equal){
            toDelate[toDelate.length]=holidays_array_db[i];
        }
    }

    dataToBeDeleted = toDelate;

    // uzupelnienie obiektów znajdujących się w tablicy o wartośc atrybutu - id_user
    for(let i=0; i< employees_array.length; i++){
        for(let j=0; j< dataToBeDeleted.length; j++){
            if( employees_array[i].id_row === dataToBeDeleted[j].id_row){
                dataToBeDeleted[j].id_user = employees_array[i].id_user ;
                break;
            }
        }
        for(let j=0; j< dataToBeAdded.length; j++){
            if( employees_array[i].id_row === dataToBeAdded[j].id_row){
                dataToBeAdded[j].id_user = employees_array[i].id_user ;
                break;
            }
        }
    }
    console.log('dodane')
    console.log(dataToBeAdded);
    console.log('do usuniecia ');
    console.log(dataToBeDeleted);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

renderFieldsCalender(activFields, numberOfEmployees);