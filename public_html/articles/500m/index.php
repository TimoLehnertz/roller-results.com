<?php
include_once "../../../api/index.php";
include_once "../../../header.php";
echoRandWallpaper();

?>
<main class="main competition-page">
    <div class="top-site">
        <!-- <h1 class="title">500m+D</h1> -->
    </div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#333"></path></svg>
    <div class="dark section no-shadow">
        <h1><a href="/analytics/index.php">Analytics</a><i class="margin left right fas fa-chevron-right"></i>500m+D Analytics</h1>
        <p class="align center font color light">
            Regarding start position, position in the first corner, out the last corner and finish
        </p>
    </div>
    <div class="light section">
        <div class="align center" style="background: #DDD; color: black;">
            <h2 style="display: inline" class="margin right">Graphic</h2>
            <button class="btn default round switch-direction"><i class="fas fa-sync-alt margin right"></i>Switch direction</button>
            <button class="btn default round switch-subColors"><i class="fas fa-sync-alt margin right"></i>Use sub colors</button>
            <button class="btn default round switch-female"><i class="fas fa-female margin right"></i>Female</button>
            <button class="btn default round switch-male"><i class="fas fa-male margin right"></i>Male</button>
        </div>
        <div class="layerDiagram">
            <!-- Layer Diagramm -->
        </div>
    </div>
    <div class="dark section flex column">
        <h2 class="align center">Statistic in numbers</h2>
        <?php include "winnerTable.html";?>
        <p>
            <br>
            Excel table showing percentages
        </p>
    </div>
    <div class="light section">
        <h2>
            Statistic to win from position x at x
        </h2>
        <div class="flex row mobile">
            <img src="charts/winnerFromStart.PNG" class="width third mobile" alt="Chart">
            <img src="charts/winnerFromAfterStart.PNG" class="width third mobile" alt="Chart">
            <img src="charts/winnerFrombeforeFinish.PNG" class="width third mobile" alt="Chart">
        </div>
    </div>
    <script>
        let data;

        let useFemale = true;
        let useMale = true;

        let mouseDown = false;

        let subColors = true;
        let rawData;
        $(()=> {
            get("500mData").receive((succsess, res) => {
                rawData = res;
                updateData();
                createDiagram();
            })
            $(".switch-direction").click(()=>{
                forewards = !forewards;
                updateDiagram();
            })
            $(".switch-subColors").click(function(){
                subColors =!subColors;
                updateDiagram();
                if(subColors){
                    $(this).css("background-color", "#493")
                } else{
                    $(this).css("background-color", "gray")
                }
            })
            $(".switch-female").click(function(){
                useFemale = !useFemale;
                if(!(useFemale || useMale)){
                    useMale = true;
                }
                if(useFemale){
                    $(this).css("background-color", "#493")
                } else{
                    $(this).css("background-color", "gray")
                }
                if(useMale){
                    $(".switch-male").css("background-color", "#493");
                } else{
                    $(".switch-male").css("background-color", "gray");
                }
                updateData();
                updateDiagram();
            });
            $(".switch-male").click(function(){
                useMale = !useMale;
                if(!(useFemale || useMale)){
                    useFemale = true;
                }
                if(useMale){
                    $(this).css("background-color", "#493")
                } else{
                    $(this).css("background-color", "gray")
                }
                if(useFemale){
                    $(".switch-female").css("background-color", "#493");
                } else{
                    $(".switch-female").css("background-color", "gray");
                }
                updateData();
                updateDiagram();
            });
            $(".switch-subColors").css("background-color", "#493");
            $(".switch-female").css("background-color", "#493");
            $(".switch-male").css("background-color", "#493");
        });

        function updateData(){
            data = parseData(rawData);
        }

        function createDiagram() {
            $(`.layerDiagram`).append(`<canvas width="900" height="400"></canvas>`);
            canvas = document.querySelector(".layerDiagram canvas");
            $(canvas).on("mousedown",()=>{mouseDown = true; updateDiagram()});
            $(canvas).on("mouseup",()=>{mouseDown = false; updateDiagram()});
            reOffset();
            window.onscroll=function(e){ reOffset(); }
            window.onresize=function(e){ reOffset(); }
            $(canvas).mousemove(function(e){handleMouseMove(e);});
            $(canvas).mouseenter(function(){mouseInside=true;});
            $(canvas).mouseleave(function(){mouseInside=false;updateDiagram();});
            updateDiagram();
        }

        let offsetX, offsetY;

        function reOffset(){
            if(canvas != null){
                canvas.width = document.querySelector("main").offsetWidth * (isMobile() ? 0.97 : 0.95);
                var bb=canvas.getBoundingClientRect();
                offsetX=bb.left;
                offsetY=bb.top;
                updateDiagram();
            }
        }

        /**
         * Diagram setup
         */
        const layerWidth = isMobile() ? 50 : 100;
        const padding = 0;
        const lineWidth = 2;
        const positionColors = ["DarkGoldenRod", "DarkGray", "Coral", "DarkOliveGreen"];
        const focusColor = "Brown";
        const fontCOlor = "white";
        const background = "#333";

        let forewards = true;
        let focusedPlace = -1;

        let lastMouseDown = false;

        function updateDiagram(){
            
            const max = getMaxFromData();
            const canvas = document.querySelector(".layerDiagram canvas");
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = background;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.lineWidth = 10;
            ctx.font = "1.2rem Montserrat";

            const width = canvas.width - padding * 2;
            const height = canvas.height - padding * 2;
            
            if(mouseInside && mouseDown){
                if(focusedPlace == parseInt((mouseY) * 4 / height) && !lastMouseDown) {
                    focusedPlace = -1;
                } else {
                    focusedPlace = parseInt((mouseY) * 4 / height)
                }
            }
            lastMouseDown = mouseDown;
            let hovered = -2;
            if(mouseInside){
                hovered = parseInt((mouseY) * 4 / height);
            }
            
            
            /**
             * metadata
             */
            let hoverPercentage = undefined;
            const lStartY = padding;
            const lStartX = [];
            for (let i = 0; i < 4; i++) {
                lStartX[i] = padding + (width) / 3 * i * ((width - layerWidth) / width);
            }

            const pHeight = height / 4;
            const pStartY = [];
            for (let i = 0; i < 4; i++) {
                pStartY[i] =  height / 4 * i;
            }

            let usedSpaceAfter = [[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0]];

            for (let layer = 0; layer < 4; layer++) {
                const posConsistsOf = data [layer].posConsistsOf;

                let position = 0;
                // if(focusedPlace > -1){
                //     position = (focusedPlace) % 4;
                // } else{
                //     position = 0;
                // }
                
                let counter = 0;
                while (counter < 4) {
                    ctx.filter = "opacity(100%)";
                    if(focusedPlace != -1){
                        ctx.filter = "opacity(100%)";
                    }
                    if(position == focusedPlace){
                        ctx.filter = "opacity(200%), brightness(150%)";
                        ctx.fillStyle = focusColor;
                    } else{
                        ctx.fillStyle = positionColors[position];
                    }
                
                    
                    if(position == hovered){
                        ctx.filter = "saturate(200%)";
                    }
                    if(!subColors){//simple
                        ctx.fillRect(lStartX[layer], pStartY[position], layerWidth, pHeight);
                    } else if(layer == 0){
                        ctx.fillRect(lStartX[layer], pStartY[position], layerWidth, pHeight);
                    }
                    if(layer > 0){// all layers except of first one as has no ones in before
                        const positions = posConsistsOf[position];
                        let positionBefore = 0;
                        let usedSpaceInFront = 0;
                        for (const positionElem of positions) {
                            const percentage = positionElem.positions / max;
                            if(focusedPlace != -1){
                                ctx.filter = "opacity(80%)";
                            }
                            if(positionBefore == focusedPlace){
                                ctx.filter = "opacity(100%), brightness(200%)";
                                ctx.fillStyle = focusColor;
                            } else{
                                ctx.fillStyle = positionColors[forewards ? positionBefore : position];
                            }
                            if(positionBefore == hovered){
                                ctx.filter = "saturate(200%)";
                            }
                            const filterTmp = ctx.filter;
                            if(subColors){
                                const subHovered = mouseX > lStartX[layer] && mouseX < lStartX[layer] + layerWidth && mouseY > pStartY[position] + usedSpaceInFront && mouseY < pStartY[position] + usedSpaceInFront + pHeight * percentage;
                                if(subHovered){
                                    hoverPercentage = Math.round(percentage * 100);
                                    ctx.filter = "opacity(200)";
                                    if(mouseDown){
                                        if(layer > 0){
                                            const infos = data[layer] ["posConsistsOf"] [position] [positionBefore] ["infos"];
                                            let html = `<p>Von Position ${positionBefore + 1} ${layerToSituationAfter(layer - 1)} auf Position ${position + 1} ${layerToSituationAfter(layer)}</p>
                                            <p>Alle rennen, die auf diese Rennsituation passen</p>`;
                                            for (const info of infos) {
                                                html += `<li><a target="_blank" href="${info.link}">${info.competition} ${info.year} ${info.category} ${info.sex == "w" ? "Female" : "Male"}</a></li>`;
                                            }
                                            $(".info").empty();
                                            
                                            $(".info").append(`<ol>${html}</ol>`);
                                        }
                                    }
                                }
                                ctx.fillRect(lStartX[layer], pStartY[position] + usedSpaceInFront, layerWidth, pHeight * percentage);
                            }
                            ctx.filter = filterTmp;
                            
                            ctx.beginPath();

                            ctx.moveTo(lStartX[layer], pStartY[position] + usedSpaceInFront);//start top left of position

                            ctx.lineTo(lStartX[layer], pStartY[position] + usedSpaceInFront + pHeight * percentage);

                            ctx.lineTo(lStartX[layer - 1] + layerWidth, pStartY[positionBefore] + usedSpaceAfter[layer - 1][positionBefore] + pHeight * percentage);

                            ctx.lineTo(lStartX[layer - 1] + layerWidth, pStartY[positionBefore] + usedSpaceAfter[layer - 1][positionBefore]);

                            ctx.fill();
                            usedSpaceAfter[layer - 1][positionBefore] += pHeight * percentage;
                            usedSpaceInFront += pHeight * percentage;
                            positionBefore++;
                        }
                    }
                    position = (position + 1) % 4;
                    counter++;
                }
            }
            // text
            ctx.filter = "brightness(100%)";
            for (let layer = 0; layer < 4; layer++) {
                ctx.fillStyle = "#454";
                ctx.fillRect(lStartX[layer], 0, 2, height);
                ctx.fillRect(lStartX[layer] + layerWidth, 0, 2, height);
                ctx.fillStyle = fontCOlor;
                ctx.fillText(convertName(layerToName(layer)), lStartX[layer] + 4, 20);
            }
            
            for (let place = 0; place < 5; place++) {
                ctx.fillStyle = "#454";
                ctx.fillRect(padding, (height / 4) * place, width, 3);
                if(place < 4){
                    ctx.fillStyle = fontCOlor;
                    ctx.fillText("Place " + (place + 1), padding + 2, (height / 4) * (place + 0.5) - 5);
                }
            }
            if(hoverPercentage != undefined){
                ctx.fillStyle = "white";
                ctx.filter = "opacity(100%)";
                ctx.fillText(hoverPercentage + "%", mouseX, mouseY);
            }
        }

        let mouseX = 0;
        let mouseY = 0;
        let mouseInside = false;
        function handleMouseMove(e){
            mouseX=parseInt(e.clientX-offsetX);
            mouseY=parseInt(e.clientY-offsetY - padding);
            updateDiagram();
        }

        class Position{
            constructor(){
                this.infos = [];
                this.positions = 0;
            }
        }

        function parseData(rawData){
            const data = [];
            for (let i = 0; i < 4; i++) {
                data[i] = {
                    name: convertName(layerToName(i)),
                    posConsistsOf: []//outer array means position inner arrays mean maount of prevoius positions that have been there
                };
                for (let l = 0; l < 4; l++) {
                    data[i] ["posConsistsOf"].push([new Position(),new Position(),new Position(),new Position()]);
                }
            }
            for (const row of rawData) {
                if(row["sex"] == "m" && !useMale){
                    continue;
                }
                if(row["sex"] == "w" && !useFemale){
                    continue;
                }
                //Track each sportler throoughout the race(1,2,3,4)
                for (let startPosition = 0; startPosition < 4; startPosition++) {
                    //track layers(start, afterStart, beforeFinish, finish)
                    let lastPos = startPosition;
                    for (let layer = 0; layer < 4; layer++) {
                        let position = undefined;
                        for (let i = 1; i < 5; i++) {
                            if(row [layerToName(layer) + i] == startPosition + 1){
                                position = i - 1;
                            }
                        }
                        if(position != undefined && position >= 0){
                            data[layer].posConsistsOf [position] [lastPos].positions++;
                            data[layer].posConsistsOf [position] [lastPos].infos.push(row);
                            lastPos = position;
                        }
                    }
                }
            }
            //filling first layer with dummies(1)
            let max = 0;
            for (const position of data[3].posConsistsOf[3]) {
                max += position.positions;
            }
                for (let l = 0; l < 4; l++) {
                    for (let i = 0; i < 4; i++) {
                        data[0] ["posConsistsOf"] [l] [i] = 1
                    }
                }
            return data;
        }

        function getMaxFromData(){
            let max = 0;
            for (const position of data[3].posConsistsOf[3]) {
                max += position.positions;
            }
            return max;
        }

        function nrFromName(name){
            return parseInt(name.charAt(name.length - 1));
        }

        function nextLayerName(name){
            const nr = nrFromName(name);
            return layerToName(nr + 1);
        }

        function nameToLayer(name){
            if(name.includes("start")){
                return 0;
            }
            if(name.includes("afterStart")){
                return 1;
            }
            if(name.includes("beforeFinish")){
                return 2;
            }
            if(name.includes("Finish")){
                return 3;
            }
            return -1;
        }

        function layerToName(layer){
            switch(layer){
                case 0: return "start1";
                case 1: return "afterStart";
                case 2: return "beforeFinish";
                case 3: return "finish";
            }
            
        }

        function convertName(name){
            if(name.toLowerCase().includes("start1")){
                return "Start";
            }
            if(name.toLowerCase().includes("afterstart")){
                return "After start";
            }
            if(name.toLowerCase().includes("beforefinish")){
                return "Finishline";
            }
            if(name.toLowerCase().includes("finish")){
                return "Result";
            }
            return "--";
        }

        function layerToSituationAfter(layer){
            switch(layer){
                case 0: return "am start";
                case 1: return "nach dem Start";
                case 2: return "vor eingang Zielgrade";
                case 3: return "im Ziel";
            }
        }1
    </script>
</main>
<?php
include_once "../../../footer.php";
?>