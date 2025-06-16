// Aguarda o carregamento completo do DOM
document.addEventListener("DOMContentLoaded", function () {
    // Pega o botão de início do jogo pelo ID
    let botaoInicial = document.getElementById("botao-hom");
    if (botaoInicial) {
        // Adiciona um evento de clique ao botão
        botaoInicial.addEventListener("click", function () {
            // Salva no localStorage que o cronômetro deve iniciar
            localStorage.setItem("iniciarCronometro", "true");
            // Redireciona para a página do jogo
            window.location.href = "index1.php";
        });
    }
});
//para confirgurar o menu lateral da pagina home
let menu = document.getElementById("menu-btn");
let sidebar = document.getElementById("sidebar");
let fecharSidebar = document.getElementById("close-sidebar");
menu.onclick = function() {
    sidebar.style.width = "260px";
};
fecharSidebar.onclick = function() {
    sidebar.style.width = "0";
};