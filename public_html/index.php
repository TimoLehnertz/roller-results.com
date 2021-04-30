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

// echo "<>
//     const amountCountry = $amountCountry;
//     const amountAthlete = $amountAthlete;
//     const amountResult = $amountResult;
//     const amountRace = $amountRace;
//     const amountCompetition = $amountCompetition;
// </>";
// echoRandWallpaper();

?>
<!-- geoInterpolate() -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.2/d3.min.js"></script>

<!-- < type="text/javascript" src="/js/globe/third-party/Detector.js"></> -->
<!-- < type="text/javascript" src="/js/globe/third-party/three.min.js"></> -->
<!-- < type="module" src="/js/globe/third-party/Tween.js"></> -->
<script type="module" src="/js/globe/globe.js"></script>
<main class="main index">
    <div class="message">
        <h1 class="headline">Where Rollerskating results come alive</h1>
        <p>
            Explore 90 Years of Roller skating results. Review, compare and analize your data with thousands of skaters arround the globe. 
        </p>
    </div>
    <div id="container" class="globe"></div>
    <div class="lower">
    <div class="dates"></div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
        <div class="content">
        <h1>Roller results</h1>
        <p>
            Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply  dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lore  Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply dummy text of 
        </p>

        <div class="hall-of-fame">
            <div class="best-skaters">
                <a class="no-underline" href="/hall-of-fame/index.php">
                    <div class="index-card">
                        <h2>Hall of fame</h2>
                        <ul>
                            <li>See the best skaters since 1930</li>
                            <li>All Athletes are sorted by their live calculated score</li>
                            <li>Take advantage of the setttings to change the way scores are calculated</li>
                            <li class="top-five">Top 5 Skaters<i class="fas fa-angle-double-right arrow-right"></i></li>
                            <li class="mobile-only margin top">Swipe left to reveal skaters</li>
                        </ul>
                    </div>
                </a>
            </div>
        </div>
        <p>
            Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply  dummy text of Lorem Ipsum. Lorem Ipsum
        </p>
        <div class="hall-of-fame">
            <div class="best-countries">
                <a class="no-underline" href="/hall-of-fame/index.php">
                    <div class="index-card">
                        <h2>Hall of fame</h2>
                        <ul>
                            <li>See the best performing countries</li>
                            <li>Take advantage of the setttings to change the way scores are calculated</li>
                            <li class="top-five">Top 5 Countries<i class="fas fa-angle-double-right arrow-right"></i></li>
                            <li class="mobile-only margin top">Swipe left to reveal countries</li>
                        </ul>
                    </div>
                </a>
            </div>
        </div>
        <p>
            Lorem Ipsum is simply dummy text of Lorem Ipsum. Lorem Ipsum is simply  dummy text of Lorem Ipsum. Lorem Ipsum
        </p>
    </div>
    </div>
