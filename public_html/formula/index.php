<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formula playground</title>
    <script src="https://unpkg.com/monaco-editor@latest/min/vs/loader.js"></script>
</head>
<body>
    <style>
    #container {
        /* position: absolute; */
        width: 100%;
        height: 30rem;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
    </style>
    <h1>Formula playground</h1>
    <div id="container">container</div>
    <br>
    <button onclick="run()">Run</button>
    <hr>
    <h2>Output:</h2>
    <pre id="pre">
    </pre>
<script>
    let formula = `var res = 0;
/**
 * ArrayOperatorParser, ArrayParser
 */
int[] a = {1,2,3};


res += a[2]; // 3

/**
 * BreakStatementParser, DoWhileStatementParser, CodeBlockParser
 */
do {
  res++; // 4
  break;
} while(true);


/**
 * IfStatementParser
 */

if(true)
  res++; // 5

if(false)
  res++;
else
  res--; // 4

if(false)
  res++;
else if(true)
  res--; // 3

if(false)
  res++;
else if(false)
  res--;
else
  res++; // 4

if(true) {
  res--; // 3
} else if(false) {
  // nothing
} else {
  // nothing
}

/**
 * CallOperatorParser
 */
res += sum(1,2); // 6

/**
 * ContinueStatementParser, ForStatementParser
 */
for(int i=0;i<10;i++) {
  if(i % 2 == 0) {
    continue;
  }
  res++; // 11
}

int i = 0;

for(;true;) {
  if(i >= 2) {
    break;
  }
  res++; // 13
  i++;
}

/**
 * Ternary
 */
true ? i++ : i--; // 14
false ? i++ : i--; // 13

/**
 * ForEachStatementParser
 */
var arr = {1,2,4};
for(int item : arr)
  res += item; // 20

for(final var item : arr) {
  res += item; // 27
}

/**
 * Vargs
 */
void addRes(int... num) {
  for(final var item : num) {
    res += item; 
  }
  return; // test empty return
}

addRes(1,2);// 30

/**
 * default expression
 */
void addRes2(int num = 2) {
  res += num;
}

addRes2(); // 32
addRes2(1); // 33

// codeblockStatement

{
  res++; // 34
}

{
  int res = 0; // check that parent scope remains untouched
}

res += arr.length; // 37

String string = "abc";

res += string.length; // 40

function(int) -> int intFunc = (int a) -> a*2;


res += intFunc(1); // 42

intFunc = (int a) -> a;

res += intFunc(2); // 44

res -= 4; // 40


function(int... args) -> float vargFunc = (int... args) -> sum(args);

res += vargFunc(1,2,3); // 46

res -= 6; // 40

println(res);`;
    require.config({ paths: { 'vs': 'https://unpkg.com/monaco-editor@latest/min/vs' }});
    window.MonacoEnvironment = { getWorkerUrl: () => proxy };

    let proxy = URL.createObjectURL(new Blob([`
        self.MonacoEnvironment = {
            baseUrl: 'https://unpkg.com/monaco-editor@latest/min/'
        };
        importScripts('https://unpkg.com/monaco-editor@latest/min/vs/base/worker/workerMain.js');
    `], { type: 'text/javascript' }));

    require(["vs/editor/editor.main"], function () {
        let editor = monaco.editor.create(document.getElementById('container'), {
            value: formula,
            language: 'java',
            theme: 'vs-dark'
        });
        editor.getModel().onDidChangeContent((e) => {
            formula = editor.getValue();
        });
    });

    async function run() {
        const result = await fetch("formula.php", {
            method: "POST",
            body: formula,
        });
        document.getElementById("pre").innerText = await result.text();
    }
</script>
</body>
</html>