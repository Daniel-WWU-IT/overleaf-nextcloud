'use strict';

$(document).ready(() => {
    const overleafURL = $("#overleaf-url").val();
    const userEmail = $("#user-email").val();
    const userPassword = $("#user-password").val();

    $.ajax({
        url: overleafURL + "/login",
        type: "GET",
        xhrFields: { withCredentials: true },
    }).done((data) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, "text/html");
        const csrfElements = doc.getElementsByName("_csrf");

        if (csrfElements.length > 0) {
            const csrf = csrfElements[0].value;
            $.ajax({
                url: overleafURL + "/login",
                type: "POST",
                xhrFields: { withCredentials: true },
                dataType: "json",
                data: { "_csrf": csrf, "email": userEmail, "password": userPassword },
            }).done((data) => {
                // We've been logged in, so go to the projects page
                window.location.replace(overleafURL + data["redir"]);
            });
        }
    });
});
