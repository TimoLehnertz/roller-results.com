<?php
include_once "../../../api/index.php";
include_once "../../../header.php";
echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <div class="top-site">
        <!-- <h1 class="title">Advantages for sprint teams</h1> -->
    </div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#333"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="flex mobile font size biggest">Analytics</h1>
        <p class="align center font size big color light margin top double">
            The tool to dig deep into Speed-skating data
        </p>
    </div>
    <div class="light section">
        <div class="tool">
            <div class="presets font">
                <h2>Presets</h2>
                <p></p>
                <p>Create your own presets! Make shure to be logged in and check public if you want to share them</p>
                <p>Load presets from others to experiment with the features.</p>
                <p>
                    <select>
                        
                    </select>
                    <button class="loadAnalytics-btn" onclick="loadAnalytics()">Load</button>
                    <button class="removeAnalytics-btn" onclick="removeAnalytics()">Remove</button>
                </p>
                <p>
                    <label for="analytics-name">Name:</label>
                    <input type="text" class="analytics-name" id="analytics-name" placeholder="Name">
                    <label for="analytics-public-check">Public</label>
                    <input id="analytics-public-check" class="analytics-public" type="checkbox">
                    <button class="saveAnalytics-btn" onclick="saveAnalytics()">Save</button>
                </p>
            </div>
            <hr>
            <br>
            <div class="graph">
                
            </div>
            <div class="last-row flex">
                <hr>
                <div>
                    <p>Add row</p>
                    <div class="add"><button class="add-btn" onclick="addRow()">+</button></div>
                </div>
                <div>
                    <p>Remove last row</p>
                    <div class="add"><button class="add-btn" onclick="removeLastRow()">X</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark section">
        <h1>Results</h2>
        <div class="summary"></div>
        <div class="results align center">
            <p class="font size big">Hit <span class="code">run</span> on a select node to see the result.</p>
        </div>
    </div>
    <script>

        let selectPresets = [];

        get("selectPresets").receive((succsess, res) => {
            selectPresets = res;
            updateSelectPresets();
        });


        let clipboard;
        const selectOptions = {
            distances: {
                options: ["1000m","10000m Points/Elimination","15000m Elimination","200m T/T","300m T/T","500m","20000m Elimination","10000m Points","Marathon","one Lap","100m","5000m Elimination","500m +D","10000m Elimination","10000m","1200m Team T/T","3000m","3000m Points","5000m","5000m Points","500m K/O","500m Pursuit","500m T/T","1500m","1500m Team T/T","21km Half Marathon","1000m K/O","1400m Team T/T","15000m","15000m Points/Elimination","1500m Team Pursuit","20000m","2000m","25000m","50000m","500m (478m)","84km x2 Marathon","8000m","30km Marathon","6 Laps Team T/T","15km Marathon","10000m RELAY","3000m RELAY","5000m RELAY","4000M MIX RELAY","20000m RELAY","200m Flying","8000m Points","500m Team Sprint","15.5km Marathon","5000 Points","500m Dual TT","5000m Eliminitation","7000m Elimination"],
                displayName: "Distances",
                all: "."
            },comps: {
                options: ["WM","Youth Olympic Games","World Games","EM","Combined","Cadets Challenge"],
                displayName: "Competition types",
                all: "."
            },gender: {
                options: ["w", "m", "Mixed"],
                displayName: "Gender",
                all: "."
            },categories: {
                options: ["Junior","Senior","Cadet","Youth","Junior B"],
                displayName: "Categories",
                all: "."
            },disciplines: {
                options: ["short", "short mass", "long"],
                displayName: "Disciplines",
                all: "."
            },locations: {
                options: ["Canelas","Oostende-Zandvoorde","Barcelona","Pamplona","Oostende-Zandvoorde","Heerde","Buenos Aires","Oostende-Zandvoorde","Nanjing","Lagos","Oostende-Zandvoorde","Nanjing","Heerde / Steenwijk","Oostende-Zandvoorde","Koahsiung","Wörgl / Innsbruck","Oostende-Zandvoorde","Rosario","Geisingen","Oostende-Zandvoorde","Cali","Almere","Geisingen","San Benedetto del Tronto / Ascoli Piceno","Szeged","Yeosu","Macerata / Pollenza","Heerde / Zwolle","Guarne","San Benedetto del Tronto","Haining","Oostende-Zandvoorde","Kaohsiung","Gijon","Naestved / Slagelse","Gera","Cali","Heerde / Staphorst","Estarreja / Ovar","Cassano d'Adda / Martinsicuro","Anyang","Cardano Al Campo / Lugnano","Suzhou - Taihu Lake Resort","Juterbog / Ludwigsfelde","Duisburg","Pamplona-Baranain","Pescara / Sulmona / L'Aquila","Heerde / Groningen","Genemuiden","Barquisimeto","Padua","Oostende-Zandvoorde","Valence d'Agen","Grenade-sur-Garonne","Pacos de Ferreira","Valence d'Agen / Auvillar","Akita","Jaszbereny","Barrancabermeja","Sabaudia-Latina","Gera","Santiago-Nunoa","Oostende-Zandvoorde","Middelkerke","Lisbon","Piombino","Coulaines","Pamplona-Baranain","Pamplona-Baranain","Miramar to Mar del Plata","Roseto /Sulmona","Lahti","Castel di Sangro","Piombino","Barrancabermeja","Lamballe","Padua /Scaltenigo / Treviso","St Brieuc","Oostende-Zandvoorde","Praia da Vitoria-Azores","Perth","Freemantle","Wiener Neustadt","Andernos to Gujan Mestras","Pamplona-Baranain","Valence d'Agen","The Hague","Colorado Springs","Serpa","Acireale-Sicily","Rome","La Roche-sur-Yon","Pescara /Pineto","Oostende-Zandvoorde","Arganda Del Rey","Inzell","Bello","Scaltenigo","Madalena-Pico-Azores","Karlsruhe","Hastings","Finale Emilia","Cassano d'Adda","Gujan Mestras","La Roche-sur-Yon","Oostende-Zandvoorde","Grenoble","Madalena-Pico-Azores","Finale Emilia","Adelaide","Pamplona /Pamplona-Baranain","Cassano d'Adda","Colorado Springs","London-Crystal Palace","Birmingham /Sutton Coldfield","Bogota","Wiener Neustadt","Bougenais","Cremona","Mar del Plata","Nantes La Coliniere","Jesi /Marina di Grossetto / Rieti /Santa Maria Nuova","Finale Emilia","Pamplona-Baranain","Leuven","Pineto","Santa Clara","Montesilvano","Oostende-Zandvoorde","Finale Emilia","Masterton","Southampton","Spoleto / Venice-Lido","Como /Finale Emilia","Leuven / Ostende-Zandvoorde","La Roche-sur-Yon","Mar del Plata","Finale Emilia /Salerno","Milan-Sesto San Giovanni","Mar del Plata","San Benedetto del Tronto","Grenoble","Wetteren","Mar del Plata","Vicenza-Montecchio","Inzell","Barcelona","Mar del Plata","Wetteren","Siracusa","Madrid","Nantes","Venice-Lido","Gujan Mestras","Voltrega","Wetteren","Finale Ligure","Palermo-Sicily","Barcelona","Bari","Venice-Lido","Monfalcone","Ferrara","Lisbon","Monfalcone","Ferrara","London-Wembley","Monza","Stuttgart","Monza","Antwerp"],
                displayName: "Locations",
                all: "."
            },countries: {
                options: ["South Korea","Italy","Colombia","Germany","Venezuela","France","USA","Belgium","Chile","Ecuador","Spain","Chinese Taipei","Portugal","Australia","Argentina","New Zealand","Mexico","Guatemala","Canada","Hong Kong","Netherlands","China","Switzerland","Iran","South Africa","India","Cuba","Poland","Morocco","Sweden","Brazil","Austria","Japan","Denmark","Norway","Honduras","Latvia","Hungary","Finland","Nicaragua","Costa Rica","El Salvador","Ukraine","Great Britain","Czechia","Panama","Russia","Kenya","Israel","Paraguay","Pakistan","Nigeria","Liechtenstein","Slovakia","Mongolia","Puerto Rico","Indonesia","Peru","Dominican Republic","Serbia","Croatia","Estonia","Turkey","Slovenia","Cameroon","Malaysia","Thailand","Egypt","Trinidad and Tobago","Bangladesh","Benin","Côte d'Ivoire","Senegal","Singapore","Greece"],
                displayName: "Countries",
                all: "."
            },
        }
        const selectInputs = {
            minPlace: {
                displayName: "Min place",
                type: "number",
                value: 1
            },maxPlace: {
                displayName: "Max place",
                type: "number",
                value: 1000
            },fromDate: {
                displayName: "Start date",
                type: "date",
                value: "1900-01-01"
            },toDate: {
                displayName: "End date",
                type: "date",
                value: "2050-01-01"
            },limit: {
                displayName: "Max results",
                type: "number",
                value: 50
            }
        }

        /**
         * Dragg stuff
         */
        let dragStartSelect;

        class Selector {
            constructor(row) {
                this.row = row;
                this.joinMethod = "and";
                this.uid = getUid();
                const uid2 = getUid();
                this.elem = $(`
                <div class="selector ${this.uid}">
                    <div class="docker-wrapper"></div>
                    <input class="name" type="text" placeholder="Name">
                    <div class="docker-join"></div>
                    <button class="delete-btn">X</button>
                    <button class="properties-btn"><i class="fas fa-sliders-h margin right"></i>Properties</button>
                    <button class="run-btn"><i class="fas fa-play margin right"></i>Run</button>
                    <div class="preset-select-div">
                        <label for="${uid2}">Preset:</label><select id="${uid2}" class="preset-setect"></select>
                    </div>
                    <div class="preset-div">
                        <button class="load-btn">Load</button>
                        <button class="save-btn">Save</button>
                        <button class="remove-preset-btn">Remove</button>
                    </div>
                    <button class="schow-result-btn" style="display: none"><i class="fas fa-table margin right"></i>Show result</button>
                    <button class="drag-btn" draggable="true"></button>
                </div>`);
                this.elem.find(".delete-btn").click(() => {this.die()});
                this.elem.find(".remove-preset-btn").click(() => {this.removePreset()});
                this.elem.find(".save-btn").click(() => {this.save()});
                this.elem.find(".load-btn").click(() => {this.load()});
                this.elem.find(".run-btn").click(() => {this.run(true)});
                this.elem.find(".schow-result-btn").click(() => {if(this.res !== undefined) {showResult(this.res);}});

                if(isMobile()) {
                    this.elem.click((e) => {
                        if(dragStartSelect && dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)){
                            this.dock(dragStartSelect);
                            dragStartSelect = undefined;
                            this.row.elem.removeClass("dropable");
                        }
                    })
                }

                /**
                 * ToDo description
                 */
                this.state = {};
                this.docked = [];

                this.initDefaultState();
                this.initDropdown();
                this.initDrag();

                window.setTimeout(updateSelectPresets, 100);
            }

            removePreset() {
                const presetName = this.elem.find(".preset-setect").val();
                get("deleteSelectPreset", {
                    presetName
                }).receive((succsess, res) => {
                    get("selectPresets").receive((succsess, res) => {
                        selectPresets = res;
                        updateSelectPresets(true, false);
                    });
                });
            }

            load(preset) {
                if(!preset) {
                    const presetName = this.elem.find(".preset-setect").val();
                    preset = this.getSelectPreset(presetName);
                }
                console.log(preset.joinMethode);
                this.elem.find(".name").val(preset.name);
                this.joinMethod = preset.joinMethode;
                this.updateJoin(true);

                for (const key in this.state) {
                    if (Object.hasOwnProperty.call(this.state, key)) {
                        const element = this.state[key];
                        if(element.type === 1) {
                            console.log(key);
                            console.log(preset);
                            element.all = preset[key] === ".";
                            let split = preset[key].split("|");
                            split = split.filter((split) => split.length > 0);
                            element.tmp = split;
                            console.log(split);
                        } else if(element.type === 2) {
                            element.value = preset[key];
                        }
                    }
                }
            }

            getSelectPreset(name) {
                for (const preset of selectPresets) {
                    if(preset.name === name) {
                        return preset;
                    }
                }
            }

            save() {
                const name = this.elem.find(".name").val();
                if(name.length == 0) {
                    alert("Please enter a name");
                    return;
                }
                get("athletes", this.getSaveStateConverted(false, name)).receive((succsess, msg) => {
                    console.log(msg);
                    if(msg?.length > 0) {
                        alert(msg);
                    } else {
                        alert("Saved as " + name);
                        get("selectPresets").receive((succsess, res) => {
                            selectPresets = res;
                            updateSelectPresets(true, true);
                        });
                    }
                });
            }

            initDrag() {
                if(isMobile()) {
                    this.elem.find(".drag-btn").addClass("mobile-big");
                    this.elem.find(".drag-btn").on("click", (e) => {
                        e.stopPropagation();
                        dragStartSelect = this;
                        if(this.row.rowAfter) {
                            this.row.rowAfter.elem.addClass("dropable");
                        }
                    });
                }
                if(isMobile()) {
                    this.elem.click((e)=> {
                        if(dragStartSelect == this) {
                            dragStartSelect = undefined;
                            if(this.row.rowAfter) {
                                this.row.rowAfter.elem.removeClass("dropable");
                            }
                        }
                    });
                }
                this.elem.on("dragstart", (e) => {
                    dragStartSelect = this;
                });
                this.elem.on("dragover", (e) => {
                    if(dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
                this.elem.on("drop", (e) => {
                    if(dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.dock(dragStartSelect);
                        dragStartSelect = undefined;
                        $(document).unbind("mousemove")
                    }
                });
            }

            dock(select) {
                this.docked.push(select);
                const uid = getUid();
                select.dockUid = uid;
                const docker = $(`<div class="docker ${uid} ${isMobile() ? "mobile-half" : ""}"></div>`);
                this.elem.find(".docker-wrapper").append(docker);
                docker.click(() => {
                    this.undock(select, uid);
                });
                this.row.rowBefore.draw();
                this.updateJoin();
            }

            undock(select) {
                this.docked.splice(this.docked.indexOf(select), 1);
                this.elem.find(`.${select.dockUid}`).remove();
                this.row.rowBefore.draw();
                this.updateJoin();
            }

            updateJoin() {
                this.elem.find(".docker-join").empty();
                if(this.docked.length < 2) {
                    // this.elem.find(".docker-join").empty();
                    // this.joinDone = false;
                    this.elem.find(".docker-join").css("display", "none");
                    return;
                }
                this.elem.find(".docker-join").css("display", "block");
                this.elem.find(".docker-join").append(`
                <p>Join Method</p>
                <div>
                    <button class="join-btn and ${this.joinMethod == "and" ? "active" : ""}">And</button>
                    <button class="join-btn or ${this.joinMethod == "or" ? "active" : ""}">Or</button>
                </div>`);
                this.elem.find(".join-btn.and").click(() => {
                    this.joinMethod = "and";
                    this.elem.find(".join-btn.and").addClass("active");
                    this.elem.find(".join-btn.or").removeClass("active");
                });
                this.elem.find(".join-btn.or").click(() => {
                    this.joinMethod = "or";
                    this.elem.find(".join-btn.or").addClass("active");
                    this.elem.find(".join-btn.and").removeClass("active");
                });
                this.joinDone = true;
            }

            die() {
                if(this.row.rowAfter) {
                    for (const selector of this.row.rowAfter.selectors) {
                        if(selector.docked.includes(this)) {
                            selector.undock(this);
                        }
                    }
                }
                this.row.selectors.splice(this.row.selectors.indexOf(this), 1);
                this.elem.remove();
                if(this.row.rowBefore) {
                    this.row.rowBefore.draw();
                }
                this.row.draw();
            }

            initDefaultState() {
                for (const key in selectOptions) {
                    if (Object.hasOwnProperty.call(selectOptions, key)) {
                        const element = selectOptions[key];
                        this.state[key] = {
                                all: true,
                                tmp: [],
                                type: 1
                            };
                    }
                }
                for (const key in selectInputs) {
                    if (Object.hasOwnProperty.call(selectInputs, key)) {
                        const element = selectInputs[key];
                        this.state[key] = {
                                value: element.value,
                                type: 2
                            };
                    }
                }
            }

            initDropdown() {
                const dropdownEntries = [];
                for (const key in selectOptions) {
                    if (Object.hasOwnProperty.call(selectOptions, key)) {
                        const element = selectOptions[key];
                        const state = this.state[key];
                        const children = [];

                        children.push({// All select
                            type: "list",
                            data : [
                                {
                                    data: "All",
                                    style: {marginRight: "1rem"}
                                },
                                {
                                    type: "input",
                                    inputType: "checkbox",
                                    data: 1,
                                    attributes: {
                                        checked: () => state.all ? true : undefined,
                                    },
                                    change: (e, val) => {
                                        state.all = val;
                                        if(val) {
                                            $("." + this.uid + " .stateCheckbox input").attr("disabled", true);
                                        } else {
                                            $("." + this.uid + " .stateCheckbox input").removeAttr("disabled");
                                        }
                                    }
                                }
                            ]
                        });

                        for (const option of element.options) {
                            children.push({// All select
                                type: "list",
                                data : [
                                    {
                                        data: option,
                                        style: {marginRight: "1rem"}
                                    },
                                    {
                                        type: "input",
                                        class: "stateCheckbox",
                                        inputType: "checkbox",
                                        data: 1,
                                        attributes: {
                                            disabled: () => state.all ? true : undefined,
                                            checked: () => state.tmp.includes(option) ? true : undefined,
                                        },
                                        change: (e, val) => {val ? state.tmp.push(option) : state.tmp.splice(state.tmp.indexOf(option), 1)}
                                    }
                                ]
                            });
                        }

                        const dropdownEntry = {
                            element: element.displayName,
                            children
                        };
                        dropdownEntries.push(dropdownEntry);
                    }
                }
                for (const key in selectInputs) {
                    if (Object.hasOwnProperty.call(selectInputs, key)) {
                        const element = selectInputs[key];
                        const state = this.state[key];
                        dropdownEntries.push({
                            type: "list",
                            data : [
                                {
                                    data: element.displayName,
                                    style: {marginRight: "1rem"}
                                },
                                {
                                    type: "input",
                                    inputType: element.type,
                                    data: 1,
                                    attributes: {
                                        value: () => state.value
                                    },
                                    change: (e, val) => {state.value = val}
                                }
                            ]
                        });
                    }
                }
                this.dropdown = new Dropdown(this.elem.find(".properties-btn"), dropdownEntries);
            }

            getInput() {
                const promise = {
                    callback: () => console.log("no Callback"),
                    receive: (e) => {promise.callback = e}
                }
                if(this.docked.length == 0) {
                    window.setTimeout(() => {promise.callback(true, ".")}, 100);
                } else if(this.docked.length == 1) {
                    const ids = this.docked[0].run().receive((succsess, res) => {
                        promise.callback(succsess, res);
                    });
                } else {
                    let ids = [];
                    let i = 0;
                    const me = this;
                    function runOne(i) {
                        if(i >= me.docked.length) {
                            console.log("input:");
                            console.log(ids);
                            promise.callback(true, ids);
                            return;
                        }
                        me.docked[i].run().receive((succsess, res) => {
                            if(i == 0) {
                                ids = res;
                            } else if(me.joinMethod === "and") {
                                const idNew = [];
                                for (const id1 of res) {
                                    for (const id2 of ids) {
                                        if(id1 === id2) {
                                            idNew.push(id1);
                                            break;
                                        }
                                    }
                                }
                                ids = idNew;
                                console.log("and:")
                                console.log(ids);
                            } else if(me.joinMethod === "or") {
                                for (const id of res) {
                                    if(!ids.includes(id)) {
                                        ids.push(id);
                                    }
                                }
                            }
                            runOne(i + 1);
                        });
                    }
                    runOne(0);
                }
                return promise;
            }

            getSaveStateConverted(isPublic, name) {
                let settings = {
                    addPreset: 1,
                    presetName: name,
                    joinMethode: this.joinMethod
                };
                if(isPublic) {
                    settings["public"] = 1;
                }
                console.log(this.state);
                for (const key in this.state) {
                    if (Object.hasOwnProperty.call(this.state, key)) {
                        const element = this.state[key];
                        if(element.type === 1) {
                            let value = ".";
                            if(!element.all) {
                                value = "";
                                let delimiter = "";
                                for (const tmp of element.tmp) {
                                    value += delimiter + tmp;
                                    delimiter = "|";
                                }
                            }
                            settings[key] = value;
                        } else if(element.type === 2) {
                            settings[key] = element.value;
                        }
                    }
                }
                return settings;
            }

            getStateConverted() {
                const promise = {
                    callback: () => console.log("no Callback"),
                    receive: (e) => {promise.callback = e}
                }
                this.getInput().receive((succsess, res) => {
                    let idString = `\\b(`;
                    if(Array.isArray(res)) {
                        let delimiter = "";
                        for (const id of res) {
                            idString += delimiter + id;
                            delimiter = "|";
                        }
                        idString += `)\\b`;
                        console.log()
                        if(res.length === 0) {
                            idString = "a^";
                        }
                    } else {
                        idString = res;
                    }
                    const settings = {
                        ids: `${idString}`,
                        joinMethode: this.joinMethod
                    };
                    for (const key in this.state) {
                        if (Object.hasOwnProperty.call(this.state, key)) {
                            const element = this.state[key];
                            if(element.type === 1) {
                                let value = ".";
                                if(!element.all) {
                                    value = "\\b(";
                                    let delimiter = "";
                                    for (const tmp of element.tmp) {
                                        value += delimiter + tmp;
                                        delimiter = "|";
                                    }
                                    value += ")\\b"
                                    if(element.tmp.length === 0) {
                                        value = "^a";
                                    }
                                }
                                settings[key] = value;
                            } else if(element.type === 2) {
                                settings[key] = element.value;
                            }
                        }
                    }
                    promise.callback(succsess, settings);
                });
                return promise;
            }

            run(print) {
                this.res = undefined;
                this.updateShow();
                const promise = {
                    callback: () => console.log("no Callback"),
                    receive: (e) => {promise.callback = e}
                }
                this.getStateConverted().receive((succsess, res) => {
                    this.elem.addClass("running");
                    get("athletes", res).receive((sucsess, res) => {
                        if(print) {
                            showResult(res);
                        }
                        const ids = [];
                        for (const row of res) {
                            ids.push(row.idAthlete);
                        }
                        this.elem.removeClass("running");
                        promise.callback(succsess, ids); 
                        this.res = res;
                        this.updateShow();
                    });
                });
                return promise;
            }

            updateShow() {
                if(this.res === undefined) {
                    this.elem.find(".schow-result-btn").css("display", "none");
                } else {
                    this.elem.find(".schow-result-btn").css("display", "block");
                }
            }

            copy() {
                clipboard = this;
            }

            getJson() {
                const json = this.getSaveStateConverted();
                json.docked = [];
                delete json.presetName;
                delete json.addPreset;
                json.name = this.elem.find(".name").val();
                for (const docked of this.docked) {
                    json.docked.push(docked.getIndex());
                }
                return json;
            }

            getIndex() {
                return this.elem.index();
            }
        }
        
        class Row {
            constructor(rowBefore) {
                this.firstRow = rowBefore === undefined;
                this.rowBefore = rowBefore;
                this.index = undefined;
                this.elem = $(`<div><div class="select-row"><div class="add"><button class="add-btn">+</button></div></div></div>`);
                this.addField = this.elem.find(".add");
                this.elem.find(".add-btn").click(() => {
                    this.addNew();
                });
                this.selectors = [];
                this.initCanvas();
                this.draw();
                $(document).on("dragover", (e) => {this.drag(e)});
                $(document).on("dragend", (e) => {this.draw(true)});
                // window.setInterval(() => this.draw, 1000);
            }

            getAnalyticRow() {
                const analyticRow = {
                    selectors: [],
                }
                for (const selector of this.selectors) {
                    analyticRow.selectors.push(selector.getJson());
                }
                return analyticRow;
            }

            drag(e) {
                if(dragStartSelect === undefined) return;
                if(dragStartSelect.row !== this) return;
                this.mouse = {
                    x: e.offsetX,
                    y: e.offsetY,
                }
                if(this.mouse.y > 0 && this.mouse.y < this.canvas.height) {
                    this.draw();
                }
            }

            initCanvas() {
                this.canvas = document.createElement("canvas");
                this.canvas.width = 10000;
                this.canvas.height = isMobile() ? 150 : 150;
                this.ctx = this.canvas.getContext('2d');
                this.elem.append(this.canvas);
            }

            draw(s) {
                /**
                 * Lines
                 */
                this.ctx.fillStyle = "blue";
                this.ctx.clearRect(0,0,1000,1000);
                if(this.rowAfter !== undefined) {
                    for (const selector of this.rowAfter.selectors) {
                        let index = 0;
                        for (const docked of selector.docked) {
                            const pointA = this.pointFromSelector(docked);
                            const pointB = this.dockingPointFromSelector(selector, index);
                            this.lineFromTo(pointA, pointB);
                            index++;
                        }
                    }
                }
                /**
                 * Dragline
                 */
                if(!isMobile() && dragStartSelect !== undefined && dragStartSelect.row.index === this.index && !s) {
                    const loc = $(this.canvas).offset();
                    const pointA = this.pointFromSelector(dragStartSelect);
                    this.lineFromTo(pointA, this.mouse);
                }
            }

            lineFromTo(pointA, pointB) {
                const height = pointB.y - pointA.y;
                this.ctx.beginPath();
                this.ctx.moveTo(pointA.x, pointA.y);
                this.ctx.bezierCurveTo(pointA.x, pointA.y + height * 0.4, pointB.x, pointB.y - height * 0.4, pointB.x, pointB.y);
                this.ctx.stroke();
            }

            pointFromSelector(selector) {
                return {
                    x: selector.elem.position().left + selector.elem.width() / 2 + 7,
                    y: this.remToPixels(2) - 8
                }
            }

            dockingPointFromSelector(selector, index) {
                return {
                    x: selector.elem.position().left + (index + 1) * selector.elem.outerWidth() / (selector.docked.length + 1),
                    y: this.canvas.height
                }
            }

            remToPixels(rem) {
                return rem * parseFloat(getComputedStyle(document.documentElement).fontSize);
            }

            die() {
                for (const selector of this.selectors) {
                    selector.die();
                }
                this.canvas.remove();
            }

            addNew() {
                const selector = new Selector(this);
                this.selectors.push(selector);
                this.addField.before(selector.elem);
                this.draw();
                return selector;
            }

            create(settings) {
                console.log(settings);
                for (const selectorSettings of settings.selectors) {
                    const selector = this.addNew();
                    selector.load(selectorSettings);
                    for (const docked of selectorSettings.docked) {
                        selector.dock(this.rowBefore.selectors[docked]);
                    }
                }
                this.draw();
            }
        }

        function showResult(res) {
            $(".results").empty();
            const table = new Table($(".results"), res);
            table.useRowAsCallback = true;
            table.setup({
                layout: {
                    fullname: {
                        displayName: "Athlete",
                        callback: (e) => $(`<a target="_blank" rel="noopener noreferrer" href="/athlete/?id=${e.idAthlete}">${e.fullname}</a>`)
                    },country: {
                        displayName: "Country",
                        callback: (e) => $(`<a target="_blank" rel="noopener noreferrer" href="/country/?id=${e.country}">${e.country}</a>`)
                    },medals: {
                        displayName: "Medals"
                    },bronzeMedals: {
                        displayName: "Bronze medals"
                    },silverMedals: {
                        displayName: "Silver medals"
                    },goldMedals: {
                        displayName: "Gold medals"
                    },medalScore: {
                        displayName: "Medal score"
                    }
                }
            });
            table.init();
            const stats = ["medals", "medalScore"];
            $(".summary").empty();
            $(".summary").append(`
            <h3>Summary</h3>
            <ul>
            <p><span class="code">${res.length}</span> athletes matched.</p>
            </ul>
            `);
            for (const stat of stats) {
                let min = 10000;
                let max = 0;
                let avg = 0;
                for (const row of res) {
                    min = Math.min(parseFloat(row[stat]), min);
                    max = Math.max(parseFloat(row[stat]), max);
                    avg += parseFloat(row[stat]);
                }
                avg /= res.length;
                $(".summary ul").append(`<li>${stat} stats: Min=${code(min)}, Max=${code(max)}, Average=${code(avg)}</li>`);
            }
        }

        let rows = [];

        function addRow() {
            const lastRow = rows.length > 0 ? rows[rows.length - 1] : undefined;
            const row = new Row();
            rows.push(row);
            $(".graph").append(row.elem);
            recalculateIndex();
            return row;
        }

        function removeLastRow() {
            if(rows.length == 0) return;
            rows[rows.length - 1].elem.remove();
            rows[rows.length - 1].die();
            rows.pop();
            recalculateIndex();
        }

        function recalculateIndex() {
            let i = 0;
            for (const row of rows) {
                row.index = i;
                if(i > 0) {
                    row.rowBefore = rows[i - 1];
                } else {
                    row.rowBefore = undefined;
                }
                if(i < rows.length - 1) {
                    row.rowAfter = rows[i + 1];
                } else {
                    row.rowAfter = undefined;
                }
                i++;
            }
        }

        function updateSelectPresets(force, keepVals) {
            $(".selector .preset-setect").each(function() {
                if(!force && $(this).find("option").length > 0) {
                    return;
                }
                const val = $(this).val();
                $(this).empty();
                for (const selectPreset of selectPresets) {
                    $(this).append(`<option value="${selectPreset.name}">${selectPreset.name}</option>`);
                }
                if(keepVals) {
                    $(this).val(val);
                }
            });
        }

        // function updatePresets() {
        //     get("selectPresets").receive((succsess, res) => {
        //         selectPresets = res;
        //         $(".presets select").empty();
        //         for (const preset of res) {
        //             $(".presets select").append(`<option value="${preset.name}">${preset.name}</option>`);
        //         }
        //     });
        // }

        function getAnalytics() {
            const alanyticRows = [];
            for (const row of rows) {
                alanyticRows.push(row.getAnalyticRow());
            }
            return alanyticRows;
        }

        function saveAnalytics() {
            const analyticsName = $(".analytics-name").val();
            if(analyticsName.length == 0) {
                alert("Pleas fill in a name");
                return;
            }
            const analytics = getAnalytics();
            console.log("saving analytics:");
            console.log(analytics);
            const public = ($(".analytics-public").is(":checked") ? "&public" : "");
            set("analytics&name=" + analyticsName + public, analytics).receive((res) => {
                console.log(res);
                updateAnalytics(true);
            });
        }

        function loadAnalytics() {
            const name = $(".presets select").val();
            if(!name || name.length === 0) {
                alert("Please select a preset");
                return;
            }
            for (const preset of analyticsPresets) {
                if(preset.name === name) {
                    $(".analytics-name").val(name);
                    const analytics = JSON.parse(preset.json);
                    clear()
                    console.log("loading analytics:");
                    console.log(analytics);
                    for (const rowSettings of analytics) {
                        addRow().create(rowSettings);
                    }
                }
            }
        }

        function removeAnalytics() {
            const name = $(".presets select").val();
            if(!name) {
                alert("Choose a preset to remove");
                return;
            }
            get("deleteAnalytics", {name}).receive((succsess, res) => {
                if(res && res.length > 0) {
                    alert(res);
                }
                if(succsess) {
                    alert("Deleted " + name);
                }
                updateAnalytics(false);
            });
        }

        let analyticsPresets = [];

        function updateAnalytics(forceVal) {
            get("analytics").receive((succsess, res) => {
                analyticsPresets = res;
                const val = $(".presets select").val();
                $(".presets select").empty();
                for (const preset of res) {
                    $(".presets select").append(`<option value="${preset.name}">${preset.name}</option>`);
                }
                if(val && forceVal) {
                    $(".presets select").val(val);
                }
            });
        }

        function clear() {
            while(rows.length > 0) {
                removeLastRow();
            }
        }

        updateAnalytics(false);

        addRow();
        rows[0].addNew();

    </script>
</main>
<?php
include_once "../../../footer.php";
?>