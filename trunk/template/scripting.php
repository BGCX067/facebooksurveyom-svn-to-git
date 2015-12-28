<script> 
<!-- 

function boxDisplay(boxID) {
    var obj = boxID;    
    document.getElementById(obj).setStyle('display', '');
}

function boxHide(boxID) {
    var obj = boxID;    
    document.getElementById(obj).setStyle('display', 'none');   
}

function confirm(title, message) { 
    new Dialog().showMessage(title, message)
    return false;
}

function survey_validation (form) {
        
    var params=form.serialize();
    //var params=form;
    
    if (params.answer_name_217.checked == true) { 
        confirm('not good', 'not ok');
        //displayError("Error title", "Error message", textBox);
        return false;
    } else {
        confirm('ok', 'value ok');
        //displayError("Error title", "Error message", textBox);
        return false;     
    }
    
     confirm('not good', 'not ok'); 
    
}

function isDefined(variable)
{
    return eval('(typeof('+variable+') != "undefined");');
}


//--> 
</script> 
