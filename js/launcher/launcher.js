'use strict';

$(document).ready(() => {
    const storageKey = "overleaf-v3-notice-hidden";
    const sessionKey = "overleaf-v3-notice-shown";

    $("#app-frame").on("load", () => {
        $("#app-loading").hide();
        $("#app-frame").show();
        $('#app-frame').css('background-color', '#fff');

        if (localStorage.getItem(storageKey) !== "true" && sessionStorage.getItem(sessionKey) !== "true") {
            $("#overlay").css('display', 'flex');
            sessionStorage.setItem(sessionKey, "true");
        }
    });

    $("#closePopup").click(() => {
        if ($("#dontShowAgain").is(":checked")) {
            localStorage.setItem(storageKey, "true");
        }

        $("#overlay").hide();
    });
});
