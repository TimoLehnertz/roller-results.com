<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$countryName = $_GET["id"];

$country = getCountry($countryName);
if(!$country){
    throwError($ERROR_INVALID_ID);
}
// $athletes = getCountryAthletes($countryName, 10000);
// var_dump($athletes);
include_once "../header.php";

// echo "<script>let country = ". json_encode($country) .";</script>";
echo "<script>const id = '$countryName';</script>";

?>
<main class="main all-athletes">
    <h1 class="margin top left triple">All athletes from <?= $countryName?><span class="amount"></span></h1>
    <div class="loading circle"></div>
    <div class="athletes" style="overflow: auto;"></div>
    <script>
        // $(".countryName").prepend(getCountryFlag(findGetParameter("id"), 64));
        get("countryAthletes", id, 1000000).receive((succsess, athletes) => {
            if(!succsess || athletes.length === 0) {
                window.location.href = "/index.php";
            }
            $(".loading.circle").remove();
            $(".amount").text(" (" + athletes.length + ")");
            const table = new Table($(".athletes"), athletes);
            table.setup({
                rowLink: row => `/athlete?id=${row.idAthlete}`,
                layout: {
                    idAthlete: {
                        use: false
                    },
                    firstname: {
                        displayName: "First name",
                    },
                    lastname: {
                        displayName: "Last name",
                    },
                    gender: {
                        displayName: "Gender",
                    },
                    country: {
                        displayName: "Country",
                    },
                    score: {
                        displayName: "Score",
                    },
                    scoreShort: {
                        displayName: "Sprint score"
                    },
                    scoreLong: {
                        displayName: "Long score"
                    }
                },
                useAnimations: false
            });
            table.init();
        });

        // const profile = countryToProfile(country, Profile.MAX);
        // profile.appendTo("country");

        // scoreCallbacks.push(() => {
        //     profile.update();
        // });

    </script>
</main>
<?php
include_once "../footer.php";
?>