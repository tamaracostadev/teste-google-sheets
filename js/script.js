let tiporec = {
  Entregas: [
    "Rastreio não funciona",
    "Retenção fiscal",
    "Pedido incompleto",
    "Pedido extraviado",
    "Pedido entregue, mas cliente não recebeu",
    "Correção/Confirmação de endereço",
    "Outros problemas com a transportadora",
  ],
  Trocas: ["Erro troque fácil", "Número do pedido", "Defeito", "Envio NF"],
  Financeiro: [
    "Cancelamento antes do envio",
    "Cancelamento (Pedido devolvido)",
    "Problemas com pagamento",
    "Problemas com estorno",
  ],
};
let lista = ["Entregas", "Trocas", "Financeiro", "Outras", "Mkt"];

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
  let area = document.querySelector("#area");
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
    area.value = lista[rec];
  } else if (rec == 3) {
    document.getElementById("selreclama").classList.add("hid");
    document.getElementById("infoRec").classList.remove("hid");
    document.getElementById("obsRec").classList.remove("hid");
    console.log("Outras reclamações");
    area.value = lista[rec];
  } else {
    document.getElementById("selreclama").classList.add("hid");
    document.getElementById("infoRec").classList.add("hid");
    document.getElementById("obsRec").classList.remove("hid");
    console.log("Remove mkt");
    area.value = lista[rec];
  }
}
