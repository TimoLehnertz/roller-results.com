<?php
include_once "../api/index.php";

$message = "";

if(isset($_GET["s"])) {
    $message = "Succsessfully added your place";
}
if(isset($_GET["e"])) {
    $message = "<span class='font color red'>Could not add place. Please try again</span>";
}

if(validateObjectProperties($_POST, [
[
    "property" => "submit",
    "value" => "1"
], [
    "property" => "title",
    "type" => "string",
    "maxLength" => 200
], [
    "property" => "description",
    "type" => "string",
    "maxLength" => 2000
], [
    "property" => "latitude",
    "type" => "text",
], [
    "property" => "longitude",
    "type" => "text",
], [
    "property" => "contact",
    "required" => false,
    "type" => "text",
    "maxLength" => 500
], [
    "property" => "size",
    "required" => false,
    "type" => "text",
], [
    "property" => "coating",
    "required" => false,
    "type" => "text",
    "maxLength" => 1000
], [
    "property" => "clubName",
    "required" => false,
    "type" => "text",
    "maxLength" => 1000
], [
    "property" => "website",
    "required" => false,
    "type" => "text",
    "maxLength" => 1000
], [
    "property" => "corner",
    "required" => false,
    "type" => "text",
    "maxLength" => 100
], [
    "property" => "videoLink",
    "required" => false,
    "type" => "text",
    "maxLength" => 1000
], [
    "property" => "famousPeople",
    "required" => false,
    "type" => "text",
    "maxLength" => 1000
]
], false)) {
    if(uploadPlace($_POST["idPlace"] ?? NULL, $_POST["title"], $_POST["description"] ?? NULL, $_POST["latitude"], $_POST["longitude"], $_POST["contact"] ?? NULL, $_POST["size"] ?? NULL, $_POST["coating"] ?? NULL, $_POST["clubName"] ?? NULL, $_POST["website"] ?? NULL, $_POST["corner"] ?? NULL, $_POST["videoLink"] ?? NULL, $_POST["famousPeople"] ?? NULL, $_POST["coatingYear"] ?? NULL)) {
        header("location: /track-map/index.php?s=1");
        exit();
    } else {
        header("location: /track-map/index.php?e=1");
        exit();
    }
}
$leaflet = true; // enable leafleft
include_once "../header.php";
?>
<main>
    <section class="section light">
        <h1>Track map</h1>
    </section>
    <section class="section dark">
        <div class="flex mobile gap">
            <div>
                <?php if(isLoggedIn()) { ?>
                <form action="#" method="POST" class="form" id="form">
                    <p class="font color green"><?=$message?></p>
                    <h3 class="form-description">Add a track</h3>
                    <button type="button" class="btn create gray add-track-btn" onclick="activateAddTrack()">Add a track instead</button>
                    <input type="number" name="idPlace" value="-1" hidden>
                    <div>
                        <label for="lng">Title</label>
                        <input type="text" name="title" id="title" maxlength="200" required>
                    </div>
                    <div>
                        <label for="description">Description</label><br>
                        <textarea name="description" id="description" rows="3" maxlength="2000" placeholder="Give this track a meaningful description"></textarea>
                    </div>
                    <div class="flex gap">
                        <div>
                            <label for="latitude">Latitude</label>
                            <input type="number" step="0.000000000000000001" name="latitude" id="latitude" required>
                            <label for="longitude">Longitude</label>
                            <input type="number" step="0.000000000000000001" name="longitude" id="longitude" required>
                        </div>
                        <p><button type="button" class="btn create gray gray pickBtn" onclick="pick()">Map</button></p>
                    </div>
                    <div>
                        <label for="contact">Contact</label>
                        <input type="text" maxlength="500" name="contact" id="contact">
                    </div>
                    <div>
                        <label for="size">Size (meters)</label>
                        <input type="number" step="0.01" name="size" id="size">
                    </div>
                    <div class="flex gap align-center">
                        <div>
                            <label for="coating">Coating</label>
                            <select name="coating" id="coating">
                                <option value="">Select</option>
                                <option value="Asphalt">Asphalt</option>
                                <option value="Vesmaco">Vesmaco</option>
                                <option value="ATP">ATP</option>
                                <option value="Courtsal">Courtsal</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div style="margin: 0; padding: 0">
                            <label for="corner">Corner</label>
                            <select name="corner" id="corner">
                                <option value="">Select</option>
                                <option value="flat">Flat</option>
                                <option value="banked">Banked</option>
                                <option value="parabolic">Parabolic</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="coatingYear">Year of coating</label>
                        <input type="number" name="coatingYear" id="coatingYear">
                    </div>
                    <div>
                        <label for="clubName">Club name</label>
                        <input type="text" maxlength="1000" name="clubName" id="clubName">
                    </div>
                    <div>
                        <label for="website">Website</label>
                        <input type="text" maxlength="1000" name="website" id="website">
                    </div>
                    <div>
                        <label for="famousPeople">Famous people</label>
                        <input type="text" maxlength="1000" name="famousPeople" id="famousPeople">
                    </div>
                    <div class="flex">
                        <button type="reset" class="btn create gray">Reset</button>
                        <button type="submit" name="submit" value="1" class="btn create green save-btn">Upload</button>
                    </div>
                </form>
                <?php } else { ?>
                <form action="/login/index.php" method="POST">
                    <input type="text" name="returnTo" value="<?=$_SERVER["REQUEST_URI"]?>" hidden></input>
                    <button type="submit" name="submit" value="1" class="btn create">Log in</button> to upload your own tracks!
                </form>
                <?php } ?>
            </div>
            <div class="map-section">
                <div class="filters flex mobile justify-center gap">
                    <p class="font size big">Filters:</p>
                    <div>
                        <label for="filter-coating">Coating</label>
                        <select id="filter-coating">
                            <option value="any" selected>Any</option>
                            <option value="Asphalt">Asphalt</option>
                            <option value="Vesmaco">Vesmaco</option>
                            <option value="ATP">ATP</option>
                            <option value="Courtsal">Courtsal</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter-corner">Corner</label>
                        <select id="filter-corner">
                            <option value="any" selected>Any</option>
                            <option value="Flat">Flat</option>
                            <option value="Banked">Banked</option>
                            <option value="Parabolic">Parabolic</option>
                        </select>
                    </div>
                    <button class="btn create" onclick="applyFilters()">Apply</button>
                </div>

                <div id="map"></div>
            </div>
    </section>
    <section class="section light">
        <div class="see-more"></div>
    </section>
    </div>
