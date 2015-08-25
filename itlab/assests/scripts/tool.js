(function () {

window.to = function (page_name) {
    window.location.replace(window.HTML_HOST + page_name + '.php');
};

window.setCookie = function (cname, cvalue, exdays) {
    var d = new Date();
    exdays = exdays || 7;
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ';path=/';
};

window.getCookie = function (cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
};

window.deleteCookie = function (cname) {
    document.cookie = cname + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
};

})()