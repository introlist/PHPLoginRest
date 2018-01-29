var url = "";
var accSelects = 0;
var cccSelects = 0;
var dccSelects = 0;
var sccSelects = 0;
var responseContents;
var jsonResponse;
const proxyurl =  window.location.origin + "/Repos/src/Webservice.php?ws=";
const urlAreas = "http://catalogs.repositorionacionalcti.mx/webresources/areacono/";



window.onload = function () {
    getAreas();
alert(proxyurl);
};

$(document).ready(function () {
    $('select').material_select();
});


function reloadMaterialSelects() {
    $('select').material_select();
}



function getAreas() {
    console.log(proxyurl + urlAreas);
    fetch(proxyurl + urlAreas)
        .then(function (response) {
            response.text().then(function (contents) {
                fillFirstCombo(contents)
            })
                .catch(function (reason) {
                    console.log(reason + "Can’t access " + url + " response. Blocked by browser?")
                });
        })

}

function selectArea(areasConocimiento) {
    var selectedValue = areasConocimiento.value;
    const url = "http://catalogs.repositorionacionalcti.mx/webresources/campocono/byArea/" + selectedValue;
    console.log(url);
    fetch(proxyurl + url)
        .then(function (response) {
            response.text().then(function (contents) {
                fillSecondCombo(contents)
            })
                .catch(function (reason) {
                    console.log(reason + "Can’t access " + url + " response. Blocked by browser?")
                });
        });

    generateInputs(selectedValue, "acc", "areasConocimiento", urlAreas);
}


function selectCampo(camposConocimiento) {
    var selectedValue = camposConocimiento.value;
    const url = "http://catalogs.repositorionacionalcti.mx/webresources/disciplinacono/byCampo/" + selectedValue;
    console.log(url);
    fetch(proxyurl + url)
        .then(function (response) {
            response.text().then(function (contents) {
                fillThirdCombo(contents)
            })
                .catch(function (reason) {
                    console.log(reason + "Can’t access " + url + " response. Blocked by browser?")
                });
        });
    generateInputs(selectedValue, "ccc", "camposConocimiento", "http://catalogs.repositorionacionalcti.mx/webresources/campocono/");

}

function selectDisciplina(disciplina) {
    var selectedValue = disciplina.value;
    const url = "http://catalogs.repositorionacionalcti.mx/webresources/subdisciplinacono/byDisciplina/" + selectedValue;
    console.log(url);
    fetch(proxyurl + url)
        .then(function (response) {
            response.text().then(function (contents) {
                fillForthCombo(contents)
            })
                .catch(function (reason) {
                    console.log(reason + "Can’t access " + url + " response. Blocked by browser?")
                });
        });
    generateInputs(selectedValue, "dcc", "disciplinasConocimiento", "http://catalogs.repositorionacionalcti.mx/webresources/disciplinacono/");
}

function selectSubdisciplina(subdisciplina) {
    var selectedValue = subdisciplina.value;
    generateInputs(selectedValue, "scc", "subdisciplinasConocimiento", "http://catalogs.repositorionacionalcti.mx/webresources/subdisciplinacono/");

}

function generateInputs(selectedValue, dropdown, titulo, jsonURL) {
    var id = dropdown + (getSelectionNumber(dropdown));
    var parent = document.getElementById(dropdown);
    var select_val = document.getElementById(titulo);
    var nombre = "<input id='nombre" + id + "' type='text' class='col s10 gen-input-small-text' value='" + select_val.options[select_val.selectedIndex].text + "' readonly>";
    var copyNombre = ("<input  class=' gen-input waves-effect waves-light btn'  id=\"copyNombre" + id + "\" type=\"button\" value=\"Copiar\" onclick=\"copyURL('nombre" + id + "')\">\n");

    var dspace = "<input id='dspace" + id + "' type='text' class='col s10  gen-input-small-text'  value='<dc:subject>" + jsonURL + selectedValue + "</dc:subject>' readonly>";
    var copyDspace = ("<input  class='gen-input waves-effect waves-light btn'  id=\"copyDspace" + id + "\" type=\"button\" value=\"Copiar\" onclick=\"copyURL('dspace" + id + "')\">\n");
    parent.insertAdjacentHTML('beforeend', nombre);
    parent.insertAdjacentHTML('beforeend', copyNombre);
    parent.append("    ");
    parent.insertAdjacentHTML('beforeend', dspace);
    parent.insertAdjacentHTML('beforeend', copyDspace);
    parent.append("    ");

    parent.insertAdjacentHTML('beforeend', "<br><br>");

}

function getSelectionNumber(dropdown) {
    if (dropdown === "acc") {
        accSelects++;
        return accSelects;
    }
    else if (dropdown === "ccc") {
        cccSelects++;
        return cccSelects;
    }
    else if (dropdown === "dcc") {
        dccSelects++;
        return dccSelects;
    }
    else {
        sccSelects++;
        return sccSelects;
    }
}

function fillFirstCombo(contents) {
    responseContents = contents;
    jsonResponse = JSON.parse("\{\"campos\":" + responseContents + "\}");
    console.log(contents);
    var listItems = '<option selected="selected" value="0">- Áreas de conocimiento -</option>';

    for (var i = 0; i < jsonResponse.campos.length; i++) {
        listItems += "<option value='" + jsonResponse.campos[i].idArea + "'>" + jsonResponse.campos[i].descripcion + "</option>";
    }

    $("#areasConocimiento").html(listItems);
    reloadMaterialSelects();
}

function fillSecondCombo(contents) {
    responseContents = contents;
    jsonResponse = JSON.parse("\{\"campos\":" + responseContents + "\}");
    console.log(contents);
    var listItems = '<option selected="selected" value="0">- Campos de conocimiento -</option>';

    for (var i = 0; i < jsonResponse.campos.length; i++) {
        listItems += "<option value='" + jsonResponse.campos[i].idCampo + "'>" + jsonResponse.campos[i].descripcion + "</option>";
    }

    $("#camposConocimiento").html(listItems);
    reloadMaterialSelects();

}

function fillThirdCombo(contents) {
    responseContents = contents;
    jsonResponse = JSON.parse("\{\"campos\":" + responseContents + "\}");
    console.log(contents);

    var listItems = '<option selected="selected" value="0">- Disciplinas de conocimiento -</option>';

    for (var i = 0; i < jsonResponse.campos.length; i++) {
        listItems += "<option value='" + jsonResponse.campos[i].idDisciplina + "'>" + jsonResponse.campos[i].descripcion + "</option>";
    }

    $("#disciplinasConocimiento").html(listItems);
    reloadMaterialSelects();

}


function fillForthCombo(contents) {
    responseContents = contents;
    jsonResponse = JSON.parse("\{\"campos\":" + responseContents + "\}");
    console.log('Subdisciplinas\n' + contents);
    var listItems = '<option selected="selected" value="0">- Subdisciplinas de conocimiento -</option>';

    for (var i = 0; i < jsonResponse.campos.length; i++) {
        listItems += "<option value='" + jsonResponse.campos[i].idSubdisciplina + "'>" + jsonResponse.campos[i].descripcion + "</option>";
    }

    $("#subdisciplinasConocimiento").html(listItems);
    reloadMaterialSelects();

}


function copyURL(elementID) {
    document.getElementById(elementID).select();
    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy');
    }
    Materialize.toast('Texto copiado al portapapeles.', 3000) // 3000 is the duration of the toast
}
