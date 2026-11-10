document.addEventListener('click', function (event) {

    if (event.target.matches('dialog.dialog')) {
        event.preventDefault();
        event.stopImmediatePropagation();
    }

}, true);