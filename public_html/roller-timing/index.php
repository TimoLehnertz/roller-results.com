<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css?v=1.1">
    <script src="/js/jquery-3.5.1.js"></script>
    <title>Roller-timing</title>
</head>
<style>
* {
    color: white;
}
body {
    background-color: #111;
}

.blender {
    padding: 1rem;
    background: #666;
    border-radius: 1rem;
}
</style>
<body id="body">
    <h1>Roller timing</h1>
    <div class="flex">
        <button class="bnt blender left" onclick="connectSerial()">USB</button>
        <button class="bnt blender right">Bluetooth</button>
    </div>
    <details>
        <summary>Serial Console</summary>
        <div id="console"></div>
    </details>
    <div class="info"></div>
    <h2>Times</h2>
    <table id="time-table">
        <tr>
            <td>lap</td><td>time</td>
        </tr>
    </table>
</body>
<script>

let lap = 0;

function triggerLap(time) {
    $("#time-table").append(`<tr><td>${lap++}</td><td>${time}</td></tr>`);
}
    
// Serial
let writer;
let connected = false;
function send() {
    if(!connected) return alert("connect first");
    const text = document.getElementById("input").value;
    writer.write(text);
}

async function connectSerial() {
    const port = await navigator.serial.requestPort();
    console.log(port);

    await port.open({baudRate: 115200});

    connected = true;

    // reader
    const textDecocder = new TextDecoderStream();
    const readableStreamClosed = port.readable.pipeTo(textDecocder.writable);
    const reader = textDecocder.readable.getReader();
    
    // writer
    const textEncoder = new TextEncoderStream();
    const writeableStreamClosed = textEncoder.readable.pipeTo(port.writable);
    writer = textEncoder.writable.getWriter();

    while(true) {
        const { value, done } = await reader.read();
        if(done) {
            reader.releaseLock();
            break;
        }
        console.log(value);
        document.getElementById("console").innerText += value;
        processSerial(value.trim());
    }
}

setInterval(() => {
    if(reflected) {
        document.getElementById("body").style.background = "#111"
    } else {
        document.getElementById("body").style.background = "red"
    }
}, 100);

let reflected = false;

function processSerial(line) {
    // console.log(line.charAt(0));
    if(line.charAt(0) == 'R') {
        $("body")
        reflected = true;
        $(".info").text("not reflected");
    }
    if(line.charAt(0) == 'N') {
        reflected = false;
        $(".info").text("reflected");
    }
    if(line.charAt(0) == 'T') {
        console.log("time");
        triggerLap(line.substring(1, line.length));
    }
}
</script>
</html>