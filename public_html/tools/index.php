<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("configureAthletes")){
    throwError($ERROR_NO_PERMISSION, "/index.php");
} 

include_once "../header.php";
?>
<main class="athlete-search">
    <h1 class="align center">Competition tools</h1>
    <div class="error color red"></div>
    <a href="/tools/speaker.php">Speaker Tools</a>
    <div>
        <p>
            JSON: [{alias,firstName,lastName,[gender],[nation],[category],}]
        </p>
        <textarea name="" id="" cols="30" rows="10" class="input">
            [
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3243",
      "lastName": "Del Rio",
      "firstName": "Abril",
      "club": "C.M.P Arganda del Rey",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3244",
      "lastName": "Sangiorgi",
      "firstName": "Achille",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3245",
      "lastName": "Rádi",
      "firstName": "Ádám",
      "club": "TDKE Tatabánya",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3246",
      "lastName": "Vajanský",
      "firstName": "Adrian",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3247",
      "lastName": "Moretti",
      "firstName": "Alessandra",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3248",
      "lastName": "Pusiol",
      "firstName": "Alessandro",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3249",
      "lastName": "Maggio",
      "firstName": "Alessia",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3250",
      "lastName": "Paganello",
      "firstName": "Alessia",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3251",
      "lastName": "Wittmack",
      "firstName": "Alessia",
      "club": "SSC Heilbronn",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3252",
      "lastName": "Clementoni",
      "firstName": "Alessio",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3253",
      "lastName": "Piergigli",
      "firstName": "Alessio",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3254",
      "lastName": "Micucci",
      "firstName": "Alex",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3255",
      "lastName": "Ramirez",
      "firstName": "Alexander",
      "club": "COYOTE INLINE",
      "team": "Peru",
      "nation": "PER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3256",
      "lastName": "DOLCI",
      "firstName": "ALICE",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3257",
      "lastName": "Marletti",
      "firstName": "Alice",
      "club": "ASD PATTINATORI SAN MAURO TORINESE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3258",
      "lastName": "Sorcionovo",
      "firstName": "Alice",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3259",
      "lastName": "van der Meijden",
      "firstName": "Amber",
      "club": "HardrijVereniging Den Haag-Westland",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3260",
      "lastName": "Libetti",
      "firstName": "Ambra",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3261",
      "lastName": "Ignoul",
      "firstName": "Amélie",
      "club": "Rolschaatsclub Tienen",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3262",
      "lastName": "Humanes",
      "firstName": "Ana",
      "club": "C.M.P Arganda del Rey",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3263",
      "lastName": "Federici",
      "firstName": "Anastasia",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3264",
      "lastName": "CREMASCHI",
      "firstName": "ANDREA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3265",
      "lastName": "Lokvencová",
      "firstName": "Andrea",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3266",
      "lastName": "Mazzola",
      "firstName": "Andrea",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3267",
      "lastName": "MENEGALDO",
      "firstName": "ANDREA",
      "club": "ASD PATTINATORI SPINEA ITALY",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3268",
      "lastName": "Rihova",
      "firstName": "Andrea",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3269",
      "lastName": "Daleman",
      "firstName": "Angel",
      "club": "Vereniging IJssport Leiderdorp",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3270",
      "lastName": "TIBERTO",
      "firstName": "ANGELA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3271",
      "lastName": "Otto",
      "firstName": "Angelina",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3272",
      "lastName": "Vos",
      "firstName": "Anke",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3273",
      "lastName": "Eppinger",
      "firstName": "Anna",
      "club": "TSuGV Großbettlingen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3274",
      "lastName": "Hunyadi",
      "firstName": "Anna",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3275",
      "lastName": "Pnovska",
      "firstName": "Anna",
      "club": "KSB Benatky",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3276",
      "lastName": "Sajgo",
      "firstName": "Anna",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3277",
      "lastName": "Schaefer",
      "firstName": "Annemarie",
      "club": "TSSC Erfurt e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3278",
      "lastName": "Sangiorgi",
      "firstName": "Annibale",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3279",
      "lastName": "Aalders",
      "firstName": "Anouk",
      "club": "Skeelervereniging de Draai",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3280",
      "lastName": "Buckler",
      "firstName": "Arthur",
      "club": "Wisbech Roller Speed Club",
      "team": "United Kingdom",
      "nation": "GBR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3281",
      "lastName": "Lebeaupin",
      "firstName": "Arthur",
      "club": "ADEL ROLLER SPORT",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3282",
      "lastName": "Libralesso",
      "firstName": "Asia Elsa",
      "club": "ASD PATTINATORI SPINEA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3283",
      "lastName": "Varani",
      "firstName": "Asja",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3284",
      "lastName": "Alzate Alzate",
      "firstName": "Aura Sofia",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3285",
      "lastName": "Zolvan",
      "firstName": "Barbara",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3286",
      "lastName": "Swings",
      "firstName": "Bart",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3287",
      "lastName": "Kee",
      "firstName": "Bas",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3288",
      "lastName": "Meijer",
      "firstName": "Bas",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3289",
      "lastName": "Billen",
      "firstName": "Bente",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3290",
      "lastName": "Kerkhoff",
      "firstName": "Bente",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3291",
      "lastName": "van der Meer",
      "firstName": "Bianca",
      "club": "IJs- en Skeelerclub Lindenoord",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3292",
      "lastName": "Ball",
      "firstName": "Bobby",
      "club": "Skate13 Racing Team",
      "team": "United Kingdom",
      "nation": "GBR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3293",
      "lastName": "Urban",
      "firstName": "Boglarka",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3294",
      "lastName": "Lippens",
      "firstName": "Brecht",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3295",
      "lastName": "Beelen",
      "firstName": "Brend",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3296",
      "lastName": "Groot",
      "firstName": "Bret",
      "club": "ASV",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3297",
      "lastName": "Lowie",
      "firstName": "Britt",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3298",
      "lastName": "van der linden",
      "firstName": "britt",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3299",
      "lastName": "Marlein",
      "firstName": "Caley",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3300",
      "lastName": "Tomassetti",
      "firstName": "Camila",
      "club": "Unión Norte",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3301",
      "lastName": "Zazzarini",
      "firstName": "Camilla",
      "club": "Senigallia Skating",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3302",
      "lastName": "Acosta",
      "firstName": "Camilo",
      "club": "arma arena geisingen",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3303",
      "lastName": "Tagliabue",
      "firstName": "Carlo",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3304",
      "lastName": "Pereira",
      "firstName": "Carlos",
      "club": "ERSG Darmstadt",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3305",
      "lastName": "Falco",
      "firstName": "Carola",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3306",
      "lastName": "Brivio",
      "firstName": "Cecilia",
      "club": "ASD BRIANZA INLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3307",
      "lastName": "CHOPIN",
      "firstName": "Celia",
      "club": "MAMERS ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3308",
      "lastName": "Cavalli",
      "firstName": "Chiara",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3309",
      "lastName": "Cognini",
      "firstName": "Chiara",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3310",
      "lastName": "Racchini",
      "firstName": "Chiara",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3311",
      "lastName": "Rosucci",
      "firstName": "Chiara",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3312",
      "lastName": "Widua",
      "firstName": "Chiara",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3313",
      "lastName": "Berkhout",
      "firstName": "Chris",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3314",
      "lastName": "de Velde",
      "firstName": "Chris",
      "club": "Gewest Fryslan",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3315",
      "lastName": "Kromoser",
      "firstName": "Christian",
      "club": "ÖISC-Burgenland",
      "team": "Austria",
      "nation": "AUT",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3316",
      "lastName": "MANZOTTI",
      "firstName": "CHRISTIAN",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3317",
      "lastName": "Elsäßer",
      "firstName": "Clara",
      "club": "TSSC Erfurt e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3318",
      "lastName": "Kundisch",
      "firstName": "Colin",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3319",
      "lastName": "Papp",
      "firstName": "Csanád",
      "club": "TDKE Tatabánya",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3320",
      "lastName": "SILVESTRE - - STRIEGEL",
      "firstName": "Damien",
      "club": "BISCHHEIM STRASBOURG SKATING",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3321",
      "lastName": "ZAPATA MARTINEZ",
      "firstName": "DANIEL",
      "club": "NL custom",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3322",
      "lastName": "Di Stefano",
      "firstName": "Daniele",
      "club": "Mariani World Team",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3323",
      "lastName": "Oronzo",
      "firstName": "Daphne",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3324",
      "lastName": "Baden",
      "firstName": "David",
      "club": "\u0000",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3325",
      "lastName": "Carletti",
      "firstName": "Davide",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3326",
      "lastName": "Gentili",
      "firstName": "Davide",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3327",
      "lastName": "MENEGALDO",
      "firstName": "DAVIDE",
      "club": "ASD PATTINATORI SPINEA ITALY",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3328",
      "lastName": "TAGLIENTE",
      "firstName": "DAVIDE",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3329",
      "lastName": "Burgmeijer",
      "firstName": "Denice",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3330",
      "lastName": "Nieuwenhuis",
      "firstName": "Denice",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3331",
      "lastName": "Koster",
      "firstName": "Dinly",
      "club": "inline selectie Groningen/Drenthe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3332",
      "lastName": "Silveira",
      "firstName": "Diogo",
      "club": "Inline Marinha Grande",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3333",
      "lastName": "van Hal",
      "firstName": "Dion",
      "club": "KNSB Talent Team Zuidwest",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3334",
      "lastName": "Gardi",
      "firstName": "Dominika",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3335",
      "lastName": "Cecchini",
      "firstName": "Dominique",
      "club": "S. NAZARIO Pattinaggio Varazze",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3336",
      "lastName": "Ferretto",
      "firstName": "Dora",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3337",
      "lastName": "Loureiro",
      "firstName": "Duarte",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3338",
      "lastName": "Marsili",
      "firstName": "Duccio",
      "club": "S.S.D.S Mens Sana in Corpore Sano",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3339",
      "lastName": "ESTRADA VALLECILLA",
      "firstName": "EDWIN ALEXANDER",
      "club": "NL custom",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3340",
      "lastName": "De Vries",
      "firstName": "Elanne",
      "club": "Schaatsvereniging Rotterdam",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3341",
      "lastName": "Nicolaij",
      "firstName": "Elbrich",
      "club": "Ids skeelervereniging",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3342",
      "lastName": "BRIOSCHI",
      "firstName": "ELENA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3343",
      "lastName": "Bocchini",
      "firstName": "Eleonora",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3344",
      "lastName": "Romagnoili",
      "firstName": "Eleonora",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3345",
      "lastName": "Dul",
      "firstName": "Elisa",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3346",
      "lastName": "Folli",
      "firstName": "Elisa",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3347",
      "lastName": "BALINI",
      "firstName": "EMANUELE",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3348",
      "lastName": "Meucci",
      "firstName": "Emma",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3349",
      "lastName": "Valli",
      "firstName": "Emma",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3350",
      "lastName": "Maleček",
      "firstName": "Erik",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3351",
      "lastName": "Rutilo",
      "firstName": "Erminia",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3352",
      "lastName": "REBELLATO",
      "firstName": "ESTER",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3353",
      "lastName": "Korenberg",
      "firstName": "Esther",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3354",
      "lastName": "Kris",
      "firstName": "Etienne",
      "club": "\u0000",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3355",
      "lastName": "Beijeman",
      "firstName": "Ewout",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3356",
      "lastName": "Kuemmel",
      "firstName": "Fabian",
      "club": "LLG-Luckenwalde",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3357",
      "lastName": "Wutte",
      "firstName": "Fabian",
      "club": "SC Highlanders",
      "team": "Austria",
      "nation": "AUT",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3358",
      "lastName": "MERRA",
      "firstName": "FABRIZIO",
      "club": "ASCO SKATING CONCOREZZO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3359",
      "lastName": "Mendarelli",
      "firstName": "Federico",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3360",
      "lastName": "Rijhnen",
      "firstName": "Felix",
      "club": "Powerslide International Team",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3361",
      "lastName": "Moroni",
      "firstName": "Filippo",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3362",
      "lastName": "ZAZZARINI",
      "firstName": "FILIPPO",
      "club": "Senigallia Skating",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3363",
      "lastName": "Milling",
      "firstName": "Finn",
      "club": "TSG Aufbau Union Dessau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3364",
      "lastName": "Kampfenkel",
      "firstName": "Finn Bjarne",
      "club": "Team Redvil Racer / TSG Aufbau Union Dessau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3365",
      "lastName": "Balena",
      "firstName": "Flavia",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3366",
      "lastName": "Huls",
      "firstName": "Fleur",
      "club": "IJs- en Skeelerclub Nijeveen",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3367",
      "lastName": "Veen",
      "firstName": "Fleur",
      "club": "Gewest Fryslan",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3368",
      "lastName": "Plaire",
      "firstName": "Florent",
      "club": "ADEL ROLLER SPORT",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3369",
      "lastName": "BERNARD",
      "firstName": "Florian",
      "club": "ROLLER SKATING CLUB LOURY",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3370",
      "lastName": "Trekels",
      "firstName": "Fons",
      "club": "Reko Rollerclub Zemst",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3371",
      "lastName": "Vanhoutte",
      "firstName": "Fran",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3372",
      "lastName": "Bertolo",
      "firstName": "Francesco",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3373",
      "lastName": "FRIGO",
      "firstName": "FRANCESCO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3374",
      "lastName": "Marchetti",
      "firstName": "Francesco",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3375",
      "lastName": "Petry",
      "firstName": "Franziska",
      "club": "Team Redvil Racer / TSG Aufbau Union Dessau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3376",
      "lastName": "rueda",
      "firstName": "gabriela",
      "club": "Powerslide International Team",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3377",
      "lastName": "Vargas",
      "firstName": "Gabriela",
      "club": "ECUADOR",
      "team": "Ecuador",
      "nation": "ECU",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3378",
      "lastName": "CANNONI",
      "firstName": "GABRIELE",
      "club": "Società Sportiva Dilettantistica Mens Sana in Corp",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3379",
      "lastName": "Moro",
      "firstName": "Gabriele",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3380",
      "lastName": "Lissandron",
      "firstName": "Gaia",
      "club": "ASD PATTINATORI SPINEA ITALY",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3381",
      "lastName": "Cohen",
      "firstName": "Gaspard",
      "club": "ROLLER SKATING LAUNACAIS",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3382",
      "lastName": "Gobbato",
      "firstName": "Giacomo",
      "club": "Azzurra Pattinaggio Corsa Trebaseleghe",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3383",
      "lastName": "LAZZARINI",
      "firstName": "GIACOMO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3384",
      "lastName": "Venier",
      "firstName": "Giacomo",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3385",
      "lastName": "Tortolini",
      "firstName": "Gian Luca",
      "club": "COYOTE INLINE",
      "team": "Peru",
      "nation": "PER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3386",
      "lastName": "Giolo",
      "firstName": "Gianluca",
      "club": "A. S. D. Pattinatori spinea",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3387",
      "lastName": "Curzi",
      "firstName": "Gianmarco",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3388",
      "lastName": "Citterio",
      "firstName": "Gioele",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3389",
      "lastName": "Benigni",
      "firstName": "Giorgia",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3390",
      "lastName": "Campitelli",
      "firstName": "Giorgia",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3391",
      "lastName": "Fossemo",
      "firstName": "Giorgia",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3392",
      "lastName": "Fusetto",
      "firstName": "Giorgia",
      "club": "Team Belotti/Flyke/Luigino",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3393",
      "lastName": "IANNARELLI",
      "firstName": "GIORGIA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3394",
      "lastName": "Valanzano",
      "firstName": "Giorgia",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3395",
      "lastName": "Neve",
      "firstName": "Giosue",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3396",
      "lastName": "Capecci",
      "firstName": "Giovanni",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3397",
      "lastName": "Marelli",
      "firstName": "Giulia",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3398",
      "lastName": "Michettoni",
      "firstName": "Giulia",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3399",
      "lastName": "Presti",
      "firstName": "Giulia",
      "club": "ASD ROLLER CIVITANOVA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3400",
      "lastName": "Serafin",
      "firstName": "Giulia",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3401",
      "lastName": "Girona",
      "firstName": "Giuliana",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3402",
      "lastName": "Bramante",
      "firstName": "Giuseppe",
      "club": "Mariani World Team",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3403",
      "lastName": "Nijenhuis",
      "firstName": "Glenn",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3404",
      "lastName": "Angelini",
      "firstName": "Gloria",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3405",
      "lastName": "Pasquinotti",
      "firstName": "Greta",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3406",
      "lastName": "Lorenzoni",
      "firstName": "Guglielmo",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3407",
      "lastName": "Bíró",
      "firstName": "Hanna",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3408",
      "lastName": "Schübl",
      "firstName": "Hanna",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3409",
      "lastName": "van der woerd",
      "firstName": "hylkje",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3410",
      "lastName": "Ronzani",
      "firstName": "Ilaria",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3411",
      "lastName": "VECCHI",
      "firstName": "ILARIA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3412",
      "lastName": "Médard",
      "firstName": "Indra",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3413",
      "lastName": "Hildebrandt",
      "firstName": "Inka",
      "club": "TSG Aufbau Union Dessau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3414",
      "lastName": "Fernandez",
      "firstName": "Ioseba",
      "club": "Federación Navarra de Patinaje",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3415",
      "lastName": "Steegstra",
      "firstName": "Isa",
      "club": "De IJsster",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3416",
      "lastName": "Fuchs",
      "firstName": "Isabell",
      "club": "Blau-Gelb Groß-Gerau / Team Hessen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3417",
      "lastName": "Maoloni",
      "firstName": "Iuliano",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3418",
      "lastName": "de la porte",
      "firstName": "Ivo",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3419",
      "lastName": "DE PABLOS",
      "firstName": "IZAN",
      "club": "CMP ARGANDA",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3420",
      "lastName": "PODLIPSKÝ",
      "firstName": "JÁCHYM",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3421",
      "lastName": "Mantilla",
      "firstName": "Jacobo",
      "club": "Powerslide International Team",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3422",
      "lastName": "Lecoq",
      "firstName": "Jade",
      "club": "CPAL LOCMINE",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3423",
      "lastName": "Keitel",
      "firstName": "Jakob",
      "club": "TSV Bernhausen e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3424",
      "lastName": "Kovarik",
      "firstName": "Jakub",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3425",
      "lastName": "Horak",
      "firstName": "Jan",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3426",
      "lastName": "Mooijman",
      "firstName": "Jan",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3427",
      "lastName": "Bohumska",
      "firstName": "Jana",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3428",
      "lastName": "Weber",
      "firstName": "Janek",
      "club": "Skate Team Celle",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3429",
      "lastName": "van der Ende",
      "firstName": "Janna Wietske",
      "club": "Skeelervereniging IDS",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3430",
      "lastName": "Berkhout",
      "firstName": "Janne",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3431",
      "lastName": "Seyfarth",
      "firstName": "Jannes",
      "club": "Speedskating Leipzig e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3432",
      "lastName": "Haitjema",
      "firstName": "Jarno",
      "club": "IJs- en Skeelerclub Lindenoord",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3433",
      "lastName": "Van der Ent",
      "firstName": "Jarno",
      "club": "IJs en Skeelerclub Hoeksewaard",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3434",
      "lastName": "Nieuwenhuis",
      "firstName": "Jasmijn",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3435",
      "lastName": "Suttels",
      "firstName": "Jason",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3436",
      "lastName": "RENCKER",
      "firstName": "Jeanne",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3437",
      "lastName": "Yakovleva",
      "firstName": "Jekatherina",
      "club": "TSSC Erfurt e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3438",
      "lastName": "Fransen",
      "firstName": "Jet",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3439",
      "lastName": "Beek",
      "firstName": "Jette",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3440",
      "lastName": "Guzman",
      "firstName": "Jhoan",
      "club": "AnTisTasi",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3441",
      "lastName": "Haj",
      "firstName": "Jihad",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3442",
      "lastName": "VILLAINE-BRIANT",
      "firstName": "Joan",
      "club": "MAMERS ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3443",
      "lastName": "Dias",
      "firstName": "João",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3444",
      "lastName": "Kloninger",
      "firstName": "Joel",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3445",
      "lastName": "Pracharova",
      "firstName": "Johana",
      "club": "RTS Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3446",
      "lastName": "Stodolova",
      "firstName": "Johana",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3447",
      "lastName": "Brissinck",
      "firstName": "jolan",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3448",
      "lastName": "Rudolph",
      "firstName": "Jon",
      "club": "RSV Blau Weiss Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3449",
      "lastName": "Laieb",
      "firstName": "Jonah",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3450",
      "lastName": "ániel",
      "firstName": "Jónás",
      "club": "TDKE Tatabánya",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3451",
      "lastName": "Vansteenkiste",
      "firstName": "Joren",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3452",
      "lastName": "ten Cate",
      "firstName": "Jorian",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3453",
      "lastName": "de Vries",
      "firstName": "Jorn",
      "club": "ASV",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3454",
      "lastName": "Geerts",
      "firstName": "Jorun",
      "club": "Reko Rollerclub Zemst",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3455",
      "lastName": "Whyte",
      "firstName": "Josh",
      "club": "arma arena geisingen team",
      "team": "New Zealand",
      "nation": "NZL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3456",
      "lastName": "Dueñas Piraban",
      "firstName": "Juan Esteban",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3457",
      "lastName": "felix",
      "firstName": "jules",
      "club": "krokosports",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3458",
      "lastName": "BEDON",
      "firstName": "JULIA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3459",
      "lastName": "Beech",
      "firstName": "Julia",
      "club": "Blau-Gelb Gross-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3460",
      "lastName": "Stiller",
      "firstName": "Julian",
      "club": "TSV Bernhausen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3461",
      "lastName": "de Blois",
      "firstName": "Junior",
      "club": "Knsb ZH Opleidingsgroep Zuidwest inline",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3462",
      "lastName": "Ottenhoff",
      "firstName": "Kai-Arne",
      "club": "KNSB Talent Team Zuidwest",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3463",
      "lastName": "Rocha Cajamarca",
      "firstName": "Karen Sofia",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3464",
      "lastName": "van den Belt",
      "firstName": "Karl",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3465",
      "lastName": "Ivanyi",
      "firstName": "Kata",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3466",
      "lastName": "Kainová",
      "firstName": "Kateřina",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3467",
      "lastName": "Zatloukalová",
      "firstName": "Kateřina",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3468",
      "lastName": "Kaiser",
      "firstName": "Katja",
      "club": "Arena Geisingen inlineSport e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3469",
      "lastName": "Schipper",
      "firstName": "Kay",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3470",
      "lastName": "Delgado",
      "firstName": "Keily",
      "club": "Unión Norte",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3471",
      "lastName": "Serriere",
      "firstName": "Kiara",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3472",
      "lastName": "Jungova",
      "firstName": "Kristyna",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3473",
      "lastName": "Schimek",
      "firstName": "Laethisia",
      "club": "Blau-Gelb Groß-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3474",
      "lastName": "Gaiser",
      "firstName": "Larissa",
      "club": "arma arena geisingen team",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3475",
      "lastName": "Patrouille",
      "firstName": "Lars",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3476",
      "lastName": "Narain",
      "firstName": "Lataesha",
      "club": "Regio Selectie Midden Nederland",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3477",
      "lastName": "Lorenzato",
      "firstName": "Laura",
      "club": "G.S.S. GRUPPO SPORTIVO SCALTENIGO VENEZIA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3478",
      "lastName": "Gonzalez Molina",
      "firstName": "Laura Valentina",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3479",
      "lastName": "Bergé",
      "firstName": "Laurens",
      "club": "Rolschaatsclub Tienen",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3480",
      "lastName": "Corradini",
      "firstName": "Lea",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3481",
      "lastName": "Bollaers",
      "firstName": "Lena",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3482",
      "lastName": "Majewska",
      "firstName": "Lena",
      "club": "arena geisingen InlineSport e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3483",
      "lastName": "Kusters",
      "firstName": "Lenn",
      "club": "Rolschaatsclub Tienen",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3484",
      "lastName": "BOSSI",
      "firstName": "LEONARDO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3485",
      "lastName": "De Angelis",
      "firstName": "Leonardo",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3486",
      "lastName": "Martinelli",
      "firstName": "Leonardo",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3487",
      "lastName": "Imhof",
      "firstName": "Leonie",
      "club": "Blau-Gelb Gross-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3488",
      "lastName": "Ohl",
      "firstName": "Leonie Florence",
      "club": "Blau-Gelb Gross-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3489",
      "lastName": "Soriani",
      "firstName": "Letizia",
      "club": "Rolling pattinatori bosica",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3490",
      "lastName": "Van loon",
      "firstName": "Lianne",
      "club": "\u0000",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3491",
      "lastName": "Muders",
      "firstName": "Lilia",
      "club": "Blau-Gelb Groß-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3492",
      "lastName": "Sandor",
      "firstName": "Lilla",
      "club": "Tornado Team",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3493",
      "lastName": "Weidener",
      "firstName": "Lilly",
      "club": "RSV Blau Weiss Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3494",
      "lastName": "CHOPIN",
      "firstName": "Lina",
      "club": "MAMERS ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3495",
      "lastName": "Schumann",
      "firstName": "Lina",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3496",
      "lastName": "Pozzi",
      "firstName": "Lisa",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3497",
      "lastName": "Dijkstra",
      "firstName": "Lise",
      "club": "Skeelervereniging IDS",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3498",
      "lastName": "Wenger",
      "firstName": "Livio",
      "club": "arma arena geisingen team",
      "team": "Switzerland",
      "nation": "SUI",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3499",
      "lastName": "Busser",
      "firstName": "Loes",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3500",
      "lastName": "LAMARE",
      "firstName": "Lois",
      "club": "MAMERS ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3501",
      "lastName": "Müller",
      "firstName": "Lorenz",
      "club": "VfL Ulm",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3502",
      "lastName": "Cirilli",
      "firstName": "Lorenzo",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3503",
      "lastName": "Reschini",
      "firstName": "Lorenzo",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3504",
      "lastName": "Veenstra",
      "firstName": "lotte",
      "club": "inline selectie Groningen/Drenthe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3505",
      "lastName": "Verburgh",
      "firstName": "Lotte",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3506",
      "lastName": "LORGERAY",
      "firstName": "Louis",
      "club": "MAMERS ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3507",
      "lastName": "Leemans",
      "firstName": "Louka",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3508",
      "lastName": "Rudolph",
      "firstName": "Luca",
      "club": "RSV Blau-Weiß Gera",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3509",
      "lastName": "Callegari",
      "firstName": "Lucia",
      "club": "ASD PATTINATORI SPINEA ITALY",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3510",
      "lastName": "Korvasova",
      "firstName": "Lucie",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3511",
      "lastName": "De Palma",
      "firstName": "Lucrezia",
      "club": "S.S.D.S Mens Sana in Corpore Sano",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3512",
      "lastName": "Mcinerney",
      "firstName": "Lucy",
      "club": "Skate13 Racing Team",
      "team": "United Kingdom",
      "nation": "GBR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3513",
      "lastName": "Woolaway",
      "firstName": "Luisa Sophie",
      "club": "A.S.Co Skating Concorezzo",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3514",
      "lastName": "Mares",
      "firstName": "Lukas",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3515",
      "lastName": "Pribik",
      "firstName": "Lukas",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3516",
      "lastName": "Lau",
      "firstName": "Luna-Marie",
      "club": "talent Team Denmark",
      "team": "Denmark",
      "nation": "DEN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3517",
      "lastName": "Vansteenkiste",
      "firstName": "Lyssa",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3518",
      "lastName": "Simon",
      "firstName": "Maelya",
      "club": "ASPHALTE ROLLER RIXHEIM WITTENHEIM",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3519",
      "lastName": "Jeppesen",
      "firstName": "Magnus Normann",
      "club": "Talent Team Denmark",
      "team": "Denmark",
      "nation": "DEN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3520",
      "lastName": "Stam",
      "firstName": "Maik",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3521",
      "lastName": "Kurth",
      "firstName": "Manisha",
      "club": "Inline Club Mittelland",
      "team": "Switzerland",
      "nation": "SUI",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3522",
      "lastName": "Eppinger",
      "firstName": "Manuel",
      "club": "TSuGV Großbettlingen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3523",
      "lastName": "Ghiotto",
      "firstName": "Manuel",
      "club": "CIPRIANI TEAM ITALY",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3524",
      "lastName": "Peraboni",
      "firstName": "Manuel",
      "club": "ASCO SKATING CONCOREZZO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3525",
      "lastName": "robla",
      "firstName": "manuel",
      "club": "Ciudad del Turia",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3526",
      "lastName": "BEDON",
      "firstName": "MARCO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3527",
      "lastName": "Pieraccini",
      "firstName": "Marco",
      "club": "S.S.D.S Mens Sana in Corpore Sano",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3528",
      "lastName": "Prochazka",
      "firstName": "Marek",
      "club": "RTS Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3529",
      "lastName": "Meucci",
      "firstName": "Margherita",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3530",
      "lastName": "Minghi",
      "firstName": "Margherita",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3531",
      "lastName": "Fritz Barrera",
      "firstName": "Maria Jose",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3532",
      "lastName": "Yañez",
      "firstName": "María José",
      "club": "Unión Norte",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3533",
      "lastName": "VIVAS MENDOZA",
      "firstName": "MARIA PAULA",
      "club": "CLUB TEQUENDAMA",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3534",
      "lastName": "Sänger",
      "firstName": "Marie",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3535",
      "lastName": "de Vries",
      "firstName": "Marieke",
      "club": "Skeelervereniging de Draai",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3536",
      "lastName": "Gottwein-Hopp",
      "firstName": "Mariesol",
      "club": "ERSG Darmstadt",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3537",
      "lastName": "Fajkusova",
      "firstName": "Marketa",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3538",
      "lastName": "Vansteenkiste",
      "firstName": "Marlies",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3539",
      "lastName": "Ferretti",
      "firstName": "Martina",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3540",
      "lastName": "Klotz",
      "firstName": "Marvin",
      "club": "SSF Heilbronn",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3541",
      "lastName": "Molenaar",
      "firstName": "Mathijs",
      "club": "KNSB Talent Team Zuidwest",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3542",
      "lastName": "CHAMPAGNAC",
      "firstName": "Mathilde",
      "club": "PIBRAC ROLLER SKATING",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3543",
      "lastName": "Pedronno",
      "firstName": "Mathilde",
      "club": "CPAL LOCMINE",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3544",
      "lastName": "Cherubini",
      "firstName": "Matilde",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3545",
      "lastName": "NAPOLITANO",
      "firstName": "MATILDE",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3546",
      "lastName": "Barison",
      "firstName": "Matteo",
      "club": "Azzurra Pattinaggio Corsa Trebaseleghe",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3547",
      "lastName": "Giana",
      "firstName": "Matteo",
      "club": "S. NAZARIO Pattinaggio Varazze",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3548",
      "lastName": "Calzati",
      "firstName": "Mattia",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3549",
      "lastName": "Siri",
      "firstName": "Mattia",
      "club": "S. NAZARIO Pattinaggio Varazze",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3550",
      "lastName": "Marosi",
      "firstName": "Maurice",
      "club": "Speedteam Bodensee",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3551",
      "lastName": "Gatti",
      "firstName": "Melissa",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3552",
      "lastName": "Mooijman",
      "firstName": "Melissa",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3553",
      "lastName": "Haemels",
      "firstName": "Merel",
      "club": "Reko Rollerclub Zemst",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3554",
      "lastName": "Jilek",
      "firstName": "Metodej",
      "club": "RTS Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3555",
      "lastName": "Falaschi",
      "firstName": "Michel",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3556",
      "lastName": "Rocchetti",
      "firstName": "MIchele",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3557",
      "lastName": "Monteiro",
      "firstName": "Miguel",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3558",
      "lastName": "Brissinck",
      "firstName": "milan",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3559",
      "lastName": "De Lange",
      "firstName": "Milou",
      "club": "RTC Zuidwest Inline / Otweg",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3560",
      "lastName": "Pracharova",
      "firstName": "Monika",
      "club": "RTS Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3561",
      "lastName": "Oster",
      "firstName": "Naël",
      "club": "BISCHHEIM STRASBOURG SKATING",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3562",
      "lastName": "Carrero Lopez",
      "firstName": "Nagge Andreina",
      "club": "Unión Norte",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3563",
      "lastName": "Gaßmann",
      "firstName": "Nele",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3564",
      "lastName": "Gross",
      "firstName": "Nevio",
      "club": "Rollerblade Team Schweiz",
      "team": "Switzerland",
      "nation": "SUI",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3565",
      "lastName": "Alba Forero",
      "firstName": "Nicolás",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3566",
      "lastName": "Bardella",
      "firstName": "Nicolò",
      "club": "ASD PATTINATORI SPINEA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3567",
      "lastName": "van Haaren",
      "firstName": "Niels",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3568",
      "lastName": "Noordergraaf",
      "firstName": "Nikki",
      "club": "HardrijVereniging Den Haag-Westland",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3569",
      "lastName": "Kubik",
      "firstName": "Niklas",
      "club": "SV Flaeming-Skate e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3570",
      "lastName": "Uhlig",
      "firstName": "Nils",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3571",
      "lastName": "Corradini",
      "firstName": "Nina",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3572",
      "lastName": "AUBERT",
      "firstName": "Noah",
      "club": "ARVOR ROLLER SPORT",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3573",
      "lastName": "POMMIER",
      "firstName": "Nolann",
      "club": "CSB Roller Sports",
      "team": "France, Metropolitan",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3574",
      "lastName": "Gödöny",
      "firstName": "Norbert",
      "club": "TDKE Tatabánya",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3575",
      "lastName": "Urbanek",
      "firstName": "Norbert",
      "club": "TDKE Tatabánya",
      "team": "Hungary",
      "nation": "HUN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3576",
      "lastName": "Grob",
      "firstName": "Oliver",
      "club": "arma arena geisingen team",
      "team": "Switzerland",
      "nation": "SUI",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3577",
      "lastName": "Novacek",
      "firstName": "Ondrej",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3578",
      "lastName": "Schmidt",
      "firstName": "Oskar",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3579",
      "lastName": "Koot",
      "firstName": "Patricia",
      "club": "RTC ZW",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3580",
      "lastName": "Selzer",
      "firstName": "Pauline",
      "club": "Blau-Gelb Groß-Gerau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3581",
      "lastName": "CAUSIL ROJAS",
      "firstName": "PEDRO ARMANDO",
      "club": "NL custom",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3582",
      "lastName": "Šnajdr",
      "firstName": "Petr",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3583",
      "lastName": "Schwörer",
      "firstName": "Pia",
      "club": "arena geisingen InlineSport e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3584",
      "lastName": "Albera",
      "firstName": "Pietro",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3585",
      "lastName": "Molinaroli",
      "firstName": "Piotr",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3586",
      "lastName": "Rios Vergara",
      "firstName": "Raquel Cecilia",
      "club": "pegasos elite",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3587",
      "lastName": "Zingaretti",
      "firstName": "Rebecca",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3588",
      "lastName": "Kwant",
      "firstName": "Rémon",
      "club": "Skeelervereniging Staphorst",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3589",
      "lastName": "Nieuwenhuis",
      "firstName": "Rens",
      "club": "Skeelerclub Oost Veluwe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3590",
      "lastName": "BOSSI",
      "firstName": "RICCARDO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3591",
      "lastName": "CEOLA",
      "firstName": "RICCARDO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3592",
      "lastName": "Favro",
      "firstName": "Riccardo",
      "club": "NEW ROLLER PORCIA ASD",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3593",
      "lastName": "Iacoponi",
      "firstName": "Riccardo",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3594",
      "lastName": "LORELLO",
      "firstName": "RICCARDO",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3595",
      "lastName": "Schipper",
      "firstName": "Rick",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3596",
      "lastName": "De Gianni",
      "firstName": "Rita",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3597",
      "lastName": "Beelen",
      "firstName": "Robbe",
      "club": "Belgian Skate Friends",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3598",
      "lastName": "maiorca",
      "firstName": "roberto",
      "club": "Team Belotti/Flyke/Luigino",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3599",
      "lastName": "Albino",
      "firstName": "Rodrigo",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3600",
      "lastName": "Soni",
      "firstName": "Rohan",
      "club": "Reko Rollerclub Zemst",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3601",
      "lastName": "Dijkstra",
      "firstName": "Ruurd",
      "club": "IJs- en Skeelerclub Lindenoord",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3602",
      "lastName": "Sanchez Oviedo",
      "firstName": "Salome",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3603",
      "lastName": "Morris",
      "firstName": "Samuel",
      "club": "ASCO SKATING CONCOREZZO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3604",
      "lastName": "Stirnat",
      "firstName": "Samuel",
      "club": "ERSG Darmstadt / Team Hessen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3605",
      "lastName": "Sulc",
      "firstName": "Samuel",
      "club": "KSB Benatky",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3606",
      "lastName": "Angelini",
      "firstName": "Samuele",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3607",
      "lastName": "Stocco",
      "firstName": "Samuele",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3608",
      "lastName": "Tas",
      "firstName": "Sandrine",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3609",
      "lastName": "Oosterwijk",
      "firstName": "Sanne",
      "club": "Skeelervereniging de Draai",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3610",
      "lastName": "CABRERA",
      "firstName": "SARA",
      "club": "Ciudad del Turia",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3611",
      "lastName": "Gatti",
      "firstName": "Sara",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3612",
      "lastName": "Varsamisova",
      "firstName": "Sara",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3613",
      "lastName": "VEZZOLI",
      "firstName": "SARA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3614",
      "lastName": "Militello",
      "firstName": "Sarah",
      "club": "Blau-Gelb Groß-Gerau / Team Hessen",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3615",
      "lastName": "Schenk",
      "firstName": "Sascha",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3616",
      "lastName": "Valli",
      "firstName": "Saverio",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3617",
      "lastName": "Sepulveda",
      "firstName": "Sebastian",
      "club": "COYOTE INLINE",
      "team": "Peru",
      "nation": "PER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3618",
      "lastName": "van Beek",
      "firstName": "Sem",
      "club": "KNSB Talent Team Zuidwest",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3619",
      "lastName": "Gomez",
      "firstName": "Sheila",
      "club": "C.M.P Arganda del Rey",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3620",
      "lastName": "suttels",
      "firstName": "siebe",
      "club": "Belgian Skate Friends",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3621",
      "lastName": "Troost",
      "firstName": "Sietse",
      "club": "Reko Rollerclub Zemst",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3622",
      "lastName": "Düppre",
      "firstName": "Simon",
      "club": "ERSG Darmstadt",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3623",
      "lastName": "Saraza",
      "firstName": "Simón",
      "club": "Grandes Paisas",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3624",
      "lastName": "Piccoli",
      "firstName": "Simone",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3625",
      "lastName": "Reyer",
      "firstName": "Sina",
      "club": "TSSC Erfurt e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3626",
      "lastName": "Calzati",
      "firstName": "Sofia",
      "club": "ASD BRIANZAINLINE",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3627",
      "lastName": "Clementoni",
      "firstName": "Sofia",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3628",
      "lastName": "Güntter",
      "firstName": "Sofia",
      "club": "SSC Heilbronn",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3629",
      "lastName": "SARONNI",
      "firstName": "SOFIA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3630",
      "lastName": "Schilder",
      "firstName": "Sofia",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3631",
      "lastName": "Chiumiento",
      "firstName": "Sofia Paola",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3632",
      "lastName": "Nijboer",
      "firstName": "Sophie",
      "club": "\u0000",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3633",
      "lastName": "genouw",
      "firstName": "staci",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3634",
      "lastName": "Beelen",
      "firstName": "Stan",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3635",
      "lastName": "Vovk",
      "firstName": "Stanislav",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3636",
      "lastName": "Schmidt",
      "firstName": "Stefan Due",
      "club": "Bont Nordic",
      "team": "Denmark",
      "nation": "DEN",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3637",
      "lastName": "Wagenaar",
      "firstName": "Steyn",
      "club": "Skeelervereniging IDS",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3638",
      "lastName": "Vanhoutte",
      "firstName": "Stien",
      "club": "Zwaantjes Rollerclub Zandvoorde",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3639",
      "lastName": "VILLEGAS CEBALLOS",
      "firstName": "STIVEN",
      "club": "NL custom",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3640",
      "lastName": "Rocchetti",
      "firstName": "Susanna",
      "club": "Bi Roller Pattinaggio Biella",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3641",
      "lastName": "Ruiz Beltran",
      "firstName": "Sylvana",
      "club": "AVIVAS",
      "team": "Colombia",
      "nation": "COL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3642",
      "lastName": "Ohme",
      "firstName": "Tamino",
      "club": "SC DHfK Leipzig",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3643",
      "lastName": "Barker",
      "firstName": "Taylor",
      "club": "Wisbech Inline Speed Skating Club",
      "team": "United Kingdom",
      "nation": "GBR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3644",
      "lastName": "Schouten",
      "firstName": "Teun",
      "club": "Regio Selectie Midden Nederland",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3645",
      "lastName": "Varsamisova",
      "firstName": "Thea",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3646",
      "lastName": "Biasiolo",
      "firstName": "Thomas",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3647",
      "lastName": "van Oost",
      "firstName": "Thomas",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3648",
      "lastName": "Mestre",
      "firstName": "Tiago",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3649",
      "lastName": "Monteiro",
      "firstName": "Tiago",
      "club": "Roller Lagos C.P.",
      "team": "Portugal",
      "nation": "POR",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3650",
      "lastName": "Kee",
      "firstName": "Tim",
      "club": "Radboud Inline-skating",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-424"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3651",
      "lastName": "Lehnertz",
      "firstName": "Timo",
      "club": "\u0000",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3652",
      "lastName": "Krupka",
      "firstName": "Tobias",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3653",
      "lastName": "Mulder",
      "firstName": "Tom",
      "club": "Rolschaatsclub Heverlee",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3654",
      "lastName": "Bohumský",
      "firstName": "Tomá",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3655",
      "lastName": "Barison",
      "firstName": "Tommaso",
      "club": "Azzurra Pattinaggio Corsa Trebaseleghe",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3656",
      "lastName": "Marzucchi",
      "firstName": "Tommaso",
      "club": "SSDS MENS SANA IN CORPORE SANO 1871 SIENA",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3657",
      "lastName": "Van der wier",
      "firstName": "Udo",
      "club": "inline selectie Groningen/Drenthe",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-426"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3658",
      "lastName": "Mendoza Alvarez",
      "firstName": "Valentina",
      "club": "CMP ARGANDA",
      "team": "Spain",
      "nation": "ESP",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3659",
      "lastName": "Nappi",
      "firstName": "Valentina",
      "club": "DEBBY ROLLER TEAM",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3660",
      "lastName": "WONG",
      "firstName": "VANESSA",
      "club": "MX TAKINO International",
      "team": "Hong Kong",
      "nation": "HKG",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3661",
      "lastName": "Zimmermann",
      "firstName": "Vanessa",
      "club": "RSV Blau-Weiß Gera e.V.",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3662",
      "lastName": "Dykastová",
      "firstName": "Veronika",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3663",
      "lastName": "Korvasova",
      "firstName": "Veronika",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-427"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3664",
      "lastName": "Rihova",
      "firstName": "Veronika",
      "club": "KSBM Praha",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-425"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3665",
      "lastName": "Reynaerts",
      "firstName": "Vik",
      "club": "Rolschaatsclub Tienen",
      "team": "Belgium",
      "nation": "BEL",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-422"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3666",
      "lastName": "Hanzelkova",
      "firstName": "Viktorie",
      "club": "IN-LINE VESELÍ",
      "team": "Czech Republic",
      "nation": "CZE",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3667",
      "lastName": "maiorca",
      "firstName": "vincenzo",
      "club": "Mariani World Team",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3668",
      "lastName": "BRAMBILLA",
      "firstName": "VIOLA",
      "club": "ASD Polisportiva Bellusco",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3669",
      "lastName": "Falconi",
      "firstName": "Viola",
      "club": "LunA Sports Academy a.s.d.",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3670",
      "lastName": "Braun",
      "firstName": "Violette",
      "club": "BISCHHEIM STRASBOURG SKATING",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3671",
      "lastName": "Marchiotto",
      "firstName": "Vittoria",
      "club": "Pattinaggio Alte Ceccato",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3672",
      "lastName": "Zijlstra",
      "firstName": "Yanouk",
      "club": "Ids skeelervereniging",
      "team": "Netherlands",
      "nation": "NED",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-421"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3673",
      "lastName": "Soriani",
      "firstName": "Yuri",
      "club": "A.S.D. ROLLING PATTINATORI BOSICA MARTINSICURO",
      "team": "Italy",
      "nation": "ITA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3674",
      "lastName": "SIVILIER",
      "firstName": "Yvan",
      "club": "ROLLER SKATING CLUB LOURY",
      "team": "France",
      "nation": "FRA",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-428"
    },
    {
      "id": "43Z46ltdUAomEO3MFaLJ-3675",
      "lastName": "Czäczine",
      "firstName": "Zora Lilly",
      "club": "TSG Aufbau Union Dessau",
      "team": "Germany",
      "nation": "GER",
      "event": "ml2UIbo6GgKBptuqRMIu",
      "ageGroup": "43Z46ltdUAomEO3MFaLJ-423"
    }
  ]
        </textarea>
        <button onclick="update()">Update</button>
        <div class="preview">
            
        </div>
    </div>
    <input type="text" class="aliasGroupName">
    <button onclick="apply()">Apply</button>
