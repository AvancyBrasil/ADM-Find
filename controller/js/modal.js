document.querySelectorAll('.nav-link').forEach(function (link) {
    link.onclick = function (event) {
        event.preventDefault();

        // Lista de IDs dos dropdowns que não devem ocultar os overlays
        const dropdownIds = ['userDropdown', 'searchDropdown', 'alertsDropdown', 'messagesDropdown'];

        // Verifica se o link clicado é um dos dropdowns
        if (dropdownIds.includes(this.id)) {
            // Se for um dropdown, apenas abre o menu sem esconder os overlays
            return; // Saia da função sem fazer mais nada
        }

        // Remover classe 'active' de todos os links
        document.querySelectorAll('.nav-link').forEach(function (link) {
            link.classList.remove('active');
        });

        // Adicionar classe 'active' ao link clicado
        this.classList.add('active');

        // Ocultar todos os overlays
        document.querySelectorAll('.overlay').forEach(function (overlay) {
            overlay.style.display = 'none';
        });

        // Exibir o overlay específico do link clicado
        var targetOverlay = this.getAttribute('data-target');
        if (targetOverlay) {
            var overlayToShow = document.getElementById(targetOverlay);
            overlayToShow.style.display = 'block'; // Exibir o overlay
        }
    };
});

// Exibir o primeiro overlay como padrão quando a página carrega
document.getElementById('overlay1').style.display = 'block';
document.querySelector('.nav-link[data-target="overlay1"]').classList.add('active');
