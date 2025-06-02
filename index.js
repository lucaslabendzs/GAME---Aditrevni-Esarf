function inverterPalavra(palavra){
    return palavra.split('').reverse().join('');
}

let array =  ["aula de web um", "teste do trabalho", "renan cucas e kauan"];
let caixa = document.getElementById("caixa-texto"); 
let botao = document.getElementById("botao");
let localResposta = document.getElementById("local-resposta"); 
let i = 0;
let palavraVez = array[i];
let invertePalavra = inverterPalavra(palavraVez);

//aparecer palavra do dia pro usuario 
let frase = document.getElementById("frase"); 
let palavraDia = document.createElement("p");
palavraDia.textContent = "A frase do dia é: " + palavraVez;

frase.appendChild(palavraDia);

console.log(invertePalavra);
//apos botao
botao.addEventListener("click", function () {
    let texto = caixa.value;
    localResposta.innerHTML = "";
    let resposta = document.createElement("p");
    if(texto == invertePalavra){
       resposta.textContent = "Acertou!!!"
       resposta.style.color = "green";

       caixa.disabled = true;
       botao.disabled = true;
    }else{
       resposta.textContent = "Errou!!!" 
       resposta.style.color = "red";
    }
    localResposta.appendChild(resposta);
    caixa.value = ""; 
});
//apos enter
caixa.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        botao.click(); 
    }
});