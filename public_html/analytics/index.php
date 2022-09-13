<?php
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest"><i class="fas fa-binoculars margin right"></i>Analytics</h1>
        <p class="align center font size big color light margin top double">The tool to dig deep into Inline Speedskating data</p>
        <br>
        <p class="align center font color light ">Here you have limitless access and powerful tools to the worlds biggest inline skating database.</p>
    </div>
    <div class="light section">
        <div class="flex mobile">
            <div>
                <h2 class="font size bigger-medium align center">Getting started</h2>
                <p class="font size bigger-medium">The Selector</p>
                <br>
                <p>Before we start - Quick word about databases: Databases are tables with rows and columns just like Excel. So from now on try think in tables.</p>
                <p>In the image and below in the editor you see Selectors. You can use those to filter Results. Say you dont want all our <?php echo getResultAmount();?> results but instead all you care about is Senior male in 2015.</p>
                <p>The selector properties let you select just that and a lot more. When youre happy with it hit the Run button. When a selector turnes blue it is currently working behind the scenes to find your results.</p>
                <p>When your results are ready they will be Grouped by Athletes and you get a summary per athlete. The resulting table will be shown below.</p>
                <br>
                <p class="font size bigger-medium">Multiple Selectors</p>
                <br>
                <p>By utilizing the ➕ buttons you can create as many Selectors as you want</p>
                <p>Selector neighbours: Selectors next to each other dont know about each other. It gets interesting when you have selectors below each other.</p>
                <p>Selector rows: Selectors directly below each other can be connected by dragging the blue dot on top of another selector. Now if you execute a selector that has another one connected on to it will first execute the upper one and use it's output as input</p>
                <p>So now you could use one Selector to select all juniors who were succsessfull on worlds. With your second selector you can then Select all of those Juniors who stil participated as Seniors. Compare those results and you know how many Skaters quit professional skating. Load the <span class="code">Junior to Senior compare</span> example to find out the numbers</p>
                <br>
                <p class="font size bigger-medium">Joining method</p>
                <br>
                <p>When connecting multiple selectors to one you need to specify the joining method. See the info graphic.</p>
                <ul>
                    <li>And: use Athletes that have been matched in each of the connected Selectors</li>
                    <li>Or: use Athletes that have been matched in at least one of the connected selectors</li>
                    <li>XOr: use Athletes that have been matched in Exactly one Selector</li>
                    <li>Not: use Athletes that have been matched in the first connected selector but not any of the others. (Most left connection ist the first)</li>
                </ul>
            </div>
            <!-- <div class="padding top left btn default"></div> -->
            <div>
                <h3>Analytics info grahpic</h3>
                <img src="/img/Analytics-explanation.jpg" alt="Analytics graphic" style="max-width: min(40rem, 100vw)">
            </div>
        </div>
        <br>
    </div>
    <div class="flex column section dark">
        <h2>Projects</h2>
        <div>
            <label for="project-select">Project: </label>
            <select id="project-select"></select>
            <button class="loadAnalytics-btn" onclick="loadAnalytics()">Load</button>
            <?php if(isLoggedIn()) { ?>
            <button class="removeAnalytics-btn" onclick="removeAnalytics()">Remove</button>
            <?php } ?>
        </div>
        <?php if(isLoggedIn()) { ?>
        <div class="flex mobile align-start margin top gap">
            <p class="font size bigger-medium">Save project</p>
            <p>
                <label for="analytics-name">Name:</label>
                <input type="text" class="analytics-name" id="analytics-name" placeholder="Name">
            </p>
            <p>
                <label for="analytics-public-check">Public</label>
                <input id="analytics-public-check" class="analytics-public" type="checkbox">
            </p>
            <button class="saveAnalytics-btn" onclick="saveAnalytics()">Save</button>
        </div>
        <?php } ?>
    </div>
    <div class="dark section">
        <span class="font size bigger">Editor</span>
        <button class="clear-btn btn blender alone margin left font size bigger-medium">Clear</button>
        <button class="undo-btn btn blender left margin left font size bigger-medium">Undo</button>
        <button class="redo-btn btn blender right font size bigger-medium">redo</button>
        <div class="graph margin top">
            
        </div>
    </div>
    <div class="dark section no-shadow flex row justify-center gap">
        <div class="flex column align-center">
            <p>Add row</p>
            <div class="add"><button class="add-btn" onclick="addRow()">+</button></div>
        </div>
        <div class="flex column align-center">
            <p>Remove last</p>
            <div class="add"><button class="add-btn" onclick="removeLastRow()">X</button></div>
        </div>
    </div>
    <div class="light section">
        <h1>Results</h2>
        <div class="summary"></div>
        <div class="results align center">
            <p class="font size big">Hit <span class="code">run</span> on a select node to see the result.</p>
        </div>
    </div>
    <div class="dark section">
        <h2>Explore more analytics</h2>
        <div>
            <ul>
                <li><a href="articles/500m">500m analytics</a></li>
                <li><a href="articles/teamAdvantage">Team advantage</a></li>
            </ul>
        </div>
    </div>
    <script>
        $(".clear-btn").click(clear);
        $(".undo-btn").click(undo);
        $(".redo-btn").click(redo);

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
                displayName: "Max athletes",
                type: "number",
                value: 100
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
                // <input class="name" type="text"  placeholder="Name">
                this.elem = $(`
                <div class="selector ${this.uid}">
                    <div class="docker-wrapper"></div>
                    <textarea rows="2" style="resize: vertical;" class="name" type="text"  placeholder="Name"></textarea>
                    <div class="docker-join"></div>
                    <button class="delete-btn">X</button>
                    <button class="properties-btn"><i class="fas fa-sliders-h margin right"></i>Properties</button>
                    <button class="run-btn"><i class="fas fa-play margin right"></i>Run</button>
                    
                    <button class="schow-result-btn" style="display: none"><i class="fas fa-table margin right"></i>Show result</button>
                    <button class="drag-btn" draggable="true"></button>
                </div>`);
                // dont remove! insert in empty line for presets
                // <div class="preset-select-div">
                //         <label for="${uid2}">Preset:</label><select id="${uid2}" class="preset-setect"></select>
                //     </div>
                //     <div class="preset-div">
                //         <button class="load-btn">Load</button>
                //         <button class="save-btn">Save</button>
                //         <button class="remove-preset-btn">Remove</button>
                //     </div>
                // new Tooltip($(this.elem.find(".delete-btn")), "Delete this query");
                // new Tooltip($(this.elem.find(".name")), "Give this query a meaningful name");
                // new Tooltip($(this.elem.find(".properties-btn")), "Configure this query to your needs");
                // new Tooltip($(this.elem.find(".run-btn")), "Run this query and all that are before");
                new Tooltip($(this.elem.find(".preset-select")), "Select a preset for this query. Use the load button to load it and remove button to remove it");
                this.elem.find(".delete-btn").click(() => {this.die()});
                // this.elem.find(".remove-preset-btn").click(() => {this.removePreset()});
                // this.elem.find(".save-btn").click(() => {this.save()});
                // this.elem.find(".load-btn").click(() => {this.load()});
                this.elem.find(".run-btn").click(() => {this.run(true)});
                this.elem.find(".schow-result-btn").click(() => {if(this.res !== undefined) {showResult(this.res);}});

                // if(isMobile()) {
                    this.elem.click((e) => {
                        if(dragStartSelect && dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)) {
                            this.dock(dragStartSelect);
                            dragStartSelect = undefined;
                            this.row.elem.removeClass("dropable");
                        }
                    });
                // }

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
                    // if(res) {
                    //     alert(res);
                    // }
                    get("selectPresets").receive((succsess, res) => {
                        selectPresets = res;
                        updateSelectPresets(true, false);
                        window.setTimeout(() => {
                            for (const row of rows) {
                                row.draw();
                            }
                        }, 100);
                    });
                });
            }

            load(preset) {
                if(!preset) {
                    const presetName = this.elem.find(".preset-setect").val();
                    preset = this.getSelectPreset(presetName);
                }
                this.elem.find(".name").val(preset.name);
                this.joinMethod = preset.joinMethode;
                this.updateJoin(true);

                for (const key in this.state) {
                    if (Object.hasOwnProperty.call(this.state, key)) {
                        const element = this.state[key];
                        if(element.type === 1) {
                            element.all = preset[key] === ".";
                            let split = preset[key].split("|");
                            split = split.filter((split) => split.length > 0);
                            element.tmp = split;
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

            // save() {
            //     const name = this.elem.find(".name").val();
            //     if(name.length == 0) {
            //         alert("Please enter a name");
            //         return;
            //     }
            //     get("athletes", this.getSaveStateConverted(false, name)).receive((succsess, msg) => {
            //         if(!succsess) return alert("Error occoured");
            //         // console.log(msg);
            //         if(msg.length == 0) return alert(msg);
            //         alert("Saved as " + name);
            //         get("selectPresets").receive((succsess, res) => {
            //             selectPresets = res;
            //             updateSelectPresets(true, true);
            //         });
            //     });
            // }

            initDrag() {
                if(isMobile()) {
                    this.elem.find(".drag-btn").addClass("mobile-big");
                }
                // if(isMobile()) {
                    $(document).click(() => {
                        dragStartSelect = undefined;
                        $(".dropable").removeClass("dropable");
                    })
                    this.elem.find(".drag-btn").addClass("mobile-big");
                    this.elem.find(".drag-btn").on("click", (e) => {
                        e.stopPropagation();
                        dragStartSelect = this;
                        if(this.row.rowAfter) {
                            this.row.rowAfter.elem.addClass("dropable");
                        }
                    });
                    this.elem.click((e)=> {
                        if(dragStartSelect == this) {
                            dragStartSelect = undefined;
                            if(this.row.rowAfter) {
                                this.row.rowAfter.elem.removeClass("dropable");
                            }
                        }
                    });
                // }
                this.elem.on("dragstart", (e) => {
                    dragStartSelect = this;
                    if(this.row.rowAfter) {
                        this.row.rowAfter.elem.addClass("dropable");
                    }
                });
                this.elem.on("dragover", (e) => {
                    if(dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.elem.addClass("hover-drag");
                    }
                });
                this.elem.on("dragleave", (e) => {
                    this.elem.removeClass("hover-drag");
                });
                this.elem.on("drop", (e) => {
                    if(dragStartSelect.row.index == this.row.index -1 && !this.docked.includes(dragStartSelect)) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.dock(dragStartSelect);
                        dragStartSelect = undefined;
                        this.elem.removeClass("hover-drag");
                        $(document).unbind("mousemove");
                    }
                });
            }

            updateDockerDots() {
                this.elem.find(`.docker`).remove();
                for (const select of this.docked) {
                    const docker = $(`<div class="docker ${isMobile() ? "mobile-half" : ""}">x</div>`);
                    this.elem.find(".docker-wrapper").append(docker);
                    docker.click(() => {
                        if(this.row.elem.hasClass("dropable")) return;
                        this.undock(select);
                    });
                }
            }

            dock(select) {
                this.docked.push(select);
                this.row.rowBefore.draw();
                this.updateDockerDots();
                this.updateJoin();
            }

            undock(select) {
                this.docked.splice(this.docked.indexOf(select), 1);
                this.updateDockerDots();
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
                    <button class="join-btn xor ${this.joinMethod == "xor" ? "active" : ""}">XOr</button>
                    <button class="join-btn not ${this.joinMethod == "not" ? "active" : ""}">Not</button>
                </div>`);
                new Tooltip(this.elem.find(".join-btn.and"), "Use athletes that have been matched in each of the connected selectors");
                this.elem.find(".join-btn.and").click(() => {
                    this.joinMethod = "and";
                    this.elem.find(".join-btn").removeClass("active");
                    this.elem.find(".join-btn.and").addClass("active");
                });
                new Tooltip(this.elem.find(".join-btn.or"), "Use all athletes that have been matched in one of the connected selectors");
                this.elem.find(".join-btn.or").click(() => {
                    this.joinMethod = "or";
                    this.elem.find(".join-btn").removeClass("active");
                    this.elem.find(".join-btn.or").addClass("active");
                });
                new Tooltip(this.elem.find(".join-btn.xor"), "Use all athletes that have been matched in exactly one of the connected selectors");
                this.elem.find(".join-btn.xor").click(() => {
                    this.joinMethod = "xor";
                    this.elem.find(".join-btn").removeClass("active");
                    this.elem.find(".join-btn.xor").addClass("active");
                });
                this.elem.find(".join-btn.not").click(() => {
                    this.joinMethod = "not";
                    this.elem.find(".join-btn").removeClass("active");
                    this.elem.find(".join-btn.not").addClass("active");
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
                const parent = this.elem;
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
                                            // parent.find(".data-dropdown__entry").each((i, elem) => {
                                            //     console.log(elem);
                                            // });
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
                                    }, {
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

            eraseDoublicates(arr) {
                for (let i = 0; i < arr.length; i++) {
                    const element = arr[i];
                    let found = false;
                    for (let m = i + 1; m < arr.length; m++) {
                        if(arr[m] == element) {
                            arr.splice(m, 1);
                            found = true;
                        }
                    }
                    if(found) {
                        arr.splice(i, 1);
                    }
                }
            }

            getInput() {
                const promise = {
                    callback: () => {},
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
                            if(me.joinMethod === "xor") {
                                me.eraseDoublicates(ids);
                            }
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
                            } else if(me.joinMethod === "or") {
                                for (const id of res) {
                                    if(!ids.includes(id)) {
                                        ids.push(id);
                                    }
                                }
                            } else if(me.joinMethod === "xor") {
                                for (const id of res) {
                                    ids.push(id);
                                }
                            } else if(me.joinMethod === "not") {
                                for (const id of res) {
                                    if(ids.includes(id)) ids.splice(ids.indexOf(id), 1);
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
                for (const key in this.state) {
                    if (Object.hasOwnProperty.call(this.state, key)) {
                        const element = this.state[key];
                        if(element.type === 1) {
                            let value = ".";
                            if(!element.all) {
                                value = "";
                                let delimiter = "";
                                for (const tmp of element.tmp) {
                                    if(tmp == ".") continue;
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

            idsToIdString(ids) {
                if(!Array.isArray(ids)) return ids + "";

                let idString = `\\b(`;
                let delimiter = "";
                for (const id of ids) {
                    idString += delimiter + id;
                    delimiter = "|";
                }
                idString += `)\\b`;
                if(ids.length === 0) {
                    idString = "a^";
                }
                return idString;
            }

            getStateConverted() {
                const promise = {
                    callback: () => {},
                    receive: (e) => {promise.callback = e}
                }
                this.getInput().receive((succsess, res) => {
                    let idString = this.idsToIdString(res);
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
                                        if(tmp == ".") continue;
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
                const promise = {
                    callback: () => {},
                    receive: (e) => {promise.callback = e}
                }
                this.getStateConverted().receive((succsess, res) => {
                    const resClone = JSON.parse(JSON.stringify(res));
                    const inputIds = res.ids;
                    resClone.ids = undefined;
                    // console.log("lastSettings: ");
                    // console.log(this.lastSettings);
                    // console.log(objToUrlParams(resClone) + inputIds)
                    if(this.idRes !== undefined && this.lastSettings == objToUrlParams(resClone) + inputIds) {
                        window.setTimeout(() => {
                            promise.callback(true, this.idRes);
                        }, 100);
                        this.updateShow();
                        return promise;
                    }
                    this.res = undefined;
                    this.idRes = undefined;
                    this.updateShow();
                    this.elem.addClass("running");
                    $(".run-btn").attr("disabled", true);
                    set("athletes" + objToUrlParams(resClone), res.ids).receive((res) => { // RUN
                        if(res == null) return alert("An error occoured. Please try again later");
                        if(print) {
                            showResult(res);
                        }
                        const ids = [];
                        for (const row of res) {
                            ids.push(row.idAthlete);
                        }
                        this.elem.removeClass("running");
                        promise.callback(succsess, ids); 
                        this.idRes = ids;
                        this.res = res;
                        this.lastSettings = objToUrlParams(resClone) + inputIds;
                        this.updateShow();
                        $(".run-btn").attr("disabled", false);
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
                this.elem = $(`<div class="select-row-parent"><div class="select-row"><div class="add"><button class="add-btn">+</button></div></div></div>`);
                this.addField = this.elem.find(".add");
                this.elem.find(".add-btn").click(() => {
                    this.addNew();
                });
                this.selectors = [];
                this.initCanvas();
                this.mouse = {x:0,y:0};
                this.mousedown = false;
                this.draw();
                this.elem.find("canvas").on("dragover", (e) => {this.drag(e)});
                $(document).on("dragend", (e) => {this.mousedown = false; this.draw(); $(".dropable").removeClass("dropable");});
                this.elem.find("canvas").on("dragover", (e) => {this.updateMouse(e)});
                // $(document).on("mouseup", (e) => {this.mouse.pressed=false});
                // $(document).on("mousedown", (e) => {this.mouse.pressed=true});
                const update = () => {
                    this.canvas.width = this.elem.innerWidth() + $(".graph").scrollLeft();
                    this.draw();
                    requestAnimationFrame(update);
                }
                update();
                // window.setInterval(() => {
                // }, 100);
                // window.setInterval(() => this.draw, 1000);
            }

            updateMouse(e) {
                this.mousedown = true;
                const rect = e.target.getBoundingClientRect();
                this.mouse.x = e.clientX - rect.left// + $(".graph").scrollLeft() / 2;
                this.mouse.y = e.clientY - rect.top;
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
                // console.log(this.mouse);
                // this.mouse = {
                //     x: e.offsetX,
                //     y: e.offsetY,
                // }
                // if(this.mouse.y > 0 && this.mouse.y < this.canvas.height) {
                //     this.draw();
                // }
                this.draw();
            }

            initCanvas() {
                this.canvas = document.createElement("canvas");
                const canvasParent = $(`<div class="canvas-parent"></div>`);
                // this.canvas.width = this.elem.width();
                this.canvas.width = 10000;
                this.canvas.height = 150;
                this.ctx = this.canvas.getContext('2d');
                canvasParent.append(this.canvas);
                this.elem.append(canvasParent);
            }

            draw() {
                /**
                 * Lines
                 */
                this.ctx.fillStyle = "blue";
                this.ctx.strokeStyle = "#fff";
                this.ctx.clearRect(0, 0, 10000, 150);
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
                if(!isMobile() && dragStartSelect !== undefined && dragStartSelect.row.index === this.index && this.mousedown) {
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
                    x: selector.elem.position().left + selector.elem.width() / 2 + 7 + $(".graph").scrollLeft(),
                    // x: selector.elem.position().left + selector.elem.width() / 2 + 7,
                    y: this.remToPixels(2) - 8
                }
            }
            
            dockingPointFromSelector(selector, index) {
                return {
                    // x: selector.elem.position().left + (index + 1) * selector.elem.width() / 2 + 7 + $(".graph").scrollLeft(),
                    x: selector.elem.position().left + (index + 1) * selector.elem.outerWidth() / (selector.docked.length + 1) + $(".graph").scrollLeft(),
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
                // console.log(settings);
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
                    },goldMedals: {
                        displayName: "Gold medals"
                    },silverMedals: {
                        displayName: "Silver medals"
                    },bronzeMedals: {
                        displayName: "Bronze medals"
                    },medalScore: {
                        displayName: "Medal score"
                    },raceCount: {
                        displayName: "Race count"
                    }
                }
            });
            table.init();
            const stats = ["medals", "medalScore", "goldMedals", "raceCount"];
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
                $(".summary ul").append(`<li>${stat} stats: Min=${code(min)}, Max=${code(max)}, Average=${code(Math.round(avg * 100) / 100)}</li>`);
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
            if(!phpUser.loggedIn) return alert("You need to be logged in");
            const analyticsName = $(".analytics-name").val();
            if(analyticsName.length == 0) return alert("Pleas fill in a name");
            for (const preset of analyticsPresets) {
                if(preset.name === analyticsName && preset.owner === phpUser.iduser) {
                    if(!confirm(`Are you sure that you want to overwrite "${analyticsName}"?`)) return;
                }
            }
            const analytics = getAnalytics();
            const public = ($(".analytics-public").is(":checked") ? "&public" : "");
            set("analytics&name=" + analyticsName + public, analytics).receive((res) => {
                if(res?.length > 0) {
                    alert(res);
                } else {
                    alert("Saved");
                }
                updateAnalytics(true);
            });
        }

        function displayAnalytics(analytics) {
            clear();
            for (const rowSettings of analytics) {
                addRow().create(rowSettings);
            }
        }

        function loadAnalytics() {
            const name = $("#project-select").val();
            if(!name || name.length === 0) {
                alert("Please select a preset");
                return;
            }
            for (const preset of analyticsPresets) {
                if(preset.name === name) {
                    $(".analytics-name").val(name);
                    $(".analytics-name").val(name);
                    $("#analytics-public-check").attr("checked", preset.public == "1");
                    const analytics = JSON.parse(preset.json);
                    displayAnalytics(analytics);
                    // clear()
                    // console.log("loading analytics:");
                    // console.log(analytics);
                    // for (const rowSettings of analytics) {
                    //     addRow().create(rowSettings);
                    // }
                    // console.log(preset);
                }
            }
            window.setTimeout(() => {
                for (const row of rows) {
                    row.draw();
                }
            }, 100);
        }

        function removeAnalytics() {
            const name = $("#project-select").val();
            if(!name) return alert("Choose a preset to remove");
            get("deleteAnalytics", {name}).receive((succsess, res) => {
                if(!succsess) return alert("An error occoured");
                if(res?.length > 0) return alert(res); // alert error message
                alert("Deleted " + name);
                updateAnalytics(false);
            });
        }

        let analyticsPresets = [];

        function updateAnalytics(forceVal) {
            get("analytics").receive((succsess, res) => {
                if(!succsess) return alert("An error occoured :/");
                analyticsPresets = res;
                const val = $("#project-select").val();
                $("#project-select").empty();
                for (const preset of res) {
                    $("#project-select").append(`<option value="${preset.name}">${preset.name} (${preset.owner == phpUser.iduser ? "You" : preset.username}, ${preset.public == "1" ? "public" : "private"})</option>`);
                }
                if(val && forceVal) {
                    $("#project-select").val(val);
                }
            });
        }

        function clear() {
            while(rows.length > 0) {
                removeLastRow();
            }
            localStorage.removeItem("Analytics");
        }

        updateAnalytics(false);

        addRow();
        rows[0].addNew();

        function getSelectorCount(analytics) {
            let i = 0;
            for (const row of analytics) {
                i+=row.selectors.length;
            }
            return i;
        }

        new Tooltip($(".undo-btn"), "CTRL + Z");
        new Tooltip($(".undo-redo"), "CTRL + Y");

        document.addEventListener("keypress", (e) => {
            if (e.keyCode == 26 && e.ctrlKey) undo();
            if (e.keyCode == 25 && e.ctrlKey) redo();
        });

        let history = [];
        let currentHistory = -1;

        function undo() {
            currentHistory--;
            if(currentHistory < 0) {
                currentHistory = 0;
                return;
            }
            displayAnalytics(history[currentHistory]);
            localStorage.setItem("Analytics", JSON.stringify(history[currentHistory]));
        }

        function redo() {
            currentHistory++;
            if(currentHistory >= history.length) {
                currentHistory = history.length - 1;
                return;
            }
            // console.log("redos left: ", -(currentHistory - history.length + 1));
            displayAnalytics(history[currentHistory]);
            localStorage.setItem("Analytics", JSON.stringify(history[currentHistory]));
        }

        // Auto save
        window.setInterval(() => {
            const recoveredAnalyticsString = localStorage.getItem("Analytics");
            const newAnalytics = getAnalytics();
            const newAnalyticsString = JSON.stringify(newAnalytics);
            if(recoveredAnalyticsString != newAnalyticsString) {
                localStorage.setItem("Analytics", newAnalyticsString);
                console.log("Saved");
                currentHistory++;
                history[currentHistory] = newAnalytics;
                history.splice(currentHistory + 1, 10000); // remove everything in ahead

                if(history.length > 20) {
                    history.splice(0, 1);
                    currentHistory--;
                }
            }
        }, 100);

        const recoveredAnalytics = JSON.parse(localStorage.getItem("Analytics"));
        const recoveredProjectName = localStorage.getItem("ProjectName");
        if(recoveredAnalytics) {
            if(getSelectorCount(recoveredAnalytics) > 0) {
                displayAnalytics(recoveredAnalytics);
            }
        }
        if(recoveredProjectName) {
            $(() => {
                $("#project-select").val(recoveredProjectName);
            })
        }
        $("#project-select").change(() => {
            localStorage.setItem("ProjectName", $("#project-select").val());
        });

    </script>
</main>
<?php
include_once "../footer.php";
?>