function postCompany()
{
    var inputs = document.getElementsByTagName('input');
    var selects = document.getElementsByTagName('select');
    var textarea = document.getElementsByTagName('textarea');
    var id = window.COMPANY_ID;
    var data = {};

    data['id'] = id;
    data[textarea[0].name.substr(5, textarea[0].name.length-6)] = textarea[0].value;
    for (var i = 0; i < inputs.length; ++i) {
        var input = inputs[i];
        key = input.name.substr(5, input.name.length-6);
        data[key] = input.value;
        if (key == 'logo_src') {
            data[key] = input.value.substr(12);
        } else if (key == 'delivery') {
            data[key] = input.checked === true ? '1' : '0';
        }
    }
    for (var i = 0; i < selects.length; ++i) {
        var select = selects[i];
        data[select.name.substr(5, select.name.length-6)] = select.value;
    }

    HttpRequest(data, "/post-company", window.REDIRECT_ID, id);
}

function postLogin()
{
    var inputs = document.getElementsByTagName('input');
    var data = {};

    for (var i = 0; i < inputs.length; ++i) {
        var input = inputs[i];
        var key = input.name.substr(5, input.name.length-6);
        data[key] = input.value;
    }

    HttpRequest(data, "/post-login", window.REDIRECT_ID, undefined);
}

function postRegister()
{
    var inputs = document.getElementsByTagName('input');
    var data = {};

    for (var i = 0; i < inputs.length; ++i) {
        var input = inputs[i];
        var key = input.name.substr(5, input.name.length-6);
        data[key] = input.value;
    }

    HttpRequest(data, "/post-register", window.REDIRECT_ID, undefined);
}

function postReview()
{
    var textarea = document.getElementsByTagName('textarea');
    var select = document.getElementsByTagName('select');
    var id = window.COMPANY_ID;
    var data = {}

    data[textarea[0].name.substr(5, textarea[0].name.length-6)] = textarea[0].value;
    data[select[0].name.substr(5, select[0].name.length-6)] = select[0].value;
    data['company_id'] = id;

    HttpRequest(data, "/post-review", window.REDIRECT_ID, id);
}

function HttpRequest(data, route, redirect, id)
{
    var reqListener = function(response) {
        if (this.readyState == 4 && this.status == 200) {
            var objJson = JSON.parse(this.response);
            if (objJson.success) {
                if (redirect == 1) {
                    if (undefined === id) {
                        id = objJson.id;
                    }
                    window.location.replace('../company/' + id);
                } else if (redirect == 2) {
                    window.location.replace('../home');
                }
            } else {
                clearErrors(objJson.form);
                var errorKeys = Object.keys(objJson.errors);
                for (var i = 0; i < errorKeys.length; ++i) {
                    var key = errorKeys[i];
                    var message = objJson.errors[key];
                    document.getElementById(key).innerHTML = '<span></span>' + message;
                }
            }
        }
    }

    var oReq = new XMLHttpRequest();
    oReq.onreadystatechange = reqListener;
    oReq.open("POST", route);
    oReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    oReq.send(JSON.stringify(data));
}

function clearErrors(form)
{
    switch(form) {
        case 'company':
            var errorId = ["name", "email", "description"];
            break;
        case 'login':
            var errorId = ["invalid"];
            break;
        case 'register':
            var errorId = ["username", "email", "password"];
            break;
        case 'review':
            var errorId = ["comment"];
            break;
        default:
            var errorId = [];
            break;
    }
    for (var i = 0; i < errorId.length; ++i) {
        document.getElementById(errorId[i]).innerHTML = '';
    }
}
