<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ระบบลงเวลาปฏิบัติงาน | AREC MSU</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ url('img/favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Prompt|Anuphan" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased">

    <div id="app"></div>

    {{-- Client --}}
    <div id="clock" class="flex justify-center digital_clock_wrapper mt-8">
        <div class="row rounded border-x-4 border-gray-300 px-8">
            <div id="digit_clock_time" class="text-center text-6xl"></div>
            <div id="digit_clock_date" class="text-4xl text-gray-500"></div>
        </div>
    </div>

    <div id="screenshots"></div>

</body>

<script type="text/javascript">

    /** Clock **/
    function currentTime() {
        var date = new Date(); /* creating object of Date class */
        var hour = date.getHours();
        var min = date.getMinutes();
        var sec = date.getSeconds();
        hour = changeTime(hour);
        min = changeTime(min);
        sec = changeTime(sec);
        document.getElementById("digit_clock_time").innerText = hour + " : " + min + " : " +
            sec; /* adding time to the div */

        var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
            'กันยายน',
            'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        var days = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];

        var curWeekDay = days[date.getDay()]; // get day
        var curDay = date.getDate(); // get date
        var curMonth = months[date.getMonth()]; // get month
        var curYear = date.getFullYear() + 543; // get year
        var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear; // get full date
        document.getElementById("digit_clock_date").innerHTML = date;

        var t = setTimeout(currentTime, 1000); /* setting timer */
    }

    function changeTime(k) {
        /* appending 0 before time elements if less than 10 */
        if (k < 10) {
            return "0" + k;
        } else {
            return k;
        }
    }

    currentTime();

</script>

</html>
