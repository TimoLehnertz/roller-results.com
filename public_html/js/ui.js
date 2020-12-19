const  testData = [
    {
        a: "test1",
        bc: "test2",
        bd: "test5",
    },
    {
        a: "test1",
        bc: "test2",
        bd: "test5",
    },
    {
        a: "test2e1",
        bc: "tewse2t2",
        bd: "test5",
    },
    {
        a: "test1e2",
        bd: "test500",
    },
]

$(() => {
    console.log("document loaded");
    const table = new Table($(".table-test"), testData, "test-table");
})