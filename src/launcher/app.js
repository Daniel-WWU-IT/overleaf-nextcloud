'use strict';

$(document).ready(() => {
    const overleafURL = $("#overleaf-url").val();
    const userEmail = $("#user-email").val();
    const userPassword = $("#user-password").val();
    const importFile = $("#import-file").val();

    console.log("--- Import file: " + importFile);

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
                url: new URL("/login", overleafURL).href,
                type: "POST",
                xhrFields: { withCredentials: true },
                dataType: "json",
                data: { "_csrf": csrf, "email": userEmail, "password": userPassword },
            }).done((data) => {
                // We've been logged in, so go to either the projects page or the import the given import file
                let targetPath = data["redir"];
                if (!!importFile) {
                    targetPath = `/docs?snip_uri=${encodeURIComponent(importFile)}`;
                }
                window.location.replace(new URL(targetPath, overleafURL).href);
            });
        }
    });
});
