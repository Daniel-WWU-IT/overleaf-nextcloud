'use strict';

$(document).ready(() => {
    $("#app-frame").on("load", () => {
        $("#app-loading").hide();
        $("#app-frame").show();
        $('#app-frame').css('background-color', '#fff');
    });
});