</main>
<script type="module">

    let overlayOpened = false;
    let data;
    let pause = false;

    /**
     * slider
     */
    let date = new Date(1992, 0, 0);
    const slider = new DateSlider(new Date(1929, 5, 0), new Date(Date.now()), {
        currentDate: new Date(date.getTime()),
        drawCircle: false
    });
    slider.onchange = updateDate;
    slider.appendTo($(".dates"));

    import { DAT } from "/js/globe/globe.js";

    var container = document.getElementById( 'container' );
    var globe = new DAT.Globe( container );

    const overlay = $(
        `<div class="overlay">
            <div class="head">title</div>
            <div class="description">description</div>
        </div>`);
    $(".main").append(overlay);

    globe.animate();
    globe.initSurfaceDots();

    // overlay.on("hover", (e) => e.stopPropagation())

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
    // let me1 = null;
    // let meColor = null;

    // $(window).click(() => {
    //     if(isMobile() && overlayOpened) {
    //         console.log("close")
    //         overlayOpened = false;
    //         overlay.removeClass("drawn");
    //         me1.material.color.set(hexToDecimal(meColor));
    //         globe.startRotation();
    //         globe.startAnimations();
    //         pause = false;
    //         slider.frozen = false;
    //     }
    // });

    getFile("/json/worldMovement.json").receive((succsess, response) => {
    // get("worldMovement").receive((succsess, response) => {
        if(!succsess) {
            console.log("worldMovement error");
            return;
        }
        data = response;
        for (const movement of data) {
            movement.controllers = [];
            const athletes = [];
            const names = movement.athleteNames.split(",");
            const ids = movement.athleteIds.split(",");
            for (let i = 0; i < names.length; i++) {
                athletes.push({
                    name: names[i],
                    id: ids[i],
                    html: `<a href="/athlete/index.php?id=${ids[0]}">${names[i]}</a>`,
                });
            }
            movement.date = mysqlDateToJsDate(movement.date);
            // movement.athleteCountryRadius = Math.min(movement.athleteCountryRadius, 100);
            for (let i = 0; i < Math.max(1, movement.athleteCount / 10000); i++) {
                // const randomX = globe.kmToDregree(Math.random() * movement.athleteCountryRadius * 2 - movement.athleteCountryRadius) * 0.7;
//                 // const randomY = globe.kmToDregree(Math.random() * movement.athleteCountryRadius * 2 - movement.athleteCountryRadius) * 0.7;
                const color = "#f69";
                const randomX = 0;
                const randomY = 0;
                
                const controller = globe.trajectoryFromTo(movement.athleteLatitude + randomX,
                movement.athleteLongitude + randomY,
                movement.compLatitude, movement.compLongitude,
                // {color: hexToDecimal(movement.athleteCountryColor), visible: false,
                {color: hexToDecimal(color), visible: false,
                    onhover: (me, mouse, mousedown) => {
                        if(mousedown) return;
                        slider.frozen = true;
                        overlayOpened = true;
                        // overlay.css("top", Math.min(window.innerHeight - (220 + Math.min(athletes.length, 8) * 16), mouse.clientY));
                        overlay.css("top", mouse.offsetY - 5 + + $(".globe").offset().top);
                        overlay.css("left", Math.min(isMobile() ? 10 : window.innerWidth - 280, mouse.offsetX - 5 + $(".globe").offset().left));
                        overlay.addClass("drawn");
                        overlay.find(".head").html(`${movement.athleteCount} athletes from <a href="/country/index.php?id=${movement.athleteCountryName}">${movement.athleteCountryName}</a>`);
                        let medalString  = "";
                        if(movement.gold > 0 || movement.silver > 0 || movement.bronze > 0) {
                            medalString = "<div class='medals'><ul>";
                            if(movement.gold > 0){
                                medalString += `<li>${movement.gold} gold ${movement.gold > 1 ? "medals" : "medal"}</li>`;
                            }
                            if(movement.silver > 0){
                                medalString += `<li>${movement.silver} silver ${movement.silver > 1 ? "medals" : "medal"}</li>`;
                            }
                            if(movement.bronze > 0){
                                medalString += `<li>${movement.bronze} bronze ${movement.bronze > 1 ? "medals" : "medal"}</li>`;
                            }
                            medalString += "</ul></div>";
                        }
                        let athleteHtml = "<ol>";
                        for (const athlete of athletes) {
                            athleteHtml += `<li>${athlete.html}</li>`;
                        }
                        athleteHtml += "</ol>";
                        overlay.find(".description").html(
                            `${dateToMonthYear(movement.date)}<br><br>Competing at the <br><a href="/competition?id=${movement.idCompetition}">${movement.competitionType} in ${movement.competitionLocation} ${movement.competitionCountryName}</a><br>
                            ${medalString}<div class="athletes"><p>Athletes</p>${athleteHtml}</div>`);
                        me.material.color.set(0xffffff);
                        globe.stopRotation();
                        globe.pauseAnimations();
                        pause = true;
                    }, onleave: (me, mouse, mousedown) => {
                        // me1 = me;
                        overlayOpened = false;
                        overlay.removeClass("drawn");
                        // meColor = movement.athleteCountryColor;
                        me.material.color.set(hexToDecimal(movement.athleteCountryColor));
                        me.material.color.set(hexToDecimal(color));
                        globe.startRotation();
                        globe.startAnimations();
                        pause = false;
                        slider.frozen = false;
                    }, onclick: (me) => {
                        // console.log("click");
                    }
                });
                movement.controllers.push(controller);
            }
        }
    });

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

    function updateDate(oldDate, newDate) {
        if(!data) return;
        const min = Math.min(oldDate.getTime(), newDate.getTime());
        const max = Math.max(oldDate.getTime(), newDate.getTime());
        for (let i = min; i < max; i += 1000 * 60 * 60 * 24) {
            date = new Date(i);
            for (const movement of data) {
                // console.log(movement);
                if(sameDay(movement.date, date) && !visible.includes(movement)){
                    /**
                     * add
                     */
                    visible.push(movement);
                    for (const controller of movement.controllers) {
                        controller.stop();
                        controller.animate("in", "forewards", 2800 * random(0.7, 1.3)).onComplete(() => {
                            controller.animate("out", "backwards", 2000, 2500);
                            visible.splice(visible.indexOf(movement), 1);
                        });
                    }
                }
            }
        }
    }

    function random(min, max) {
        return Math.random() * (max - min) + min;
    }

    function mysqlDateToJsDate(mysqlDate) {
        const dateParts = mysqlDate.split("-");
        const date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
        // console.log(date);
        return date;
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



    /**
     * hall of fame
     */
    scoreCallbacks.push(update);
    
    const fameSlideshow = new Slideshow($(".best-skaters"));
    const countrieSlideshow = new Slideshow($(".best-countries"));
    initGet();

    /**
     * placeholders
     */
    const placeholders = [{},{},{},{},{},];
    initBestSkaters(placeholders, true);
    initCountries(placeholders, true);
    
    // const bestSkaters = JSON.parse(`[{"idAthlete":6666,"lastname":"Kalbe","firstname":"Evelyn","gender":"w","country":"Germany","comment":null,"club":null,"team":null,"image":null,"birthYear":null,"facebook":null,"instagram":null,"minAge":null,"raceCount":5,"fullname":"Evelyn Kalbe","topTen":"0","bronze":"0","silver":"0","gold":"0","medalScore":"0","score":0,"scoreShort":0,"scoreLong":0,"competitionCount":3,"bestDistance":"5000m RELAY"},{"idAthlete":1973,"lastname":"Swings","firstname":"Bart","gender":"M","country":"Belgium","comment":null,"club":null,"team":null,"image":"athlete-Bart-Swings-60787b453f7de5.00907222.jpg","birthYear":null,"facebook":null,"instagram":null,"minAge":null,"raceCount":147,"fullname":"Bart Swings","topTen":"10","bronze":"0","silver":"3","gold":"4","medalScore":"18","score":859.903438102628,"scoreShort":79.63600487051022,"scoreLong":780.2674332321178,"competitionCount":25,"bestDistance":"10000m Points\/Elimination"},{"idAthlete":1267,"firstname":"Joey","lastname":"Mantia","gender":"M","country":"United States of America","score":1482.3668188739332,"scoreShort":599.3805944581916,"scoreLong":882.9862244157414},{"idAthlete":1213,"firstname":"Francesca","lastname":"Lollobrigida","gender":"W","country":"Italy","score":1249.4311495760683,"scoreShort":182.65037745054562,"scoreLong":1066.7807721255222},{"idAthlete":1410,"firstname":"Andres Felipe","lastname":"Mu\u00f1oz","gender":"M","country":"Colombia","score":1212.6462006353472,"scoreShort":677.0707360876484,"scoreLong":535.5754645476989}]`);
    // initBestSkaters(bestSkaters);

    function initGet(){
        // get("hallOfFame").receive((succsess, bestSkaters) => {
        getFile("/json/hall-of-fame.json").receive((succsess, bestSkaters) => {
            if(succsess){
                clearBestSkaters();
                initBestSkaters(bestSkaters);
            } else{
                alert("An error occoured :/");
            }
        });
        getFile("/json/best-countries.json").receive((succsess, countries) => {
        // get("countries").receive((succsess, countries) => {
            if(succsess){
                clearCountries();
                initCountries(countries);
            } else{
                alert("An error occoured :/");
            }
        });
    }

    function update() {
        initGet();
        return true;
    }

    
    function clearBestSkaters(){
        $(".best-skaters .profile__wrapper").remove();
    }

    function clearCountries(){
        $(".best-countries .profile__wrapper").remove();
    }

    
    function initBestSkaters(bestSkaters, gray = false){
        const topAmount = 5;

        sortArray(bestSkaters, "score");
        for (let i = 0; i < topAmount; i++) {
            const athlete = bestSkaters[i];
            const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
            profile.appendTo(".best-skaters");
            if(gray) {
                profile.grayOut = true;
            }
        }
        fameSlideshow.updateChildren();
    }

    function initCountries(countries, gray = false){
        console.log(countries)
        const topAmount = 5;

        sortArray(countries, "score");
        for (let i = 0; i < topAmount; i++) {
            const country = countries[i];
            const profile = countryToProfile(country, Profile.CARD, true, i + 1);
            profile.appendTo(".best-countries");
            if(gray) {
                profile.grayOut = true;
            }
        }
        countrieSlideshow.updateChildren();
    }
</script>
<?php
    include_once "footer.php";
?>