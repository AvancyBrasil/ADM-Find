document.querySelectorAll('.nav-link').forEach(function (link) {
    link.onclick = function (event) {
        event.preventDefault();

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

// Lógica para manter o overlay quando o modal for aberto
function openModal(modalId, overlayId) {
    if (document.getElementById(modalId)) {
        $('#' + modalId).modal('show'); // Use jQuery para abrir o modal corretamente
        if (overlayId) {
            document.getElementById(overlayId).style.display = 'block'; // Manter o overlay visível
        }
    }
}

// Exibir o primeiro overlay como padrão quando a página carrega
document.getElementById('overlay1').style.display = 'block';
document.querySelector('.nav-link[data-target="overlay1"]').classList.add('active');

// Exemplo de uso da função openModal ao clicar em um botão que abre o modal
document.querySelectorAll('.open-modal-btn').forEach(function (btn) {
    btn.onclick = function () {
        var modalId = this.getAttribute('data-modal'); // ID do modal a ser aberto
        var overlayId = this.getAttribute('data-overlay'); // ID do overlay a ser mantido
        openModal(modalId, overlayId);
    };
});

$('#modalId').on('hidden.bs.modal', function () {
    
    docume

 
document.getElementById('overlayId').style.display = 'none'; // Esconde o overlay quando o modal é fechado
});