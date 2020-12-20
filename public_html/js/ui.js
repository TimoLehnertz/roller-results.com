const  testData = [
    {
        a: "1",
        bc: "a1",
        bd: "test5",
    },
    {
        a: "2",
        bc: "a2",
        bd: "test5",
    },
    {
        a: "3",
        bc: "a3",
        bd: "test5",
    },
    {
        a: "4",
        bd: "test500",
    },
]

$(() => {
    console.log("document loaded");
    anime({
        targets: ".anime",
        translateY: [
            {value: 200, duration: 500},
            {value: 0, duration: 800}
        ]
    })
    const table = new Table($(".table-test"), testData, "test-table");
})