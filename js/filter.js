$(document).ready(function () { 
       
    $("#txtInputTable").on("keyup", function () { 
        var value = $(this).val().toLowerCase();      
        $("#tableDetails tr").filter(function () { 
            $(this).toggle($(this).text() 
              .toLowerCase().indexOf(value) > -1) 
        }); 
    }); 
}); 

