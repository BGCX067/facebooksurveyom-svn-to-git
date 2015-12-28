<!--
function showFilled(Value) {
if(Value>9)

{

return Value; 

}

else{

return '0'+Value; 

} 

}
function StartClock24() {
  TheTime = new Date;
  document.getElementById('time').innerHTML = '<b>'+showFilled(TheTime.getHours()) + ":" + showFilled(TheTime.getMinutes()) + ":" + showFilled(TheTime.getSeconds());
  setTimeout("StartClock24()",1000)
}
//-->