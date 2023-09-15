define([], function () {
    return function (config, node) {
        alert("Your Js module is working");
        console.log(config);
        console.log(node);
    };
});
