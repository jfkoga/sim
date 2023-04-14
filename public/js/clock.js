console.log(timeLimit);

// Set the date we're counting down to
let countDownDate = new Date(timeLimit).getTime();

// Initialize message var
let message;

// DOM
let countdown = document.getElementById('clock');
const buttons = document.getElementsByTagName('button');
let form = document.getElementsByTagName('form')[0];

// Update the count down every 1 second
let x = setInterval(function (e) {

    // Get today's date and time
    const now = new Date().getTime();

    // Find the distance between now and the count down date
    const timeleft = countDownDate - now;

    countdown.innerHTML = counter(timeleft);

    // If the countdown is over...
    if (timeleft < 0) {
        clearInterval(x);
        countdown.innerHTML = 'TIME UP!';

        for (let button of buttons) {
            button.disabled = true;
            button.style.backgroundColor = 'gray';
        }

        Swal.fire({
            icon: 'error',
            title: 'Time is up!',
            text: 'Exam time exceded',
            footer: 'You will be redirected soon...',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 5000,
            timerProgressBar: true,
        }).then((result) => {
            form.submit();
        })
    }
}, 1000);


function counter(timeleft) {
    // convert milliseconds to seconds / minutes / hours etc.
    const msPerSecond = 1000;
    const msPerMinute = msPerSecond * 60;
    const msPerHour = msPerMinute * 60;
    const msPerDay = msPerHour * 24;

    // calculate remaining time
    const days = Math.floor(timeleft / msPerDay);
    const hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / msPerHour);
    const minutes = Math.floor((timeleft % (1000 * 60 * 60)) / msPerMinute);
    const seconds = Math.floor((timeleft % (1000 * 60)) / msPerSecond);

    // Output the result in element with id='clock'
    if (days === 0) {
        message = hours + 'h ' + minutes + 'm ' + seconds + 's ';
    } else {
        message = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
    }
    return message;
}
