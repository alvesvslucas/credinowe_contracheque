// Exemplo de alerta ao clicar em um botão
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".btn-danger");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      alert("Você clicou em um botão de exclusão.");
    });
  });
});