</main>
<script>
    // $(".input").on("input", update);

    let athletes = [];

    function update() {
        $(".error").empty();
        const text = $(".input").val();
        if(IsJson(text)) {
            const json = JSON.parse(text);
            process(json);
        } else {
            $(".error").append(`Invalid JSON`);
        }
    }

    /**
     * Valid athlete properties:
     *  firstName,
     *  lastName,
     *  gender,
     *  nation,
     *  category,
     *  alias
     */
    function process(search) {
        post("searchAthletes", search).receive((succsess, res) => {
            if(res) {
                console.log(res);
                athletes = res;
                updateUI();
            } else {
                console.log("no succsess");
            }
        });
    }

    function updateUI() {
        $(".preview").empty();
        let id = 0;
        let odd = true;
        let found = 0;
        let unsafe = 0;
        for (const search of athletes) {
            odd = !odd;
            const row = $(`<div class="select-row" ${odd ? "style='background-color: #333;'" : ""}></div>`);

            row.append(
            `<div class="prev-info">
                <span class="alias">${search.search.alias          || "-"}</span>
                <span class="first-name">${search.search.firstName || "-"}</span>
                <span class="last-name">${search.search.lastName   || "-"}</span>
                <span class="gender">${search.search.gender        || "-"}</span>
                <span class="country">${search.search.country      || "-"}</span>
            </div>`);

            
            const results = $(`<div class="results"></div>`);
            
            // deleting doublicates
            const ids = [];
            const newResults = [];
            for (const result of search.result) {
                if(!ids.includes(result.id)) {
                    newResults.push(result);
                    ids.push(result.id);
                }
            }
            search.result = newResults;

            if(search.result.length > 1) {
                if(parseFloat(search.result[0].priority) > parseFloat(search.result[1].priority)) {
                    search.result[0].isBest = true;
                    search.linkId = search.result[0].id;
                }
            } else if(search.result.length === 1) {
                search.result[0].isBest = true;
                search.linkId = search.result[0].id;
            }
            if(search.result.length > 0 && search.result[0].isBest) {
                found++;
                while(search.result.length > 3) {
                    search.result.pop();
                }
            }
            if(search.result.length > 0 && !search.result[0].isBest) {
                unsafe++;
            }

            const uiId = id;
            for (const athlete of search.result) {
                const athleteUid = getUid();
                const res = $(`<div class="res">
                    <input id="${athleteUid}" type="radio" name="${uiId}" ${athlete.isBest ? "checked" : ""} value="${athlete.id}">
                    <label for="${athleteUid}">
                        <div>${athlete.priority}</div>
                        <img class="profile-img" src="${getProfileImg(athlete.image, athlete.gender)}">
                        ${getGenderImg(athlete.gender)}
                        <span class="first-name">${athlete.firstname}</span>
                        <span class="last-name">${athlete.lastname}</span>
                        <span class="">${athlete.country}</span>
                        <div><a target="_blank" href="/athlete/index.php?id=${athlete.id}"><i class="fa-solid fa-link"></i></a></div>
                    </label>
                </div>`)
                results.append(res);
                results.find("input").on("change", () => {
                    search.linkId = $(`input:radio[name="${uiId}"]:checked`).val();
                    row.find(".best").removeClass("best");
                    $(`input:radio[name="${uiId}"]:checked`).parent().addClass("best");
                    console.log(athletes);
                });
                if(athlete.isBest) {
                    res.addClass("best");
                }
            }
            
            row.append(results);
            $(".preview").append(row);
            id++;
        }
        alert(`Found ${found} / ${athletes.length} Athletes. ${unsafe} not sure.`);
    }

    function getGenderImg(gender) {
        switch(gender?.toUpperCase()){
            case "m":
            case 'M': return `<i class="fas fa-mars"></i>`;
            case "w":
            case 'W': return `<i class="fas fa-venus"></i>`;
            case "d":
            case 'D': return `<img src="/img/diverse.png" alt="diverse">`;
        }
    }

    function apply() {
        const aliasGroup = $(".aliasGroupName").val();
        if(aliasGroup.length <= 0) {
            alert("please provide group name");
            return;
        }
        if(aliasGroup.length > 128) {
            alert("Group name can't be longer than 128 chars");
            return;
        }
        const aliases = {
            aliases: [],
            aliasGroup
        };
        for (const athlete of athletes) {
            if(!athlete.search.alias && !athlete.search.id) {
                alert("No alias given for " + athlete.search.firstName + " " + athlete.search.lastName);
                return;
            }
            aliases.aliases.push({
                idAthlete: athlete.linkId,
                alias: athlete.search.alias || athlete.search.id,
                previous: JSON.stringify(athlete.search)
            });
        }
        $("main").append(`<div class="loading circle"/>`);
        post("putAliases", aliases).receive((succsess, res) => {
            $(".loading").remove();
            if(succsess) {
                alert("Succsess");
            } else {
                alert("An error occured");
            }
            console.log(res);
        });
    }
    
    function getProfileImg(image, gender) {
        if(image != undefined){
            if(typeof image === "string"){
                return `/img/uploads/${image}`;
            }
        } else {
            if(gender?.toUpperCase() === "W"){
                return `/img/profile-female.png`
            } else{
                return `/img/profile-men.png`;
            }
        }
    }

    function IsJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
</script>
<?php
    include_once "../footer.php";
?>