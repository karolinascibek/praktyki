const date = new Date();
const arrayChoiceDay = [] ;


///////////////////////////////////////////////////////////////////////////////////////////////////////////////

//
// wyswietlenie kalendarza
//
const renderCalender=()=>{

    const monthDays = document.querySelector('.days');
    const weekdays = document.querySelector('.weekdays');


    const weekdays_array = [
        'nd',
        'pn',
        'wt',
        'śr',
        'cz',
        'pt',
        'so',
    ]

    const months=[
        'Styczeń',
        'Luty',
        'Marzec',
        'Kwiecień',
        'Maj',
        'Czerwiec',
        'Lipiec',
        'Sierpień',
        'Wrzesień',
        'Październik',
        'Listopad',
        'Grudzień',

    ]


    //ustawiamy date na pierwszy dzień miesiąca
    date.setDate(1);
    //date.setMonth(11);

    //ustawienie bierzącego miesiaca 
    const year = date.getFullYear().toString()
    document.querySelector(".data h1").innerHTML = `${months[date.getMonth()]}  ${year}`;

    //którego dnia tygodnia rozpoczoł się bierzacy miesiąc
    const firstWeekdayMonth = date.getDay();
    const lenghtMonth = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();

    //dni tygodnia
    displayDaysOfTheWeek(date, weekdays , weekdays_array);

    // wyróznienie soboty i niedizeli 

    // dni miesiąca
    displayDaysOfTheMonth(monthDays,date);

}

//
//wyświetla dni tygodnia dla całego miesiąca
//
const displayDaysOfTheWeek =(date, weekdays , weekdays_array)=>{
    //dni tygodnia
    const lenghtMonth = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
    const firstWeekdayMonth = date.getDay();

    let idx = firstWeekdayMonth;
    let weekdays_conta = ""; 
    for(let w=0; w <  lenghtMonth ; w++){

        if( idx === 7){
            idx = 0;
        } 
        if( idx ===  0 || idx === 6){
            weekdays_conta += `<div class='saturdayOrSunday'>${weekdays_array[idx]}</div>`;
        }
        else{
            weekdays_conta += `<div>${weekdays_array[idx]}</div>`;
        }
        idx ++;

        weekdays.innerHTML = weekdays_conta;
    }
}

//
//wyświetlenie na kalendarzu wszystkich dni miesiąca 
//
const displayDaysOfTheMonth = ( monthDays ,date) => {
    const lenghtMonth = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
    // dni miesiąca
    let days = "";
    for(let i=1; i <= lenghtMonth; i++){
        //przypisanie dniom identyfikatora
        days+=`<div id="${i}-${date.getMonth()}-${date.getFullYear()}" >${i}</div>`;
        monthDays.innerHTML = days;
    }
    //console.log( monthDays);
} 




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// przesunięcie na poprzednie miesiące
document.querySelector(".prev").addEventListener("click", function(){
    date.setMonth(date.getMonth()-1);
    renderCalender();
    renderFieldsCalender(activFields, numberOfEmployees);
});

// przesunięcie na nastepne miesiące
document.querySelector(".next").addEventListener("click", function(){
    date.setMonth(date.getMonth()+1);
    renderCalender();
    renderFieldsCalender(activFields, numberOfEmployees);
   
});

renderCalender();


