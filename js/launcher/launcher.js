'use strict';

$(document).ready(() => {
    const sessionKey = "overleaf-v3-notice-shown";

    $("#app-frame").on("load", () => {
        $("#app-loading").hide();
        $("#app-frame").show();
        $('#app-frame').css('background-color', '#fff');

        if (sessionStorage.getItem(sessionKey) !== "true") {
            $("#overlay").css('display', 'flex');
            sessionStorage.setItem(sessionKey, "true");
        }
    });

    $("#closePopup").click(() => {
        $("#overlay").hide();
    });
});
