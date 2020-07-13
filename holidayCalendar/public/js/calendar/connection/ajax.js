
const jsToPhp =(dataToBeDeleted, dataToBeAdded)=>{
            event.preventDefault();       
            $.ajax(
                {
                    type:"post",
                    url: `${url}/Calendar/index`,
                    data : JSON.stringify({
                        "deleted_days" : dataToBeDeleted, 
                        "added_days" :dataToBeAdded
                    }),
                    contentType : "application/json",
                    dataType   : "json",
                    success    : function( returnedJson ){
                        console.log("Pure jQuery Pure JS object");
                        console.log( returnedJson );
                    },
                    error:function() 
                    {
                        alert("Invalide!");
                        console.log(url);
                    }
                }
            );
            // axios.post(`${url}/calendar`,, {
            //     firstName: 'Fred',
            //     lastName: 'Flintstone'
            //   })
            //   .then(function (response) {
            //     console.log(response);
            //   })
            //   .catch(function (error) {
            //     console.log(error);
            //   });
           
}




