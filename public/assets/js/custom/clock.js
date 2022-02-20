setInterval(function() {

    let currentTime = new Date();
    let hours = currentTime.getHours();
    let minutes = currentTime.getMinutes();
    let seconds = currentTime.getSeconds();

    let ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    // Add leading zeros
    // hours = (hours < 10 ? "0" : "") + hours;
    hours = hours ? hours : 12;
    hours = hours < 10?'0'+hours:hours
    minutes = (minutes < 10 ? "0" : "") + minutes;
    seconds = (seconds < 10 ? "0" : "") + seconds;

    // Compose the string for display
    let currentTimeString = hours + ":" + minutes + ":" + seconds +' '+ ampm;
    $(".clock").html(currentTimeString);

}, 1000);
//for showing day name

