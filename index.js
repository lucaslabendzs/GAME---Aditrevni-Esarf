function inverterFrase(palavra) {
    return palavra.split('').reverse().join('');
}

let hh = 0, mm = 0, ss = 0, ms = 0;
let tempo = 10;
let crono;

function start() {
    crono = setInterval(relogio, tempo);
}

function stop() {
    clearInterval(crono);
}

function relogio() {
    ms++;
    if (ms === 100) {
        ms = 0;
        ss++;
        if (ss === 60) {
            ss = 0;
            mm++;
            if (mm === 60) {
                mm = 0;
                hh++;
            }
        }
    }

    let formato = 
        (hh < 10 ? '0' + hh : hh) + ":" +
        (mm < 10 ? '0' + mm : mm) + ":" +
        (ss < 10 ? '0' + ss : ss) + ":" +
        (ms < 10 ? '0' + ms : ms);

    document.getElementById("counter").innerHTML = formato;
}

window.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("iniciarCronometro") === "true") {
        start();
        localStorage.removeItem("iniciarCronometro");
    }

    let array = [
        ["aula de web um", "teste do trabalho", "renan cucas e kauan", "javascript eh muito legal", "codigo limpo vale ouro"],
        ["vamos aprender a programar", "interface bonita agrada todos", "desenvolvimento web com criatividade", "debugar ajuda a entender", "projetos simples exigem atenção"],
        ["pratique logica todos os dias", "toda variavel tem um nome", "console log salva vidas", "internet caiu de novo", "frontend as vezes engana"],
        ["git salva seu progresso", "html nao eh linguagem", "backend cuida do servidor", "documentacao ajuda muito mesmo", "semana de provas chegou"]
    ];

    let i = 0;
    let j = 0;
    let fraseAtual = array[i][j];
    let frase = document.getElementById("frase");
    let aparecerFrase = document.createElement("p");
    aparecerFrase.textContent = "A frase é: " + fraseAtual;
    frase.appendChild(aparecerFrase);

    let inverteFrase = inverterFrase(fraseAtual);
    console.log(inverteFrase);
    let caixa = document.getElementById("caixa-texto");
    let botao = document.getElementById("botao");
    let localResposta = document.getElementById("local-resposta");

    botao.addEventListener("click", function () {
        let texto = caixa.value;
        localResposta.innerHTML = "";
        let resposta = document.createElement("p");

        if (texto === inverteFrase) {
            resposta.textContent = "Acertou!!! " + (j + 1) + "/5";
            resposta.style.color = "green";
            j++;
            

            if (j < 5) {
                fraseAtual = array[i][j];
                aparecerFrase.textContent = "A frase é: " + fraseAtual;
                inverteFrase = inverterFrase(fraseAtual);
                console.log(inverteFrase);
            } else {
                stop();
                aparecerFrase.textContent = "Parabéns! Você completou todas as frases!";
                botao.disabled = true;
                caixa.disabled = true;
                
            }
        } else {
            resposta.textContent = "Errou!!! " + j + "/5";
            resposta.style.color = "red";
        }

        localResposta.appendChild(resposta);
        caixa.value = "";
    });

    caixa.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            botao.click();
        }
    });
});
//evitar erros de nao atualizar a pagina
window.addEventListener('pageshow', function (event) {
    const navEntries = performance.getEntriesByType("navigation");
    const isBack = navEntries.length > 0 && navEntries[0].type === "back_forward";

    if (event.persisted || isBack) {
        location.reload();
    }
});