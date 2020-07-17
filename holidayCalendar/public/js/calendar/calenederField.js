const activFields = isEmployer;
const numberOfEmployees = number_of_employees;
const arrayChoiceDay = holidays_array;
const arrayDB = holidays_array_db;  // zawartoć z db

console.log(arrayDB);

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
                
                fields+= `<div id='${y}-${month +1 }-${(w+1)}' class='saturdayOrSunday ' style="width: calc(100%/${daysMonth}");"></div>`;
            }
            else{
                fields+= `<div id="${y}-${month +1 }-${(w+1)}" style="width: calc(100%/${daysMonth});" ></div>`;
            }
            //calenderFields.innerHTML = fields;
            
            idx ++;
        }
    //
    //bedzie potrzebna liczba pracowników z bazy do petli aby wygeberować odpowiednio liczbę kratek
    //
     //lista pracowników
    const list = document.querySelector('.list');
    let row_list ='';
    let calenderFields = document.querySelector('.fieldsWorker');
    let fieldCalenderWorker = "";
    for(let fw=0; fw < numberOfEmployees; fw++)
    {
        //lisat pracowników
        if(activFields){
        row_list += '<div class="d-flex bd-highlight  border-top list-employees">'+
                        `<div class=" mr-auto  pl-2 name-and-last-name "> <a  href='${url}:8080/calendar/edit_employee'>${employees_array[fw].name} ${employees_array[fw].last_name}</a> </div>`+
                        `<div class=" bd-highlight   d-none d-lg-block  holidays pula ">${employees_array[fw].number_free_days} </div>`+
                        `<div class="bd-highlight   d-none d-lg-block diffrence_days holidays"> ${employees_array[fw].days_used}</div>`+
                        `<div class=" bd-highlight d-none   d-lg-block  holidays days-left">${employees_array[fw].number_free_days - employees_array[fw].days_used}</div>`+
                    `</div>`;
        list.innerHTML=row_list;
        }

        // pola kalendarza
        fieldCalenderWorker+=`<div id='${fw}' class='d-flex justify-content-between  fieldDays '  > ${fields}</div>`;
        calenderFields.innerHTML = fieldCalenderWorker;
    }

    const nameAndLastname = document.querySelectorAll('.name-and-last-name');
    //po kliknieciu przenosi na strone edycji pracownika
    // nameAndLastname.forEach(el=>{
    //     el.addEventListener('click',function(){
    //         console.log(`${url}/calendar/edit_employee`);
    //         let var_name = el.innerHTML;
    //         el.innerHTML = `<a href='${url}/calendar/edit_employee'>${var_name}`;
    //         console.log(var_name);
    //     });
    // })
    //pobieramy wszystkie pola kalendarza
    let calender = document.querySelectorAll(".fieldsWorker .fieldDays div");

    //dni wolne od pracy
    const calender2 = document.querySelectorAll('.fieldsWorker .fieldDays');
    //console.log(calender);
    
    // wyswietlenie dni wolnych od pracy pobranych z bazy danych
    //console.log(calender2);
    displayFreeDays(calender2);
    showChoiceFields(arrayChoiceDay);
    //console.log(arrayChoiceDay);
    //showChoiceFields(holidays_array);
    //console.log(holidays_array);
    //aktywne pola kalendarza


    if(activFields === true){
        //po kliknieciu na pole zmieni się kolor
        changeFieldColor(calender,arrayChoiceDay);
            
        //showChoiceFields();
        //wyswietlenie zaznaczonych pol 
        //showChoiceFields(arrayChoiceDay);
        createJSON();
        //console.log(arrayChoiceDay);
        //console.log(dataToBeAdded);
        //console.log(dataToBeDeleted);
        const btn_save = document.querySelector('#btn-save-calendar');
        //przesłanie tablicy za pomocą formularza
        document.querySelector('#btn-save-calendar').addEventListener('click',function(){
            createJSON();
            // const array = {
            //     'deleted': dataToBeDeleted,
            //     'added': dataToBeAdded
            // }
            const inp = document.querySelector('#hidden');
            inp.setAttribute("value", JSON.stringify(
                {
                    'deleted': dataToBeDeleted,
                    'added': dataToBeAdded
                }
            ));
            //console.log('hidden input');
            console.log(inp);
        })
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

//console.log(employees_array);
//console.log(holidays_array_db);
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
            //console.log(arrayChoiceDay);
        });
        console.log('wybory');
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
    console.log(arrayChoiceDay);
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

    console.log('dodane')
    console.log(dataToBeAdded);
    console.log('do usuniecia ');
    console.log(dataToBeDeleted);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
renderFieldsCalender(activFields, numberOfEmployees);