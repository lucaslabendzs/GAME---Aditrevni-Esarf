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
    ["git salva seu progresso", "html nao eh linguagem", "backend cuida do servidor", "documentacao ajuda muito mesmo", "semana de provas chegou"],
    ["commit pequeno evita dor de cabeca", "node eh poderoso demais", "tem que saber procurar no google", "npm instala de tudo", "copilot escreve comigo"],
    ["revisar o codigo ajuda demais", "tem bug que some sozinho", "css pode ser traiçoeiro", "push errado atrasa o grupo", "branch mal feita vira caos"],
    ["aprender regex e sofrer", "sql parece facil no inicio", "localhost e vida", "deploy da medo", "api boa tem boa doc"],
    ["tem que dormir tambem", "logica vem com pratica", "breakpoint salva o dia", "testar eh essencial", "otimize sem pressa"],
    ["pessoal pessoal tem trabalho", "vamos terminar o projeto", "tudo na vida dele", "professor da aula", "java salva o dia"],
    ["sintaxe importa demais", "evite repetir codigo", "use nomes significativos", "funcoes bem feitas ajudam", "comentarios explicam melhor"],
    ["hoje e dia de estudar", "refatorar melhora o projeto", "versao beta da pau", "controle de versao e vital", "sem git nada e salvo"],
    ["design responsivo importa", "mobile primeiro sempre", "media query resolve tudo", "viewport bem usada e chave", "acessibilidade e respeito"],
    ["documente seu projeto", "codigo sem doc e dor", "codigo elegante impressiona", "sem teste tudo quebra", "pull request bem feito"],
    ["semantica html ajuda seo", "google gosta de estrutura", "tags certas importam", "section nao e div", "title diz muito"],
    ["api rest e padrao", "json e formato amigo", "postman ajuda muito", "get post put delete", "status 404 assusta"],
    ["seguranca e prioridade", "nao confie no client", "valide tudo no backend", "senha tem que ser hash", "cuidado com sql injection"],
    ["limpe seu codigo", "escreva como se fosse outro ler", "evite gambiarra", "separe responsabilidades", "modularize seu app"],
    ["github e portfolio vivo", "mostre seus projetos", "leia codigos alheios", "participe de comunidades", "open source ensina muito"],
    ["code review salva bugs", "escreva testes unitarios", "automatize onde puder", "ci cd acelera entrega", "lint ajuda no padrao"],
    ["procrastinar atrasa deploy", "cafe nao compila", "erro de sintaxe e comum", "use console log com moderação", "nao suba credenciais"],
    ["conheça arquitetura mvc", "roteamento e importante", "middlewares sao uteis", "framework ajuda muito", "fullstack e desafiador"],
    ["use promises direito", "async await facilita", "callback hell assusta", "entenda escopo e contexto", "hoisting pode confundir"],
    ["html css js sao trio", "jquery ficou pra tras", "vanilla js ainda vive", "dom e poderoso", "event listener organiza"],
    ["evite hardcode", "parametros dinamicos ajudam", "env guardam segredos", "use .gitignore com sabedoria", "automatize builds"],
    ["design de banco importa", "relacionamento bem feito salva", "normalize as tabelas", "use indices corretos", "evite redundancia"],
    ["conheça devtools", "inspecione elementos", "analise performance", "monitore rede", "debug passo a passo"],
    ["git merge e perigoso", "conflict assusta", "commit atomico ajuda", "branch bem nomeada organiza", "push forçado e pecado"],
    ["event bubbling confunde", "delegue eventos com cuidado", "entenda o this", "evite variaveis globais", "closures sao poderosas"],
    ["otimize imagens", "lazy load acelera site", "minifique css js", "cdn ajuda desempenho", "tamanho importa"],
    ["use fetch com sabedoria", "trate erros sempre", "api pode falhar", "esperar resposta e essencial", "use try catch"],
    ["programar e resolver problemas", "errando tambem se aprende", "todo projeto e experiencia", "nunca pare de praticar", "voce esta evoluindo"],
    ["fim do ciclo chegou", "reinicie e revise", "melhore o que fez", "descanse tambem", "orgulho de voce"]
];

    
    let diaDoMes = new Date().getDate();
    console.log(diaDoMes);

    let i = diaDoMes;

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
                let tempoUser = document.getElementById("counter").textContent;
                aparecerFrase.textContent = "Parabéns! Você completou todas as frases! Seu tempo foi: " +  tempoUser;
                document.getElementById("counter").style.display = "none";
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