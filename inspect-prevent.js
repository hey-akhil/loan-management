// Disable right-click
document.addEventListener("contextmenu", (event) => event.preventDefault());

// Disable all keyboard shortcuts for DevTools
document.addEventListener("keydown", (event) => {
    if (
        event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C") ||
        event.ctrlKey && event.key === "U" ||  // Ctrl + U (View Source)
        event.keyCode === 123  // F12
    ) {
        event.preventDefault();
    }
});

// Block Console Debugging
(function () {
    function blockDevTools() {
        setInterval(() => {
            const devToolsOpened = /./;
            devToolsOpened.toString = function () {
                throw new Error("DevTools are blocked!");
            };
            console.log("%c", devToolsOpened);
        }, 1000);
    }
    blockDevTools();
})();

// Disable console functions
setInterval(() => {
    console.log = function () { };
    console.warn = function () { };
    console.error = function () { };
    console.debug = function () { };
}, 1000);