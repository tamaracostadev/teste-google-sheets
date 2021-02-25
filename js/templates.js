//Conf google sheets
const SHEET_ID = "10n2MH8XvPFjtRjGiytuqwseyGDTtruHSh7ijlkceiFE";
const API_KEY = "AIzaSyD0A6FQo8KbsS42bN0sgonjoCWEEQS8XGw";
const O_AUTH_ID =
  "79782684951-0448h3ht4dec4hpbv4aseb2n8lq86p08.apps.googleusercontent.com";
const O_AUTH_KEY = "m-0eUpXwLfYRSMwWIDNNiMyE";
//On focus out - Chamar função tipos de reclamação
//tipos de reclamação
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

//Lista
let lista = ["Entregas", "Trocas", "Financeiro", "Outros", "Dúvidas"];

//titulos templates
let titulos = {
  Entregas: ["oi", "oie"],
  Trocas: [],
  Financeiro: [],
  Outros: [],
  Dúvidas: [],
};
//Templates
let templates = {
  entregas: [],
  trocas: [],
  financeiro: [],
  outros: [],
  duvidas: [],
};

//eventos
let rad = document.cliform.tiporec;
let prev = null;
for (var i = 0; i < rad.length; i++) {
  rad[i].addEventListener("change", function () {
    prev ? prev.value : null;
    if (this !== prev) {
      prev = this;
    }
    selRec(this.value);
  });
}

//Select Reclamação (divselrec)
function selRec(listaRec) {
  let inpLabel = document.getElementById("recLabel");
  let divSel = document.getElementById("divSelrec");
  let inpSel = document.getElementById("selRec");
}

function selRec2(listaRec) {
  let inpLabel = document.getElementById("recLabel");
  let divSel = document.getElementById("divSelrec");
  let inpSel = document.getElementById("selRec");
  //verifica Label
  if (document.getElementById("recLabel") == null) {
    let inpLabel = document.createElement("label");
    inpLabel.innerHTML = "<b>" + lista[listaRec] + "</b>";
    inpLabel.setAttribute("id", "recLabel");
    inpLabel.setAttribute("class", "w3-text-blue-gray ");
    divSel.appendChild(inpLabel);
  }

  inpLabel.innerHTML = "<b>" + lista[listaRec] + "</b>";
  if (inpSel !== null) {
    if (listaRec < 3) {
      //Monta lista reclamação
      inpLabel.innerHTML = "<b>Reclamação " + lista[listaRec] + "</b>";
      inpSel.options.length = 0;
      i = 0;
      tiporec[lista[listaRec]].forEach((titulo) => {
        let opt = document.createElement("option");
        let txt = document.createTextNode(titulo);
        opt.appendChild(txt);
        opt.value = i;
        inpSel.appendChild(opt);
        i++;
      });
    } else {
      console.log("outros " + lista[listaRec]);
    }
  } else {
    //Select
    if (listaRec < 3) {
      inpLabel.innerHTML = "<b>Reclamação " + lista[listaRec] + "</b>";
      let inpSel = document.createElement("select");
      inpSel.setAttribute("id", "selRec");
      inpSel.setAttribute("class", "w3-select w3-border");
      inpSel.setAttribute("name", "selRec");
      divSel.appendChild(inpSel);
      i = 0;

      tiporec[lista[listaRec]].forEach((titulo) => {
        let opt = document.createElement("option");
        let txt = document.createTextNode(titulo);
        opt.appendChild(txt);
        opt.value = i;
        inpSel.appendChild(opt);
        i++;
      });
      console.log("Select " + tiporec[lista[listaRec]]);
    } else {
      console.log(titulos[lista[listaRec]]);
    }
  }
}
// Inserção dados do cliente (id=> dadoscli) Ticket, pedido, cpf
function dadosCliente() {}
// Descrição da reclamação (descricao)
function descRec() {}
//Select template (seltemplate)
function selTemplate() {}
