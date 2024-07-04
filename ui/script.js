//const previewUrl = '';
const previewUrl = '?pluginSetPreview=JDJ5JDEwJGJWa0hrQnIuNk9SMXFIWG00SlY3ZXVMZzI4R0tLVDQ3YXdkdHkxY0U1U09hRU45MkZoWkVt';
const plentyRouteSecure = '/rest/cytDiscountTable';
const plentyRoute = '/cytDiscountTable';

var csv_data = [];
// alles mit Paramter ohne previewUrl!
const discountRouteShow = plentyRoute + '/all';

const accessToken = localStorage.getItem("accessToken") || "";

let filter = { "itemId": "alle" };

const request = async (route, method) => {
    let res = false;
    await fetch(`${route}`, {
        method: method,
        headers: {
            Authorization: 'Bearer ' + accessToken,
            'Content-Type': 'application/json'
        },
        cache: "no-store",
    })
        .then(manageErrors)
        .then(response => {
            return response.json();
        }).then(data => {
            res = data;
        })
        .catch(error => {
            console.log('Error Code   : ' + error.status);
            console.log('Error Reason : ' + error.statusText);
        });
    return res;
}

function initButtons() {
    console.log("initButtons");
    // document.querySelector('button.btn-add-csv');
    const btnAdd = document.querySelector('#fileUpload');
    //.addEventListener('change', upload, false);
    btnAdd.addEventListener('change', (evt) => {
        console.log("clicked");
        uploadCSV(evt);
    });

    const saveToDB = document.querySelector('.btn-add-db');
    saveToDB.addEventListener('click', (evt) => {
        console.log("db save clicked");
        uploadToDB(csv_data);
    });
}

// Method that checks that the browser supports the HTML5 File API
function browserSupportFileUpload() {
    var isCompatible = false;
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        isCompatible = true;
    }
    return isCompatible;
}

const clearClassField = (data) => {
    let res = [];   
    console.log("clearClassField");
    data.forEach(row => {
        console.log("row ",row[0]);
        row[0].replace("\'-","").replace("Klasse","");
        res.push(row);
    })
    return res;
}

function uploadCSV(evt) {

    if (!browserSupportFileUpload()) {
        alert('The File APIs are not fully supported in this browser!');
    } else {
        data = null;
        var file = evt.target.files[0];
        if (file.type === "text/csv") {
            var reader = new FileReader();
            reader.readAsText(file);
            reader.name = file.name;
            //document.getElementById('title').innerHTML = file.name;
            reader.onload = function (event) {
                console.log("file: " + event.target.name);

                csv_data = parseCSV(event.target.result, ";");
                
                const right = document.querySelector('.right-col .table-container');
                right.innerHTML = "";
                csv_data.shift();
                console.log(csv_data);
                right.appendChild(dataToTable(csv_data, labels, { class: 'json-table' }));
                //const headers = csv_data[0];
                // funczt noch nicht!
                //const cData = clearClassField(csv_data); 
                
            };
            reader.onerror = function () {
                alert('Unable to read ' + file.fileName);
            };
        } else {
            alert("Not a csv File: " + file.type);
        }
    }
}

const uploadToDB = async (data2send) => {
    let res = null;
    var senddata = { "data": data2send };
    let url = `${plentyRoute}`;
    
    await fetch(`${url}/${previewUrl}`, {
        method: 'POST',
        headers: {
            Authorization: 'Bearer ' + accessToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(senddata)
        })
        .then(manageErrors)
        .then(response => {
            return response.json();
        }).then(data => {
            res = data;
        })
        .catch(error => {
            console.log('Error Code   : ' + error.status);
            console.log('Error Reason : ' + error.statusText);
        });
    return res;
}


function getTableHeader() {
    let a = Array.from(document.querySelectorAll('table thead tr th')).map(th => th.dataset.name);
    var json_arr = {};
    a.forEach(element => {
        json_arr[element] = "";
    })
    return json_arr;
}

function manageErrors(response) {
    if (!response.ok) {
        const responseError = {
            statusText: response.statusText,
            status: response.status
        };
        throw (responseError);
    }
    return response;
}

function createRow(row) {
    let tr = document.createElement('tr');
    console.log("to ",typeof(row));
    for (let i=0;i<row.length;i++) {
        const col = row[i];
        console.log("col ",col);
        let td = document.createElement('td');

        td.textContent = col;
        //td.classList.add(key);
        if (col == 'id') {
            tr.dataset.id = col;
        } 
        tr.appendChild(td);
    };
    return tr;
}

function dataToTable(data, labels, opts = {}) {
    let table = document.createElement('table');
    let thead = document.createElement('thead');
    let tbody = document.createElement('tbody');
    let thead_tr = document.createElement('tr');

    if (opts.class) table.classList.add(opts.class);
    Object.entries(labels).forEach(([key, value]) => {
        let th = document.createElement('th');
        th.innerHTML = value.de;
        th.dataset.name = key;

        thead_tr.appendChild(th);
    });

    for (let i=0;i<data.length;i++) {
        //console.log(i+".row ",data[i]);
        let tr = createRow(data[i]);
        tbody.append(tr);
    };
    thead.appendChild(thead_tr);
    table.appendChild(thead);
    table.appendChild(tbody);
    return table;
}

function showLoader(show = false, desc = "") {
    if (show) {
        const elem = document.querySelector('#loader') !== null;
        if (elem) {
            const info = document.querySelector('#loader .info');
            info.innerHTML = desc;
        } else {
            // container zum Positionieren und Eingaben blocken
            const div = document.createElement('div');
            div.id = "loader";
            const loader = document.createElement('div');
            loader.classList.add("loader");
            div.appendChild(loader);
            const info = document.createElement('p');
            info.classList.add("info");
            info.innerHTML = desc;
            div.appendChild(info);

            const container = document.querySelector('.container');
            container.appendChild(div);
        }
    } else {
        document.querySelector('#loader').remove();
    }
}

const main = async () => {
    showLoader(true, "lade labels");
    const labelsJson = await request('./labels.json', 'GET');
    labels = labelsJson.labels;
    showLoader();
    const right = document.querySelector('.right-col .table-container');
    right.innerHTML = "";
    /*
    geht so nicht, da aktuell auf CSV umgebaut aber json zurückkommt!!!
    showLoader(true, "lade bestehende Tabelle");
    const discounts = await request(plentyRoute+'/'+previewUrl, 'GET');
    showLoader();

    right.appendChild(dataToTable(discounts, labels, { class: 'json-table' }));
    */
    initButtons();
}

const parseCSV = (str, delimiter) => {
    var arr = []; var quote = !1; for (var row = (col = c = 0); c < str.length; c++) {
        var cc = str[c], nc = str[c + 1]; arr[row] = arr[row] || []; arr[row][col] = arr[row][col] || ""; if (cc == '"' && quote && nc == '"') { arr[row][col] += cc; ++c; continue }
        if (cc == '"') { quote = !quote; continue }
        if (cc == delimiter && !quote) { ++col; continue }
        if (cc == "\n" && !quote) { ++row; col = 0; continue }
        arr[row][col] += cc
    }
    return arr
}

main();