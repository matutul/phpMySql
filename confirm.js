changeslot();
function changeslot(){
    var slotChange = confirm("You are already registered. Do you want to change slot and other informations?");
    if(slotChange){
        window.location = 'slotChange.php';
    }
}