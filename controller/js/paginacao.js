document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const tableSelect = document.getElementById('tableSelect');
    const tables = {
        table1: document.getElementById('table1'),
        table2: document.getElementById('table2'),
    };
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');

    let currentPage = 1;
    const rowsPerPage = 5;

    // Função para filtrar e mostrar a tabela com base na página atual
    function updateTable() {
        const selectedTableId = tableSelect.value;
        const selectedTable = tables[selectedTableId];
        const rows = selectedTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        // Oculta todas as linhas inicialmente
        for (let row of rows) {
            row.style.display = 'none';
        }

        // Cálculo do índice das linhas para mostrar
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Mostra as linhas da página atual
        for (let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = '';
        }

        // Atualiza a informação da página
        pageInfo.textContent = `Página ${currentPage}`;

        // Habilita ou desabilita os botões de navegação
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = end >= rows.length;
    }

    // Eventos para o select e para os botões de navegação
    tableSelect.addEventListener('change', () => {
        currentPage = 1; // Resetar para a primeira página
        updateTable();
    });

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });

    nextBtn.addEventListener('click', () => {
        const selectedTableId = tableSelect.value;
        const selectedTable = tables[selectedTableId];
        const rows = selectedTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const totalRows = rows.length;

        if (currentPage * rowsPerPage < totalRows) {
            currentPage++;
            updateTable();
        }
    });

    // Atualiza a tabela inicialmente
    updateTable();
});
