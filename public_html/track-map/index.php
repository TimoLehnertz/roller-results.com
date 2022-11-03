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
    "property" => "lat",
    "type" => "text",
], [
    "property" => "lng",
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
]
], true)) {
    if(uploadPlace($_POST["title"], $_POST["description"] ?? NULL, $_POST["lat"], $_POST["lng"], $_POST["contact"] ?? NULL, $_POST["size"] ?? NULL, $_POST["coating"] ?? NULL, $_POST["clubName"] ?? NULL, $_POST["website"] ?? NULL)) {
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
                <form action="#" method="POST" class="form">
                    <p class="font color green"><?=$message?></p>
                    <div>
                        <label for="lng">Title</label>
                        <input type="text" name="title" id="title" maxlength="200" required>
                    </div>
                    <div>
                        <label for="description">Description</label><br>
                        <textarea name="description" id="description" rows="3" maxlength="2000" placeholder="Give this track a meaningful description"></textarea>
                    </div>
                    <div>
                        <label for="lat">Latitude</label>
                        <input type="number" step="0.000000000000000001" name="lat" id="lat" required>
                    </div>
                    <div>
                        <label for="lng">Longitude</label>
                        <input type="number" step="0.000000000000000001" name="lng" id="lng" required>
                    </div>
                    <div>
                        <p><button type="button" class="btn create gray gray pickBtn" onclick="pick()">Pick on map</button></p>
                    </div>
                    <div>
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="contact">
                    </div>
                    <div>
                        <label for="size">Size (meters)</label>
                        <input type="number" step="0.01" name="size" id="size">
                    </div>
                    <div>
                        <label for="coating">Coating</label>
                        <input type="text" name="coating" id="coating">
                    </div>
                    <div>
                        <label for="clubName">Club name</label>
                        <input type="text" name="clubName" id="clubName">
                    </div>
                    <div>
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website">
                    </div>
                    <div class="flex">
                        <button type="submit" name="submit" value="1" class="btn create green">Upload</button>
                    </div>
                </form>
                <?php } else { ?>
                <form action="/login/index.php" method="POST">
                    <input type="text" name="returnTo" value="<?=$_SERVER["REQUEST_URI"]?>" hidden></input>
                    <button type="submit" name="submit" value="1" class="btn create">Log in</button> to upload your own tracks!
                </form>
                <?php } ?>
            </div>
            <div id="map"></div>
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

console.log(places);
for (const place of places) {
    if(!place.latitude || !place.longitude) continue;
    var marker = L.marker([place.latitude, place.longitude]).addTo(map);
    let html = `<p>${place.title}</p>`;
    if(place.coating) {
        html += `<p>${place.coating }</p>`;
    }
    if(place.website) {
        html += `<a href="${place.website}">Website</a>`;
    }
    html += `<button class="btn create gray" onclick="seeMore(${place.idPlaces})">See more</button>`
    place.marker = marker;
    marker.bindPopup(html);
}

map.addEventListener('moveend', function(e) {
    localStorage.mapZoomZevel = map.getZoom();
});
map.on('mouseup', function(ev){
    let coordinates = map.mouseEventToLatLng(ev.originalEvent);
    console.log(coordinates.lat + ', ' + coordinates.lng);
    localStorage.mapLat = coordinates.lat;
    localStorage.mapLng = coordinates.lng;
});

let picking = false;
map.addEventListener('mousemove', function(ev) {
    if(!picking) return;
    let lat = ev.latlng.lat;
    let lng = ev.latlng.lng;
    $("#lat").val(lat);
    $("#lng").val(lng);
});
map.addEventListener('click', function(ev) {
    $(".pickBtn").removeClass("green");
    $(".pickBtn").addClass("gray");
    picking = false;
});
function pick() {
    $(".pickBtn").removeClass("gray");
    $(".pickBtn").addClass("green");
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
    $(".see-more").append(`<p>size: ${p.website ?? "-"}</p>`);
    $(".see-more").append(`<p>Club name: ${p.clubName ?? "-"}</p>`);
    $(".see-more")[0].scrollIntoView({block: "center", inline: "nearest"});
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
        $(".see-more").append(delBtn);
    }
}
</script>
<?php
include_once "../footer.php";
?>