</main>
<style>
#map { height: 500px; }
#map { min-width: 800px; }
</style>
<script>
const places = <?=json_encode(getPlaces())?>;

var lat = localStorage.mapLat;
var lng = localStorage.mapLng;
var mapZoomLevel = localStorage.mapZoomZevel;
if (isNaN(mapZoomLevel)) mapZoomLevel = 12;
if (isNaN(lat)) lat = 48.84657280281416;
if (isNaN(lng)) lng = 2.355129718780518;
var map = L.map('map').setView([lat, lng], mapZoomLevel);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

for (const place of places) {
    for (const key in place) {
        if (Object.hasOwnProperty.call(place, key)) {
            place[key] = decodeEntities(place[key]);
        }
    }
    if(!place.latitude || !place.longitude) continue;
    var marker = L.marker([place.latitude, place.longitude]).addTo(map);
    let html = `<p>${place.title}</p>`;
    if(place.coating) html += `<p>${place.coating }</p>`;
    if(place.website) html += `<a href="${place.website}">Website</a>`;
    if(place.coating) html += `<p>Coating ${place.coating}</p>`;
    if(place.famousPeople) html += `<p>Famous people ${place.famousPeople}</p>`;
    // if(place.creator == phpUser.iduser) {
        html += `<button class="btn create gray margin right" onclick="edit(${place.idPlaces})">Edit</button>`
    // }
    html += `<button class="btn create gray" onclick="seeMore(${place.idPlaces})">See more</button>`
    place.marker = marker;
    marker.bindPopup(html);
    place.marker = marker;
}

console.log(places);

map.addEventListener('moveend', function(e) {
    localStorage.mapZoomZevel = map.getZoom();
});
map.on('mouseup', function(ev){
    let coordinates = map.mouseEventToLatLng(ev.originalEvent);
    console.log(coordinates.lat + ', ' + coordinates.lng);
    localStorage.mapLat = coordinates.lat;
    localStorage.mapLng = coordinates.lng;
});

let lat1 = 0;
let lng1 = 0;

