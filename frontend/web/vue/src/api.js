import axios from 'axios';

let params = {
    baseURL: `${process.env.VUE_APP_API_URL}`,
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
    },
};

function getCookie(name){
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    let key = decodeURI(matches[1]);
    key = key.match(/"[a-zA-Z0-9-_]{5,}"/)[0];
    key = key.replace(/"/g, '');
    return key ? key : undefined;
}

if (location.hostname === "localhost"){
    params.headers['Authorization'] = 'Bearer lCLRMuK9jOXl_ZUiHiVO0Lj1mZR9feEg';
} else {
    let getCookKey = getCookie('key');
    localStorage.localKey = getCookKey;
    params.headers['Authorization'] = `Bearer ${localStorage.getItem('localKey')}`;
}

const api = axios.create(params);

export default api;
