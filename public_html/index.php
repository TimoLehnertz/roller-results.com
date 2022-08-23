<?php
include_once "api/index.php";
// $indexPage = 1;
include_once "header.php";
include_once "api/imgAPI.php";

 $amountCountry = getCountryAmount();
 $amountAthlete = getAthleteAmount();
 $amountResult = getResultAmount();
// $amountRace = getRaceAmount();
// $amountCompetition = getCompetitionAmount();
 $amountVideo = getVideoAmount();

// $amountCountry = 77;
// $amountAthlete = 7602;
// $amountResult = 41744;
// $amountRace = getRaceAmount();
// $amountCompetition = getCompetitionAmount();
// $amountVideo = 513;

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
<script src="/js/d3.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.2/d3.min.js"></script> -->

<!-- < type="text/javascript" src="/js/globe/third-party/Detector.js"></> -->
<!-- < type="text/javascript" src="/js/globe/third-party/three.min.js"></> -->
<!-- < type="module" src="/js/globe/third-party/Tween.js"></> -->
<script type="module" src="/js/globe/globe.js"></script>
<main class="main index">
    <div class="message">
        <h1 class="headline">Where Inline Speedskating results come alive</h1>
        <p>
            Explore <b class="font color white">90 Years</b> of Inline Speedskating <b class="font color white">results</b> and <b class="font color white">videos</b>. Review, compare and analize your data with thousands of <b class="font color white">skaters</b> arround the globe. 
        </p>
    </div>
    <div id="container" class="globe"></div>
    <div class="dates" style="height: 170px"></div>
    <div class="lower">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
        <div class="content">
            <div class="amounts">
                <div class="pc-only"><div><?= $amountCountry?></div><div>Countries</div></div>
                <div><div><?= $amountResult?></div><div>Results</div></div>
                <div><div><?= $amountVideo?></div><div>Videos</div></div>
                <div class="pc-only"><div><?= $amountAthlete?></div><div>Athletes</div></div>
            </div>
            <!-- <hr>
            <a href="/competition/?id=400&name=Ibagué" class="padding top bottom triple align center pc-only"><h1>Daily updated results from worlds in Ibagué!</h1></a>
            <a href="/competition/?id=400&name=Ibagué" class="padding top bottom triple align center mobile-only"><h3>Results from  Ibagué!</h3></a>
            <hr> -->
            <h2></h2>
            <p class="head-paragraph align center">
                <span><b>Data</b> and <b>results</b> are the best basis for progress in elite sport</span><br>
                <br><span><b>Inline speedskating</b> has no central point for results collection</span><br>
                <br><span style="color: #222">We're here to fix that!</span>
            </p>
            <div class="dark section align center" style="background-color: #3b0d20">
                <h2 class="font">Call for action!</h2>
                <p class="font size big">By the comunity for the comunity!</p>
                <br>
                <p>
                    If you can get results from somewhere and could get them into this format it would mean a lot.<br>We will upload all results that will be send by the comunity
                </p>
                <br>
                <h3>Our format: <a href="/tools/import-preset.xlsx">Download link</a></h2>
                <h3>please read the documentation <a href="/tools/import-project.php">here</a></h3>
                <img src="/img/rr-format.jpg" style="width: 100%">
            </div>
            <div class="dark section align center padding top bottom quintuple">
                <h2>Results from as far back as 1935!</h2>
                <p>
                    we have dug up the internet for every bit of skating result so you dont need to
                </p>
            </div>
            <div class="light section">
                <div class="flex mobile">
                    <ul>
                        <h2>Professional analytic tools</h2>
                        <li>Use your our graphical query tool to gain full access to the database</li>
                        <li>Chain queries to make complex analytics</li>
                        <li>Log in to save and share your ideas</li>
                        <li><a href="analytics">Anayltics</a></li>
                        <li><a href="articles/500m">Specific 500m analytics</a></li>
                        <li><a href="articles/teamAdvantage">Team analytics</a></li>
                    </ul>
                    <a href="analytics" class="no-underline">
                        <img src="img/analytics.JPG" alt="analytics preview" style="max-height: 55vh; ">
                    </a>
                </div>
            </div>
            <div class="dark section flex mobile">
                <h2>500+ Videos</h2>
                <ul>
                    <li>
                        Anytime you see this <i class="fab fa-youtube"></i> Icon there will be a video availbale for the race / competition
                    </li>
                    <li>
                        Search for a race or competition and find lots of videos
                    </li>
                </ul>
            </div>
            <div class="light section flex mobile">
                <ul>
                    <li><h2>Roller results helmet camera</h2></li>
                    <li>Live HD video transmission from within the race</li>
                    <li>Tested at Arena Geisingen international</li>
                    <li>Closer than ever before</li>
                </ul>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/mbBqht0JtGE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="dark section globe-section">
                <div class="globe-flex">
                    <div>
                        <h2>Roller globe</h2>
                        <ul>
                            <h3 class="margin bottom">Ever wondered what that globe with its lines stands for?</h3>
                            <li>Every line represents a country wich participated in a competition</li>
                            <li>Hover the lines to see who traveled where and when</li>
                            <li>Drag the timeline to travel back and forth in time</li>
                        </ul>
                    </div>
                    <!-- <div id="mini-globe"></div> -->
                    <img src="/img/globe/globe.jpg" alt="globe preview">
                </div>
            </div>
            <div class="light section">
                <h2>Athlete profiles</h2>
                <div class="profile-showcase">
                    <div class="profile-left">
                        <ul>
                            <li>Review all important information in seconds</li>
                            <li>See all your competitions and competitors</li>
                            <li>Check your career graph and see how others have performed</li>
                            <li>Check your best times</li>
                        </ul>
                        <p class="pc-only margin top triple color gray">Hover over anything on the profile to get hints</p>
                    </div>
                    <div class="profile-section-profile-a">
                        <script>
                            $(".profile-section-profile-a").append(Profile.getPlaceholder(Profile.CARD));
                            get("athlete", 6606).receive((succsess, athlete) => {//chad
                                const p = athleteToProfile(athlete, Profile.CARD);
                                $(".profile-section-profile-a").empty();
                                p.appendTo(".profile-section-profile-a");
                            });
                        </script>
                    </div>
                </div>
            </div>
            
            <div class="dark">
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
            <div class="light section">
                <h2>Country profiles</h2>
                <div class="profile-showcase">
                    <div class="profile-left">
                        <ul>
                            <li>Review all important information in seconds</li>
                            <li>See all your competitions and competitors</li>
                            <li>Check your career graph and see how others have performed</li>
                            <li>Check your best times</li>
                        </ul>
                        <p class="pc-only margin top triple color gray">Hover over anything on the profile to get hints</p>
                    </div>
                    <div class="profile-section-profile-c">
                        <script>
                            $(".profile-section-profile-c").append(Profile.getPlaceholder(Profile.CARD));
                            get("country", "Italy").receive((succsess, athlete) => {//chad
                                const p = countryToProfile(athlete, Profile.CARD);
                                $(".profile-section-profile-c").empty();
                                p.appendTo(".profile-section-profile-c");
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="dark">
                <div class="best-countries">
                    <a class="no-underline" href="/hall-of-fame/index.php">
                        <div class="index-card">
                            <h2>Top countries</h2>
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
            <div class="light section align center">
                <h2>And the best is yet to come:<br>it's all free and open source!</h2>
                <button class="btn only-text" onclick="easterEgg()"><img src="/img/easter-egg.png" style="max-width: 2rem"></button>
                <p>
                    We commit this site to the amazing inline speedskating comunity!
                </p>
                <p>
                    The whole sourcecode for this website is<br>available on <a target="_blank" rel="noopener noreferrer" href="https://github.com/TimoLehnertz/roller-results.com" class="no-underline"><i class="fab fa-github"></i> Gihub</a>
                    for you to check out.
                </p> 
                <p>
                    Any support is appreciated and you can<br> ask us anything you want. See The <a href="/impressum/contact.php">Contact</a> <br>section for ways to reach out to us.
                </p>
            </div>
        </div>
    </div>
</main>
<script>
    // $(easterEgg);

    function easterEgg() {
        $(".lower").css("display", "none");
        $(".footer").css("display", "none");
        $(".header").css("display", "none");
        $(".message").css("display", "none");
        $(".globe").addClass("center");
        if(isMobile()) {
            $(".dates").css("transform", "translateY(-10rem)");
        } else {
            $(".dates").css("transform", "translateY(20rem)");
        }
    }
</script>
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

    let container = document.getElementById( 'container' );
    let globe = new DAT.Globe( container );

    // let miniGlobeContainer = document.getElementById('mini-globe');
    // let miniGlobe = new DAT.Globe(miniGlobeContainer);
    // window.setInterval(() => {
    //     miniGlobe.render();
    // }, 100);
    // miniGlobe.initSurfaceDots();

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

    getFile("/json/worldMovement1.json").receive((succsess, response) => {
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
    medalCallbacks.push(update);
    
    const fameSlideshow = new Slideshow($(".best-skaters"));
    const countrieSlideshow = new Slideshow($(".best-countries"));
    initGet();

    /**
     * placeholders
     */
    const topAmount = 5;
    const placeholders = [{},{},{},{},{},];
    
    // const bestSkaters = JSON.parse(`[{"idAthlete":6666,"lastname":"Kalbe","firstname":"Evelyn","gender":"w","country":"Germany","comment":null,"club":null,"team":null,"image":null,"birthYear":null,"facebook":null,"instagram":null,"minAge":null,"raceCount":5,"fullname":"Evelyn Kalbe","topTen":"0","bronze":"0","silver":"0","gold":"0","medalScore":"0","score":0,"scoreShort":0,"scoreLong":0,"competitionCount":3,"bestDistance":"5000m RELAY"},{"idAthlete":1973,"lastname":"Swings","firstname":"Bart","gender":"M","country":"Belgium","comment":null,"club":null,"team":null,"image":"athlete-Bart-Swings-60787b453f7de5.00907222.jpg","birthYear":null,"facebook":null,"instagram":null,"minAge":null,"raceCount":147,"fullname":"Bart Swings","topTen":"10","bronze":"0","silver":"3","gold":"4","medalScore":"18","score":859.903438102628,"scoreShort":79.63600487051022,"scoreLong":780.2674332321178,"competitionCount":25,"bestDistance":"10000m Points\/Elimination"},{"idAthlete":1267,"firstname":"Joey","lastname":"Mantia","gender":"M","country":"United States of America","score":1482.3668188739332,"scoreShort":599.3805944581916,"scoreLong":882.9862244157414},{"idAthlete":1213,"firstname":"Francesca","lastname":"Lollobrigida","gender":"W","country":"Italy","score":1249.4311495760683,"scoreShort":182.65037745054562,"scoreLong":1066.7807721255222},{"idAthlete":1410,"firstname":"Andres Felipe","lastname":"Mu\u00f1oz","gender":"M","country":"Colombia","score":1212.6462006353472,"scoreShort":677.0707360876484,"scoreLong":535.5754645476989}]`);
    // initBestSkaters(bestSkaters);

    for (let i = 0; i < topAmount; i++) {
        $(".best-skaters").append(Profile.getPlaceholder(Profile.CARD));
        $(".best-countries").append(Profile.getPlaceholder(Profile.CARD));
    }

    function initGet(){
        get("hallOfFame").receive((succsess, bestSkaters) => {
            if(succsess) {
                clearBestSkaters();
                initBestSkaters(bestSkaters);
            } else{
                alert("An error occoured :/");
            }
        });
        get("countries").receive((succsess, countries) => {
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

    
    function initBestSkaters(bestSkaters){
        for (let i = 0; i < topAmount; i++) {
            if(i >= bestSkaters.length) break;
            const athlete = bestSkaters[i];
            const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
            profile.update = function() {this.grayOut = true};
            profile.appendTo(".best-skaters");
        }

        if(bestSkaters.length === 0) {
            $(".best-skaters").append(`<h3 class="margin top triple">Select Competitions in the settings to calculate the hall of fame</h3>`);
        }

        fameSlideshow.updateChildren();
    }

    function initCountries(countries) {
        const topAmount = 5;

        sortArray(countries, "score");
        for (let i = 0; i < topAmount; i++) {
            if(i >= countries.length) break;
            const country = countries[i];
            const profile = countryToProfile(country, Profile.CARD, true, i + 1);
            profile.update = function(){this.grayOut = true};
            profile.appendTo(".best-countries");
        }
        if(countries.length === 0) {
            $(".best-countries").append(`<h3 class="margin top triple">Select Competitions in the settings to calculate countries</h3>`);
        }
        countrieSlideshow.updateChildren();
    }
</script>
<?php
    include_once "footer.php";
?>