let picking = false;
map.addEventListener('mousemove', function(ev) {
    if(!picking) return;
    lat1 = ev.latlng.lat;
    lng1 = ev.latlng.lng;
    $("#latitude").val(lat1);
    $("#longitude").val(lng1);
});
let addMarker;
map.addEventListener('click', function(ev) {
    if(!picking) return;
    $(".pickBtn").removeClass("green");
    $(".pickBtn").addClass("gray");
    addMarker = L.marker([lat1, lng1]);
    map.addLayer(addMarker);
    picking = false;
});
function pick() {
    $(".pickBtn").removeClass("gray");
    $(".pickBtn").addClass("green");
    if(addMarker) map.removeLayer(addMarker);
    picking = true;
}

function getPlaceById(idPlace) {
    for (const place of places) {
        if(place.idPlaces == idPlace) return place;
    }
}

function seeMore(idPlace) {
    const p = getPlaceById(idPlace);
    if(!p) return;
    $(".see-more").empty();
    $(".see-more").append(`<h2>${p.title}</h2>`);
    $(".see-more").append(`<p>${p.description}</p>`);
    $(".see-more").append(`<p>Coating: ${p.coating ?? "-"}</p>`);
    $(".see-more").append(`<p>Year of coating: ${p.coatingYear ?? "-"}</p>`);
    $(".see-more").append(`<p>size: ${p.website ?? "-"}</p>`);
    $(".see-more").append(`<p>Club name: ${p.clubName ?? "-"}</p>`);
    $(".see-more").append(`<p>Corner: ${p.corner ?? "-"}</p>`);
    if(p.videoLink) {
        $(".see-more").append(`<a href="${p.videoLink}">Video link</a>`);
    }
    $(".see-more").append(`<p>Famous people: ${p.famousPeople ?? "-"}</p>`);
    $(".see-more")[0].scrollIntoView({block: "center", inline: "nearest"});
    const editBtn = $(`<button class="btn create blue">Edit information</button>`);
    $(".see-more").append(editBtn);
    if(p.creator == phpUser.iduser) {
        const delBtn = $(`<button class="btn create red">Delete this place</button>`);
        delBtn.click(() => {
            $(".see-more").append(`<div class="loading circle"></div>`);
            set("deletePlace", {id: p.idPlaces}).receive((res) => {
                $(".see-more .loading").remove();
                if(res != "succsess") return alert("could not remove place. reason: " + res);
                $(".see-more").empty();
                map.removeLayer(p.marker);
            });
        });
        editBtn.click(() => {
            edit(idPlace);
        })
        $(".see-more").append(delBtn);
    }
    if(!p.clubName || p.clubName.length == 0) return;
    get("clubAthletes", p.clubName).receive((succsess, athletes) => {
        if(!succsess) return;
        const athletesWrapper = $(`<div class="grid four"><p>Club athletes:</p></div>`);
        for (const athlete of athletes) {
            const profile = new Profile(athleteDataToProfileData({id: athlete.id, firstname: athlete.firstname, lastname: athlete.lastname}), Profile.MIN);
            profile.update();
            profile.appendTo(athletesWrapper);
        }
        $(".see-more").append(athletesWrapper);
        console.log(athletes);
    });
}

function edit(idPlace) {
    const place = getPlaceById(idPlace);
    if(!place) return false;
    $(".form-description").text(`Edit ${place.title}`);
    $(".add-track-btn").show();
    $(".save-btn").text("Save changes");
    $("#idPlace").val(place.idPlace);

    $(".form").get()[0].scrollIntoView();
    for (const key in place) {
        if (Object.hasOwnProperty.call(place, key)) {
            $(`#${key}`).val(place[key]);
        }
    }
    return true;
}

function activateAddTrack() {
    $(".add-track-btn").hide();
    $(".form-description").text(`Add a track`);
    $("#idPlace").val("-1");
    $(".save-btn").text("Upload");
    document.getElementById('form').reset();
}

function showAll() {
    for (const place of places) {
        map.removeLayer(place.marker);
        map.addLayer(place.marker);
    }
}

function applyFilters() {
    const coating = $("#filter-coating").val();
    const corner = $("#filter-corner").val();
    showAll();
    for (const place of places) {
        const marker = place.marker;
        if(coating != "any" && place.coating?.toLowerCase() != coating.toLowerCase()) {
            map.removeLayer(marker);
        }
        if(corner != "any" && place.corner?.toLowerCase() != corner.toLowerCase()) {
            map.removeLayer(marker);
        }
    }
}
</script>
<?php
include_once "../footer.php";
?>