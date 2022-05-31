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
        <button class="bnt blender right" onclick="connectBLE()">Bluetooth</button>
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

/**
 * BLE
 */
var myCharacteristic;

function connectBLE() {
    // let serviceUuid = "0x0201060E09526F6C6C65722074696D696E67020A03";
//   let serviceUuid = "00002A05-0000-1000-8000-00805F9B34FB"
//   let serviceUuid = "00002A05-0000-1000-8000-00805F9B34FB"
  let serviceUuid = "2d1bf2d6-caf3-4328-b7c5-f2fcd14b2f4c";
  if (serviceUuid.startsWith('0x')) {
    serviceUuid = parseInt(serviceUuid);
  }

  let characteristicUuid = "d50bb140-15c2-4839-8a31-efbc497861fa";
//   if (characteristicUuid.startsWith('0x')) {
//     characteristicUuid = parseInt(characteristicUuid);
//   }

console.log('Requesting Bluetooth Device...');
//   navigator.bluetooth.requestDevice({filters: [{name: "Roller timing"}]})
    navigator.bluetooth.requestDevice({
            acceptAllDevices: true,
            // optionalServices: ['d50bb140-15c2-4839-8a31-efbc497861fa']
            // filters: [{services: ['2d1bf2d6-caf3-4328-b7c5-f2fcd14b2f4c']}]
            // filters: [{namePrefix: 'MyESP32'}],
            optionalServices: ['4992aa40-60c9-43bd-b24f-d702b6270cce', 'af400827-2509-4c21-bb20-d22bb2f0321a', 'd50bb140-15c2-4839-8a31-efbc497861fa', '2d1bf2d6-caf3-4328-b7c5-f2fcd14b2f4c']
    })

//   navigator.bluetooth.requestDevice({acceptAllDevices: true})
//   navigator.bluetooth.requestDevice({filters: [{services: [serviceUuid]}]})
  .then(device => {
    console.log('Connecting to GATT Server...');
    console.log(device);
    return device.gatt.connect();
  })
  .then(server => {
    console.log('Getting Service...');
    return server.getPrimaryService(serviceUuid);
  })
  .then(service => {
    console.log('Getting Characteristic...');
    return service.getCharacteristic(characteristicUuid);
  })
  .then(characteristic => {
    myCharacteristic = characteristic;
    return myCharacteristic.startNotifications().then(_ => {
        console.log('> Notifications started');
      myCharacteristic.addEventListener('characteristicvaluechanged',
          handleNotifications);
    });
  })
  .catch(error => {
    console.log('Argh! ' + error);
  });
}

function onStopButtonClick() {
  if (myCharacteristic) {
    myCharacteristic.stopNotifications()
    .then(_ => {
        console.log('> Notifications stopped');
      myCharacteristic.removeEventListener('characteristicvaluechanged',
          handleNotifications);
    })
    .catch(error => {
      console.log('Argh! ' + error);
    });
  }
}

function handleNotifications(event) {
  let value = event.target.value;
  console.log(value);
  let a = [];
  // Convert raw data bytes to hex values just for the sake of showing something.
  // In the "real" world, you'd use data.getUint8, data.getUint16 or even
  // TextDecoder to process raw data bytes.
  for (let i = 0; i < value.byteLength; i++) {
    a.push('0x' + ('00' + value.getUint8(i).toString(16)).slice(-2));
  }
//   log('> ' + a.join(' '));
}


/**
 * Serial
 * 
 */
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
    let recLine = "";
    while(true) {
        const { value, done } = await reader.read();
        if(done) {
            reader.releaseLock();
            break;
        }
        for (let i = 0; i < value.length; i++) {
            const c = value.charAt(i);
            recLine += c;
            if(c == '\n' || c == '\r') {
                recLine = recLine.trim();
                if(recLine.length > 0) {
                    processSerial(recLine);
                }
                recLine = "";
            }
        }
        document.getElementById("console").innerText += value;
    }
}

function processSerial(line) {
    console.log(line);
    if(line.charAt(0) == 'R') {
        $("body")
        updateStatus(true);
    }
    if(line.charAt(0) == 'N') {
        updateStatus(false);
    }
    if(line.charAt(0) == 'T') {
        triggerLap(line.substring(1, line.length));
    }
}

/**
 * Logic
 */
let lap = 0;

function triggerLap(time) {
    $("#time-table").append(`<tr><td>${lap++}</td><td>${time}</td></tr>`);
}

function updateStatus(isReflected) {
    if(isReflected) {
        $(".info").text("reflected");
        document.getElementById("body").style.background = "#111";
    } else {
        $(".info").text("not reflected");
        document.getElementById("body").style.background = "red";
    }
}
</script>
</html>