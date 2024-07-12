const ID_TOKEN_KEY = "id_token_merchant";
const user_info = "user_info";
const permissions = "permissions";
const dispatch_report = "dispatch_report";
/**
 * @description get token form localStorage
 */
const getToken = () => {
    return window.localStorage.getItem(ID_TOKEN_KEY);
};

/**
 * @description save token into localStorage
 * @param token: string
 */
const saveToken = (token) => {
    window.localStorage.setItem(ID_TOKEN_KEY, token);
};

const saveUser = (data) => {
    window.localStorage.setItem(user_info, data);
};

const getUser = (data) => {
    return window.localStorage.getItem(user_info);
};
const savePermissions = (data) => {
    window.localStorage.setItem(permissions, data);
};

const getPermissions = (data) => {
    return window.localStorage.getItem(permissions);
};

/**
 * @description remove token form localStorage
 */
const destroyToken = () => {
    window.localStorage.removeItem(ID_TOKEN_KEY);
};

const sendRequestWithToken = (url, method = "GET", data = null) => {
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        };
        $.ajax({
            url: url,
            method: method,
            data:data,
            headers: headers,
            dataType: 'json',
              beforeSend: function(){

              },
              success: function(data) {
                return data;
              },
             error: function(xhr, textStatus, errorThrown) {
                return errorThrown;
            }
    });

};

const saveDispatch = (newCN) => {
    const storedData = getDispatch();
    var cnArray = [];
    if (storedData) {
        cnArray = JSON.parse(storedData);
    }
    if (cnArray.includes(newCN)) {
        scan_sound(2);
        $.toaster(newCN+' Already added to list', 'Error', 'danger');
        return false;
    }else {
        cnArray.push(newCN);
        window.localStorage.setItem(dispatch_report, JSON.stringify(cnArray));
        return true;
    }
};

const removeDispatch = (newCN) => {
    const storedData = getDispatch();
    var cnArray = [];
    if (storedData) {
        cnArray = JSON.parse(storedData);
    }
    if (cnArray.includes(newCN)) {
        scan_sound(1);
        var i = cnArray.indexOf(newCN);
        if (i !== -1) {
            cnArray.splice(i, 1);
        }
        window.localStorage.setItem(dispatch_report, JSON.stringify(cnArray));
        return true;
    }
};

const getDispatch = () => {
    return window.localStorage.getItem(dispatch_report);
};

const clearDispatch = () => {
    $.toaster('Cleared', 'List', 'warning');
    $('#table_dispatch tbody').html('');
    return window.localStorage.removeItem(dispatch_report);

};

function scan_sound(type) {
    if(type === 1){
        var sound = document.getElementById("audio_success");
        sound.play();
    }else{
        var sound = document.getElementById("audio_error");
        sound.play();
    }
}

