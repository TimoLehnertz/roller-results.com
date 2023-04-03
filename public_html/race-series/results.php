<?php
include_once "../includes/error.php";
if(!isset($_GET["id"])) {
    throwError($ERROR_NO_ID, "/race-series");
}
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$id = $_GET["id"];

$raceSeries = getRaceSeries($id);

if(sizeof($raceSeries) == 0) {
    throwError($ERROR_INVALID_ID, "/race-series");
    exit();
}

if(isset($_GET["calculate"]) && $_GET["calculate"] == "1") {
    if(calculateRaceSeries($id)) {
        header("location: results.php?id=$id&calculate-succsess");
    } else {
        header("location: results.php?id=$id");
    }
}

function echoRace($race) {
    $link = "/race/index.php?id=".$race["id"];
    echo "
    <a href='$link'>
    ".$race["location"]." ".$race["distance"]." ".$race["category"]." ".$race["gender"]."
    </a>";
}

include_once "../header.php";
echoRandWallpaper();
?>
<script>
    const raceSeries = <?=json_encode($raceSeries)?>;
</script>
<main class="main competitions-page">
    <div class="top-site">
        
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="comps">
        <h1 class="align center font color gray size biggest"><?=$raceSeries["name"]?> <?=$raceSeries["year"]?></h1>
        <?php if(isAdmin()) {?>
        <div class="flex align-center">
            <a href="results.php?id=<?=$id?>&calculate=1" class="btn blender alone no-underline">Calculate points</a>
            <!-- <button onclick="addRaces()" class="manage-button btn blender alone">Manage</button> -->
        </div>
        <?php } ?>
        <br>
    <section class="dark-section">
    </div>
        <?php if(sizeof($raceSeries["races"]) > 0) { ?>
            <p class='margin left top'>
            <h2>Races:</h2>
            <br>
            <div class="margin left">
                <details>
                    <summary>All races</summary>
                    <?php
                        foreach($raceSeries["races"] as $race) {
                            echoRace($race);
                            echo "<br>";
                        }
                    ?>
                </details>
            </div>
            </p>
            <br>
            <h2>Results</h2>
            <div class="category-select padding left right bottom">
                <p class="flex margin bottom">Categories:</p>
                <div class="form-radio categories flex wrap justify-center gap">
                </div>
            </div>
            <div class="gender-select padding left right bottom">
                <div class="form-radio flex wrap justify-start gap">
                    <input class="gender-input" type="radio" id="men" name="gender" checked>
                    <label for="men">Men</label>
                    <input class="gender-input" type="radio" id="women" name="gender">
                    <label for="women">Women</label>
                </div>
            </div>
            <div class="series-results"></div>
        <?php } else { ?>
            <p>No races participate at this race series yet. Check by later</p>
        <?php } ?>
    </section>
</main>
<script>
    let ctrlPressed = false;
    $(document).on('keyup keydown', function(e){ctrlPressed = e.ctrlKey} );
    function sortCategories(categories) {
        return categories.sort((a,b) => (indexFromCategory(a) - indexFromCategory(b)) * 100 - compareStrings(b, a));
    }
    $('.gender-input').change(() => {
        initTable(getBannedCategories());
    });
    // let useCategory = true;
    categories = [];
    const agePlaces = [];
    for (const row of raceSeries.results) {
        row.originalAthlete = row.athlete;
        row.athlete = {
            data: athleteToProfile(row.athlete, Profile.MIN),
            type: "profile",
        };
        if(row.category !== null) {
            if(!categories.includes(row.category.replace(/ /g,'')))categories.push(row.category.replace(/ /g,''));
            // useCategory = true;
        }
        const agePlaceIndex = `${row.originalAthlete.gender.toLowerCase()}${row.category.toLowerCase()}`;
        if(agePlaces[agePlaceIndex] === undefined) {
            agePlaces[agePlaceIndex] = 1;
        } else {
            agePlaces[agePlaceIndex]++;
        }
        row.placeCategory = agePlaces[agePlaceIndex];
    }
    categories = sortCategories(categories);
    if(categories.length > 1) {
        categories.unshift("All");
        for (const category of categories) {
            $(".categories").append(`<input type="checkbox" class="category" name="category" value="${category}" id="${category}" ${category === 'All' ? 'checked' : ''}><label for="${category}">${category}</label>`);
            $(".categories").find(`#${category}`).on("change", (elem) => {
                const checked = $(`#${category}`).is(':checked');
                if(category !== 'All' && checked) {
                    $('#All').prop('checked', false);
                    if(!ctrlPressed) {
                        $('.category').not(`#${category}`).prop('checked', false);
                    }
                }
                if(!$('#All').is(':checked') && getBannedCategories().length === categories.length) {
                    $('#All').prop('checked', true).change();
                    return;
                }
                if(category === 'All' && checked) {
                    initTable();
                    $('.category').not('#All').prop('checked', false);
                    return;
                } else {
                    initTable(getBannedCategories());
                }
            });
        }
    } else {
        $('.category-select').hide();
    }

    function getBannedCategories() {
        if($('#All').is(':checked')) return [];
        const bannedCategories = [];
        $(".category").each((i, elem) => {
            const checked = $(elem).is(":checked");
            const category = $(elem).val();
            if(!checked) {
                bannedCategories.push(category);
            }
        });
        return bannedCategories;
    }

    function initTable(bannedCategories = []) {
        console.log(1);
        const men = $('#men').is(':checked');
        const tableData = [];
        for (const result of raceSeries.results) {
            if(result.originalAthlete.gender.toLowerCase() !== (men ? 'm' : 'w')) continue;
            if(!result.category || !bannedCategories.includes(result.category.replace(/ /g,''))) {
                tableData.push(result);
            }
        }
        $(".series-results").empty();
        const table = new Table($(".series-results"), tableData, "series-results");
        const tableLayout = {
            placeOverall: {
                displayName: "#Overall"
            },
            placeCategory: {
                displayName: "#Category"
            },
            athlete: {
                displayName: "Athlete",
                allowSort: false,
            },
            category: {
                displayName: "Category",
                // use: useCategory
            },
            pointsOverall: {
                displayName: "Overall points",
            },
            pointsCategory: {
                displayName: "Category points",
                // use: useCategory
            },
        };
        for (const row of tableData) {
            for (const key in row) {
                if (!Object.hasOwnProperty.call(row, key)) continue;
                const element = row[key];
                if(!Number.isInteger(element)) continue;
                if(tableLayout[key] !== undefined) continue;
                tableLayout[key] = {
                    displayName: key
                };
            }
        }
        table.setup({
            layout: tableLayout
        });
        table.init();
    }
    
    // $(() => {
        initTable();
    // });
</script>
<?php
include_once "../footer.php";
?>