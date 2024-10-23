document.addEventListener("DOMContentLoaded", function() {
    // Renomeando funções e variáveis para tabela 3
    let selectedRowTable3 = null; // Variável para armazenar a linha selecionada da Tabela 3

    // Função para selecionar uma linha da tabela 3
    function selectRowTable3(row) {
        // Remove a seleção anterior
        if (selectedRowTable3) {
            selectedRowTable3.classList.remove("selected");
        }
        selectedRowTable3 = row; 
        row.classList.add("selected"); // Adiciona a classe de seleção
    }

    // Função para aprovar ou reprovar a linha selecionada da Tabela 3
    function handleApprovalTable3(action) {
        if (selectedRowTable3) {
            const id = selectedRowTable3.cells[0].textContent;
            const name = selectedRowTable3.cells[1].textContent;
            const surname = selectedRowTable3.cells[2].textContent;

            showAlertTable3(`${action === 'approve' ? 'Aprovado' : 'Reprovado'}: ${name} ${surname} (ID: ${id}) na Tabela 3`, action === 'approve');

            // Remove a linha selecionada
            selectedRowTable3.remove();
            selectedRowTable3 = null;
        } else {
            showAlertTable3("Por favor, selecione uma linha antes de aprovar ou reprovar.");
        }
    }

    // Função para exibir um alerta estilizado
    function showAlertTable3(message, isApproved) {
        const alertBox = document.createElement("div");
        alertBox.className = "alert-box"; // Classe CSS para estilizar o alerta
        alertBox.textContent = message;
        alertBox.style.backgroundColor = isApproved ? "#4caf50" : "#f44336"; // Verde para aprovado, vermelho para reprovado
        document.body.appendChild(alertBox); // Adiciona o alerta ao body

        // Remove o alerta após 3 segundos
        setTimeout(() => {
            alertBox.remove();
        }, 3000);
    }

    // Seleciona eventos de clique nas linhas da tabela 3
    document.querySelectorAll("#customTable3 tbody tr").forEach(row => {
        row.addEventListener("click", () => selectRowTable3(row));
    });

    // Adiciona eventos para os botões de aprovação e reprovação
    document.getElementById("btnApprove").addEventListener("click", () => handleApprovalTable3('approve'));
    document.getElementById("btnReject").addEventListener("click", () => handleApprovalTable3('reject'));
});
