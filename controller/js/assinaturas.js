function toggleTables() {
    const selectedValue = document.getElementById('tabelaSelect').value;
    const tableSemAssinatura = document.getElementById('tableSemAssinatura');
    const tableComAssinatura = document.getElementById('tableComAssinatura');

    if (selectedValue === 'sem-assinatura') {
        tableSemAssinatura.style.display = 'table';
        tableComAssinatura.style.display = 'none';
    } else if (selectedValue === 'com-assinatura') {
        tableSemAssinatura.style.display = 'none';
        tableComAssinatura.style.display = 'table';
    }
}

// Chama a função para garantir que a tabela certa seja exibida inicialmente
toggleTables();
