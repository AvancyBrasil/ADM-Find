document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const tableSelect = document.getElementById('tableSelect');

    // Função para filtrar a tabela
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedTableId = tableSelect.value;
        const table = document.getElementById(selectedTableId);
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        // Esconde todas as linhas inicialmente
        for (let row of rows) {
            row.style.display = 'none';
        }

        // Mostra apenas as linhas que correspondem ao valor de pesquisa
        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    row.style.display = '';
                    break; // Mostra a linha e sai do loop
                }
            }
        }
    }

    // Adiciona eventos para filtrar a tabela quando a pesquisa muda ou a tabela selecionada muda
    searchInput.addEventListener('input', filterTable);
    tableSelect.addEventListener('change', () => {
        // Limpa a caixa de pesquisa quando a tabela muda
        searchInput.value = '';
        filterTable(); // Filtra a nova tabela selecionada
    });
});
