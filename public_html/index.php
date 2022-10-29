<?php
$noHeaderSearchBar = true;
include_once "header.php";
include_once "api/index.php";

$searchString = "";
$searching = false;
if(isset($_GET["q"]) && !empty($_GET["q"])) {
    $searchString = $_GET["q"];
    $searching = true;
}
?>
<script>let resultsFound = false;</script>
<main class="main search-page <?=$searching ? "searching" : ""?>">
    <form action="" method="GET" onsubmit="return validateForm()">
        <?php if(!$searching) { ?>
            <h1 class="search-logo noselect">Roller results</h1>
        <?php } ?>
        <div class="wrapper">
            <div class="google-search-bar">
                <label for="search-input">
                    <div class="search">
                        <div class="search-icon">
                            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                        </div>
                        <input <?=$searching ? "" : "autofocus"?> type="text" name="q" value="<?=htmlentities($searchString)?>" spellcheck="false" autocomplete="off" id="search-input" placeholder="Search skaters, countries, events, years..." title="Suche">
                        <svg class="x invisible" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                    </div>
                </label>
                <div class="history"></div>
            </div>
        </div>
       <?php if(!$searching) { ?>
       <div class="buttons align center margin top double">
           <input type="submit" class="btn google margin right search-btn" value="Search">
           <a class="btn google no-link-style" href="/home/index.php">Home</a>
       </div>
       <?php } ?>
       <div></div>
       <?php if($searching) {
            $searchResults = search($searchString, "Year,Team,Competition,Athlete,Country");
            if(sizeof($searchResults) == 0) {
                echo "<div class='margin left top double'><p>No Results matching your search query - ".$searchString." - were found.</p>
                <br>
                <p>You can search for:</p>
                <br>
                <ul>
                <li>Athletes</li>
                <li>Countries</li>
                <li>Competitions</li>
                <li>Races</li>
                <li>Years</li>
                <li>Teams</li>
                <li>Locations</li>
                </ul></div>";
            } else { ?>
                <script>resultsFound = true;</script>
                <br>
                <div class='filters'>
                    <input type='radio' name="filter" value="all" id="all" class="invisible" checked>
                    <label class="filter "for='all'><div class="search-icon">
                            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                        </div>All</label>
                    <input type='radio' name="filter" value="person" id="athletes" class="invisible">
                    <label class="filter" for='athletes'>Athletes</label>
                    <input type='radio' name="filter" value="competition" id="competitions" class="invisible">
                    <label class="filter" for='competitions'>Competitions</label>
                    <input type='radio' name="filter" value="country" id="countries" class="invisible">
                    <label class="filter" for='countries'>Countries</label>
                    <input type='radio' name="filter" value="team" id="teams" class="invisible">
                    <label class="filter" for='teams'>Teams</label>
                </div>
                <br>
                <div class='search-results'>
                <?php
                foreach ($searchResults as $result) {
                    echo "<div href='".$result["link"]."' class='search-result ".$result["type"]." all'>";
                    echo "<a href='".$result["link"]."'>".$result["name"]."</a>";
                    echo "</div>";
                }
                echo "</div>";
            }
            // print_r($searchResults);
        } else { ?>
        <div class="text">
            <p>Search the biggest Inline Speedskating database</p>
        </div>
        <?php } ?>
</form>
</main>
<script>
    let history = localStorage.getItem("searchHistory");
    if(!history) history = "[]";
    history = JSON.parse(history);
    let filterSet = false;

    if(resultsFound) {
        let q = decodeURI(findGetParameter("q"));
        q = q.replace("+", " ");
        for (let i = 0; i < history.length; i++) {
            const element = history[i];
            if(element.text.toLowerCase() == q.toLowerCase()) {
                history.splice(i, 1);
            }
        }
        history.unshift({text: q});
        localStorage.setItem("searchHistory", JSON.stringify(history));
    }

    updateHistory();
    function updateHistory() {
        $(".history").empty();
        for (const action of history) {
            const elem = $(`<a class="entry" href="/?q=${action.text}"><span>${action.text}</span><svg class="" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg></a>`)
            elem.find("svg").click((e) => {
                e.stopPropagation();
                e.preventDefault();
                history.splice(history.indexOf(action), 1);
                localStorage.setItem("searchHistory", JSON.stringify(history));
                updateHistory();
            });
            $(".history").append(elem);
        }
    }

    $("#search-input").keydown((e) => {
        if(e.key == "ArrowDown") {
            if($(".history .active").length == 0) {
                $(".history .entry").first().addClass("active");
            } else {
                $(".active").next().addClass("active");
                $(".active").first().removeClass("active");
            }
            $("#search-input").val($(".active").text());
            e.preventDefault();
        }
        if(e.key == "ArrowUp") {
            $(".active").prev().addClass("active");
            $(".active").last().removeClass("active");
            $("#search-input").val($(".active").text());
            e.preventDefault();
        }
    });
    $("#search-input").on("click", openHistory);
    $("#search-input").on("input", () => $(".search .x").toggleClass("invisible", $("#search-input").val().length == 0));
    $("#search-input").trigger("input");
    $(document).on("click", closeHistory);
    $(".x").click(() => $("#search-input").val("").focus().trigger("input"));

    $("input[type='radio']").change(() => {
        let filter = $("input[name='filter']:checked").val();
        $(".search-result").show();
        $(".search-result").not("." + filter).hide();
        window.history.replaceState({}, filter, `?q=${findGetParameter("q")}&filter=${parseFilter(filter)}`);
        // if(!filterSet) {
        //     insertParam("filter", filter);
        // }
        // filterSet = false;
    });

    function openHistory(e) {
        $(".google-search-bar").addClass("history-open");
        if(history.length == 0) return;
        e.stopPropagation();
    }
    function closeHistory() {
        $(".google-search-bar").removeClass("history-open");
    }

    function validateForm() {
        const succsess =  $("#search-input").val().length > 0;
        // const search = $("#search-input").val();
        // if(succsess) {
        //     history.unshift({text: search});
        //     history.splice(10);
        //     localStorage.setItem("searchHistory", JSON.stringify(history));
        // }
        return succsess;
    }

    const filter = findGetParameter("filter");
    if(filter) {
        filterSet = true;
        // console.log(parseFilter(filter));
        $(`#${parseFilter(filter)}`).prop("checked", true);
    }

    function parseFilter(filter) {
        switch(filter) {
            case "person": return "athletes";
            case "competition": return "competitions";
            case "country": return "countries";
            case "team": return "teams";
        }
        return filter;
    }
</script>
<?php
$darkFooter = true;
include_once "footer.php";
?>