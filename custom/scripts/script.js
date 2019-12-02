$(document).ready(function()
{
    // clock in the menu bar
    updateClock(); 

    // chosen
    $(".chosen").chosen();


});

function updateClock() 
{
    var now = new Date(); // current date
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]; // you get the idea
    var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    var hours = String(now.getHours()); 
    var mins = String(now.getMinutes()); 
    var secs = String(now.getSeconds()); 
    var time = hours.padStart(2,"0") + ":" + mins.padStart(2,"0") + ":" + secs.padStart(2,"0"); // again, you get the idea

    var dates = String(now.getDate());
    var datetime = days[now.getDay()] + ", " + months[now.getMonth()] + " " + dates.padStart(2,"0") + " @ " + time; 


    // set the content of the element with the ID time to the formatted string
    document.getElementById("menu_datetime").innerHTML = datetime; 

    // call this function again in 1000ms
    setTimeout(updateClock, 1000);
}