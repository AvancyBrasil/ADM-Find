document.addEventListener("DOMContentLoaded", function() {
    let selectedCard = null; // Variável global para armazenar a div selecionada

    // Seleciona todas as divs com a classe 'card' que possuem o atributo data-id
    const cards = document.querySelectorAll('.card[data-id]');

    // Adiciona o evento de clique a cada card
    cards.forEach(card => {
        card.addEventListener('click', function() {
            selectedCard = card; // Armazena o card selecionado
            $('#chamadoModal').modal('show'); // Exibe o modal
        });
    });

    // Função para encerrar chamado e remover o card selecionado
    document.getElementById('encerrarChamado').addEventListener('click', function() {
        if (selectedCard) {
            selectedCard.remove(); // Remove o card selecionado
            $('#chamadoModal').modal('hide'); // Fecha o modal
        }
    });

    // Função para responder chamado e abrir o modal de chat
    document.getElementById('responderChamado').addEventListener('click', function() {
        $('#chamadoModal').modal('hide'); // Fecha o modal de chamado
        $('#responderModal').modal('show'); // Exibe o modal de resposta
    });

    // Removido: Código do chat que não será utilizado
});
