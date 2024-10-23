let map;
const markers = []; // Array para armazenar os marcadores
let infoWindow = null; // Inicializar como null para controlar quando há uma janela aberta

function initMap() {
    // Define a localização inicial do mapa (centro da Cidade Tiradentes)
    const centerLocation = { lat: -23.608, lng: -46.413 }; // Coordenadas aproximadas da Cidade Tiradentes
    
    // Cria o mapa
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14, // Nível de zoom inicial
        center: centerLocation // Centraliza o mapa na Cidade Tiradentes
    });

    // Array com mercadinhos fictícios e seus endereços
    const locations = [
        { lat: -23.6105, lng: -46.4109, title: "Mercadinho do Zé", address: "Rua do Zé, 123, Cidade Tiradentes" },
        { lat: -23.6117, lng: -46.4155, title: "Mercado Popular", address: "Avenida Central, 456, Cidade Tiradentes" },
        { lat: -23.6048, lng: -46.4084, title: "Mercadinho da Vizinhança", address: "Rua da Vizinhança, 789, Cidade Tiradentes" },
        { lat: -23.6071, lng: -46.4172, title: "Mini Mercado do Bairro", address: "Praça do Bairro, 101, Cidade Tiradentes" },
        { lat: -23.6099, lng: -46.4203, title: "Supermercado Central", address: "Rua Principal, 202, Cidade Tiradentes" }
    ];

    // Loop para adicionar os mercadinhos no mapa
    locations.forEach(function(location) {
        const marker = new google.maps.Marker({
            position: { lat: location.lat, lng: location.lng },
            map: map,
            title: location.title
        });

        // Adiciona um evento de clique no marcador
        marker.addListener('click', function() {
            // Se já existir uma janela aberta, fecha antes de abrir outra
            if (infoWindow) {
                infoWindow.close();
            }

            // Cria uma nova InfoWindow
            infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <h4>${location.title}</h4>
                        <p>${location.address}</p>
                        <a href="https://www.google.com/maps?q=${location.lat},${location.lng}" target="_blank">Ver na Street View</a>
                    </div>
                `
            });
            
            infoWindow.open(map, marker); // Abre a InfoWindow no marcador atual
        });

        markers.push(marker); // Armazena o marcador no array
    });

    // Função para atualizar o datalist com base na pesquisa parcial
    const searchBox = document.getElementById('searchBox');
    searchBox.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const dataList = document.getElementById('mercadinhoList');
        
        // Limpa as opções do datalist a cada nova pesquisa
        dataList.innerHTML = '';

        // Adiciona as opções que correspondem parcialmente ao valor digitado
        locations.forEach(function(location) {
            if (location.title.toLowerCase().includes(searchValue)) {
                const option = document.createElement('option');
                option.value = location.title;
                dataList.appendChild(option);
            }
        });

        // Se o usuário selecionar um mercadinho
        const foundLocation = locations.find(location => location.title.toLowerCase() === searchValue);
        
        if (foundLocation) {
            // Centraliza o mapa no mercadinho encontrado e abre a janela de informações
            const marker = markers.find(m => m.getTitle() === foundLocation.title);
            map.setCenter({ lat: foundLocation.lat, lng: foundLocation.lng });
            map.setZoom(18);

            // Abrir a InfoWindow automaticamente
            google.maps.event.trigger(marker, 'click');
        }
    });
}

// Inicializa o mapa ao carregar a página
google.maps.event.addDomListener(window, 'load', initMap);
