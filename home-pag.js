document.addEventListener("DOMContentLoaded", function () {
    let botaoInicial = document.getElementById("botao-hom");
    if (botaoInicial) {
        botaoInicial.addEventListener("click", function () {
            localStorage.setItem("iniciarCronometro", "true");
            window.location.href = "index.php";
        });
    }
});
