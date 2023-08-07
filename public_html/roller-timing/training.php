<?php
include_once "../api/index.php";
include_once "../includes/error.php";

if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/roller-timing");
}


if(!isset($_GET["session"])) {
    throwError($ERROR_INVALID_ID, "/roller-timing");
}

$trainingsSession = getTrainingsSession($_GET["session"]);

if(!$trainingsSession) {
    throwError($ERROR_INVALID_ID, "/roller-timing");
}

include_once "../header.php";
echoRandWallpaper();
?>
<script>
    const triggers = <?php echo json_encode($trainingsSession, true); ?>;
    console.log(triggers);
</script>
<style>
.lap, .split-lap {
    align-items: center;
    display: flex;
    gap: 1rem;
    padding: 0.3rem;
}

.split-lap {
    padding-left: 1.5rem;
    border-left: 1px solid #444;
}

.lap:not(:first-of-type) {
    border-top: 1px solid #444;
}

.lap-index, .split-lap-index {
    color: #284746;
    font-style: italic;
    width: 2em;
    font-size: 1.1rem;
}

.lap-time {
    color: #0b2229;
    font-size: 1.3rem;
    font-weight: bold;
}

.split-lap-time {
    color: #0b2229;
    font-size: 1.1rem;
}

.split-lap-distance {
    width: 3em;
}
</style>
<main class="main competition-page">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest"><i class="fas fa-binoculars margin right"></i>Roller timing</h1>
        <p class="align center font size big color light margin top double"><?=$_GET["session"]?></p>
    </div>
    <div class="light section">
        <div id="viewer">
            
        </div>
    </div>
</main>
<script>

const STATION_TRIGGER_TYPE_START_FINISH = 0;
const STATION_TRIGGER_TYPE_START = 1;
const STATION_TRIGGER_TYPE_CHECKPOINT = 2;
const STATION_TRIGGER_TYPE_FINISH = 3;
const STATION_TRIGGER_TYPE_NONE = 4;

class SplitLap {
    constructor(distance, splitTimeMs, splitIndex) {
        this.distance = distance;
        this.splitTimeMs = splitTimeMs;
        this.splitIndex = splitIndex;
    }
}

class Lap {
    constructor(index, timeMs, splitLaps) {
        this.index = index;
        this.timeMs = timeMs;
        this.splitLaps = splitLaps;
        this.done = true;
    }
}

function sessionToLaps(session) {
    const laps = [];
    let splitLaps = [];
    let lapStarted = false;
    let lapCount = 0;
    let lapStart = 0;
    let lastTrigger = 0;
    let lastMillimeters = 0;
    let currentCheckpoint = 0;
    let finishPending = false;
    for (const trigger of session) {
        if(lapStarted && (trigger.triggerType === STATION_TRIGGER_TYPE_FINISH || trigger.triggerType === STATION_TRIGGER_TYPE_START_FINISH)) {
            if(splitLaps.length > 0) {
                splitLaps.push(new SplitLap(trigger.millimeters, trigger.timeMs - lastTrigger, currentCheckpoint++));
            }
            laps.push(new Lap(lapCount++, trigger.timeMs - lapStart, splitLaps));
            splitLaps = [];
            lapStarted = false;
            finishPending = false;
        }
        if(trigger.triggerType == STATION_TRIGGER_TYPE_START || trigger.triggerType == STATION_TRIGGER_TYPE_START_FINISH) {
            lapStart = trigger.timeMs;
            lastMillimeters = 0;
            lapStarted = true;
            currentCheckpoint = 0;
        }
        if(trigger.triggerType == STATION_TRIGGER_TYPE_START) {
            finishPending = true;
        }
        if(lapStarted && trigger.triggerType == STATION_TRIGGER_TYPE_CHECKPOINT) {
            if(trigger.millimeters <= lastMillimeters) continue;
            splitLaps.push(new SplitLap(trigger.millimeters, trigger.timeMs - lastTrigger, currentCheckpoint++));
            lastMillimeters = trigger.millimeters;
            finishPending = true;
        }
        lastTrigger = trigger.timeMs;
    }
    if(splitLaps.length > 0 || finishPending) {
        const lap = new Lap(lapCount++, 0, splitLaps);
        lap.done= false;
        laps.push(lap);
    }
    return laps;
}

function displayLaps(laps) {
    console.log("laps:", laps);
    const viewer = document.getElementById("viewer");
    viewer.innerHTML = "";
    viewer.innerHTML += "<br>";
    viewer.innerHTML += "<br>";
    for (const lap of laps.toReversed()) {
        viewer.innerHTML += `<div class="lap">
            <span class="lap-index">#${lap.index + 1}</span>
            <span class="lap-time">${lap.done ? (timeToStr(lap.timeMs)) : 'running...'}</span>`;
        for (const splitLap of lap.splitLaps.toReversed()) {
            viewer.innerHTML += `
            <div class="split-lap">
                <span class="split-lap-index">#${splitLap.splitIndex + 1}</span>
                <span class="split-lap-distance">${splitLap.distance / 1000}m</span>
                <span class="split-lap-time">${timeToStr(splitLap.splitTimeMs)}</span>
            </div>`;
        }
        viewer.innerHTML += "</div>";
    }
}

function moduloWoPercent(x, y) {
  return x - y * Math.floor(x / y);
}

function timeToStr(millis) {
    // Calculate the individual time units
    let milliseconds = moduloWoPercent(millis, 1000);
    let seconds = Math.floor(moduloWoPercent(millis / 1000, 60));
    let minutes = Math.floor(moduloWoPercent(millis / (1000 * 60), 60));
    let hours = Math.floor(millis / (1000 * 60 * 60));
    // Format the time string
    let timeStr = '';
    if (hours > 0) {
        timeStr += String(hours).padStart(2, '0') + ':';
    }
    if (minutes > 0 || hours > 0) {
        timeStr += String(minutes).padStart(2, '0') + ':';
    }
    timeStr += String(seconds).padStart(2, '0') + ':' + String(milliseconds).padStart(3, '0');
    return timeStr;
}

const laps = sessionToLaps(triggers);

displayLaps(laps);

</script>
<?php
include_once "../footer.php";
?>