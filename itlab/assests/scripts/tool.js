(function () {

window.to = function (page_name) {
    window.location.replace(MYAPP.SETTING.BASE_HOST + page_name.indexOf('.') ? page_name : page_name + '.php');
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

window.creatEquipmentNode = function (e_obj) {
    if(!MYAPP.addEquipment(e_obj)) {
        alert('The data already exists');
        return false;
    }
    var div = document.createElement("div");
    div.id = e_obj.id;
    div.className = 'equipment_node';
    var p = document.createElement("p");
    p.innerText = "ID : " + e_obj.id + "\t器材 : " + e_obj.name + "\t狀態 : " + (e_obj.status==='available' ? '可出借' : '可歸還') + "\t備註 : " + (e_obj.note||'無') ;
    var i = document.createElement("i");
    i.className = ' fa fa-trash-o fa-lg';
    i.addEventListener('click', function() {
        document.getElementById(div.id).remove();
        MYAPP.removeEquipment(div.id);
    }, false);
    div.appendChild(p);
    div.appendChild(i);
    return div;
};


})()