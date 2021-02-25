//Google Sheets
const SHEET_ID = "10n2MH8XvPFjtRjGiytuqwseyGDTtruHSh7ijlkceiFE";
const API_KEY = "AIzaSyD0A6FQo8KbsS42bN0sgonjoCWEEQS8XGw";
const CLIENT_ID =
  "79782684951-0448h3ht4dec4hpbv4aseb2n8lq86p08.apps.googleusercontent.com";
const SCOPE = "https://www.googleapis.com/auth/spreadsheets";
let tiporec = {
  Entregas: [
    "Rastreio não funciona",
    "Retenção fiscal",
    "Reenvio não efetuado",
    "Outros problemas com a transportadora",
  ],
  Trocas: ["Erro troque fácil", "Defeito"],
  Financeiro: [
    "Cancelamento",
    "Problemas com pagamento",
    "Problemas com estorno",
  ],
};
let lista = ["Entregas", "Trocas", "Financeiro", "Outros", "Dúvidas"];

let rad = document.cliform.tiporec;
let prev = null;
for (var i = 0; i < rad.length; i++) {
  rad[i].addEventListener("change", function () {
    prev ? prev.value : null;
    if (this !== prev) {
      prev = this;
    }
    selrec(this.value);
  });
}

function populaCombo(sel, itens) {
  return appendChildren(
    sel,
    itens.map((item) => new Option(item, item)),
  );
}
function appendChildren(el, children) {
  children.forEach((child) => el.appendChild(child));
  return el;
}
function limpaCombo(sel) {
  sel.options.length = 0;
  return sel;
}
//Select reclamação
function selrec(rec) {
  if (rec <= 2) {
    document.getElementById("selreclama").classList.remove("hid"); // mostra select reclamações
    document.getElementById("infoRec").classList.remove("hid"); // mostra select reclamações
    document.getElementById("obsRec").classList.remove("hid");
    //carrega opções de reclamação
    console.log(tiporec[lista[rec]]);
    populaCombo(
      limpaCombo(document.getElementById("Reclama")),
      tiporec[lista[rec]],
    );

    console.log("é uma reclamação de " + lista[rec]);
  } else if (rec == 3) {
    document.getElementById("selreclama").classList.add("hid");
    document.getElementById("infoRec").classList.remove("hid");
    document.getElementById("obsRec").classList.remove("hid");
    console.log("Outras reclamações");
  } else {
    document.getElementById("selreclama").classList.add("hid");
    document.getElementById("infoRec").classList.add("hid");
    document.getElementById("obsRec").classList.add("hid");
    console.log("Dúvidas");
  }
}
btn = document.getElementById("btn-ver");
btn.addEventListener("click", enviar);

handleClientLoad = () => {
  gapi.load("client:auth2", this.initClient);
};
initClient = () => {
  //provide the authentication credentials you set up in the Google developer console
  gapi.client
    .init({
      apiKey: API_KEY,
      clientId: CLIENT_ID,
      scope: SCOPE,
      discoveryDocs: [
        "https://sheets.googleapis.com/$discovery/rest?version=v4",
      ],
    })
    .then(() => {
      gapi.auth2.getAuthInstance().isSignedIn.listen(this.updateSignInStatus); //add a function called `updateSignInStatus` if you want to do something once a user is logged in with Google
      this.updateSignInStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    });
};
function enviar() {
  //
  const params = {
    // The ID of the spreadsheet to update.
    spreadsheetId: SHEET_ID,
    // The A1 notation of a range to search for a logical table of data.Values will be appended after the last row of the table.
    range: "Página1", //this is the default spreadsheet name, so unless you've changed it, or are submitting to multiple sheets, you can leave this
    // How the input data should be interpreted.
    valueInputOption: "RAW", //RAW = if no conversion or formatting of submitted data is needed. Otherwise USER_ENTERED
    // How the input data should be inserted.
    insertDataOption: "INSERT_ROWS", //Choose OVERWRITE OR INSERT_ROWS
  };

  let valueRangeBody = {
    majorDimension: "ROWS", //log each entry as a new row (vs column)
    values: ["submissionValues"], //convert the object's values to an array
  };

  let request = gapi.client.sheets.spreadsheets.values.append(
    params,
    valueRangeBody,
  );
  request.then(
    function (response) {
      // TODO: Insert desired response behaviour on submission
      console.log(response.result);
    },
    function (reason) {
      console.error("error: " + reason.result.error.message);
    },
  );
}
