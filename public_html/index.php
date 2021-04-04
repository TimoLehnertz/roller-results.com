<?php
include_once "api/index.php";
// $indexPage = 1;
include_once "header.php";
include_once "api/imgAPI.php";

// $amountCountry = getCountryAmount();
// $amountAthlete = getAthleteAmount();
// $amountResult = getResultAmount();
// $amountRace = getRaceAmount();
// $amountCompetition = getCompetitionAmount();

// echo "<script>
//     const amountCountry = $amountCountry;
//     const amountAthlete = $amountAthlete;
//     const amountResult = $amountResult;
//     const amountRace = $amountRace;
//     const amountCompetition = $amountCompetition;
// </script>";
// echoRandWallpaper();

?>
<!-- geoInterpolate() -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.2/d3.min.js"></script>

<!-- <script type="text/javascript" src="/js/globe/third-party/Detector.js"></script> -->
<!-- <script type="text/javascript" src="/js/globe/third-party/three.min.js"></script> -->
<!-- <script type="module" src="/js/globe/third-party/Tween.js"></script> -->
<script type="module" src="/js/globe/globe.js"></script>
<main class="main index">
    <div class="date"></div>
    <div id="container" class="globe"/>
</main>
<script type="module">
    import { DAT } from "/js/globe/globe.js";

    console.log(hexToDecimal("#0"));
    console.log(hexToDecimal("#FFFFFF"));

    var container = document.getElementById( 'container' );
    var globe = new DAT.Globe( container );

    // const controller = globe.trajectoryFromTo(50.800209, 6.764670, 0, 0, {color: 0xff44aa});

    // controller.animate("in", "forewards", 2000).onComplete(() => {
    //     controller.animate("out", "backwards", 2000).onComplete(() => {
    //         controller.animate("in", "forewards", 2000);
    //     })
    // });

    // globe.highlightAt(50.800209, 6.764670, {type: "ring", color: 0xff44aa, effects: [{
    //     type: "translateUp",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }, {
    //     type: "scaleUp",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }, {
    //     type: "fade",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }]});
    // for (let lat = 0; lat < 90; lat+= 10) {
    //     for (let lng = 0; lng < 90; lng+= 10) {
    //         globe.highlightAt(lat, lng, {color: 0xff44aa});
    //     }
    // }
    globe.initSurfaceDots();
    globe.animate();

    let data;
    let pause = false;
    get("worldMovement").receive((succsess, response) => {
        data = response;
        for (const movement of data) {
            movement.controllers = [];
            movement.date = mysqlDateToJsDate(movement.date);
            // movement.athleteCountryRadius = Math.min(movement.athleteCountryRadius, 100);
            for (let i = 0; i < Math.max(1, movement.athleteCount / 10); i++) {
                const randomX = globe.kmToDregree(Math.random() * movement.athleteCountryRadius * 2 - movement.athleteCountryRadius) * 0.7;
                const randomY = globe.kmToDregree(Math.random() * movement.athleteCountryRadius * 2 - movement.athleteCountryRadius) * 0.7;
                
                const controller = globe.trajectoryFromTo(movement.athleteLatitude + randomX,
                movement.athleteLongitude + randomY,
                movement.compLatitude, movement.compLongitude,
                {color: hexToDecimal(movement.athleteCountryColor), visible: false,
                    onhover: (me) => {
                        me.material.color.set(0xffffff);
                        globe.stopRotation();
                        globe.pauseAnimations();
                        pause = true;
                    }, onleave: (me) => {
                        me.material.color.set(hexToDecimal(movement.athleteCountryColor));
                        globe.startRotation();
                        globe.startAnimations()
                        pause = false;
                    }, onclick: (me) => {
                        console.log("click");
                    }
                });
                movement.controllers.push(controller);
            }
        }
        // console.log(data);

        window.setInterval(() => {
            if(pause) return;
            date.setDate(date.getDate() + 1);
            $(".date").text(dateToString(date));
            dateUpdated();
        }, 10);
    });

    const date = new Date(1995, 11, 20);
    const visible = [];

    function hexToDecimal(hex) {
        let newHex = "#";
        if(hex.length === 4) {
            for (let i = 1; i < 4; i++) {
                newHex += hex.charAt(i);
                newHex += hex.charAt(i);
            }
            return hexToDecimal(newHex);
        } else {
            return parseInt(hex.substr(1, 6), 16);
        }
    }

    function dateUpdated() {
        // console.log(date.toString());
        // console.log(date.getDate());
        for (const movement of data) {
            if(sameDay(movement.date, date) && !visible.includes(movement)){
                /**
                 * add
                 */
                visible.push(movement);
                for (const controller of movement.controllers) {
                    controller.animate("in", "forewards", 5000 * random(0.7, 1.3)).onComplete(() => {
                        controller.animate("out", "backwards", 2000, 1000);
                        visible.splice(visible.indexOf(movement), 1);
                    });
                }
            }
            // if(!sameDay(movement.date, date) && visible.includes(movement)){
            //     /**
            //      * renove
            //      */
            //     visible.splice(visible.indexOf(movement), 1);
            //     movement.controller.animate("out", "backwards", 2000);
            // }
        }
    }

    function random(min, max) {
        return Math.random() * (max - min) + min;
    }

    function mysqlDateToJsDate(mysqlDate) {
        const dateParts = mysqlDate.split("-");
        return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
    }

    function sameDay(d1, d2) {
        return d1.getFullYear() === d2.getFullYear() &&
            d1.getMonth() === d2.getMonth() &&
            d1.getDate() === d2.getDate();
    }

    function dateToString(date) {
        let day = date.getDate() + "";
        if((day).length === 1) {
            day = "0" + day;
        }
        let month = date.getMonth();
        if(month.length === 1) {
            month = "0" + month;
        }
        return month + " " + date.getFullYear();
    }

</script>
<?php
    include_once "footer.php";
?>