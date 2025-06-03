"use strict";

const JSONSERVER_URL = "http://localhost:3000"
//prende URL scritto e lo inserisce nella costante
//farà quindi una richiesta alla cartella corrente
const APACHE_URL = ""
// Se la url è vuota, viene assegnata  l'origine da cui è stata scaricata la pagina

function inviaRichiesta(method, url, parameters = {}) {
	let axiosOptions = {
		"baseURL": APACHE_URL,
		"url": url,
		"method": method.toUpperCase(),
		"headers": {
			"Accept": "application/json",
		},
		"timeout": 10000,
		"responseType": "json",
	}
	if (parameters instanceof FormData) {
		axiosOptions.headers["Content-Type"] = 'multipart/form-data;'
		axiosOptions["data"] = parameters     // Accept Blob
	}
	else if (method.toUpperCase() == "GET") {
		axiosOptions.headers["Content-Type"] = 'application/x-www-form-urlencoded;charset=utf-8'
		axiosOptions["params"] = parameters   // Accept plain object or URLSearchParams
	}
	else {
		//axiosOptions.headers["Content-Type"] = 'application/json;charset=utf-8' 		
		axiosOptions.headers["Content-Type"] = 'application/x-www-form-urlencoded;charset=utf-8'
		axiosOptions["data"] = parameters
	}
	return axios(axiosOptions)
}


function errore(err) {
	console.error("Errore completo:", err);

	if (!err.response)
		alert("Connection Refused or Server timeout");
	else if (err.response.status == 403)
		window.location.href = "login.html";
	else if (err.response.status == 200)
		alert("Formato dei dati non corretto : " + err.response.data);
	else
		alert("Server Error: " + err.response.status + " - " + err.response.data)
}

