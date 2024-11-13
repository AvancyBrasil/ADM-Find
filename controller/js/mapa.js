let map;
const markers = []; // Array para armazenar os marcadores
let infoWindow = null; // Inicializar como null para controlar quando há uma janela aberta

function initMap() {
    // Define a localização inicial do mapa (centro da Cidade Tiradentes)
    const centerLocation = { lat: -23.608, lng: -46.413 }; // Coordenadas aproximadas da Cidade Tiradentes
    
    // Cria o mapa
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14, // Nível de zoom inicial
        center: centerLocation 
    });


    fetch('http://localhost:4000/lojistas/')
        .then(response => response.json())
        .then(data => {
            const locations = data.map(lojista => ({
                lat: lojista.latitude,
                lng: lojista.longitude,
                title: lojista.nomeEmpresa,
                address: lojista.logradouro
            }));

            // Adiciona os marcadores no mapa
            locations.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { lat: location.lat, lng: location.lng },
                    map: map,
                    title: location.title
                });

                // Adiciona um evento de clique no marcador
                marker.addListener('click', function() {
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
                
                dataList.innerHTML = ''; // Limpa as opções do datalist

                // Adiciona as opções que correspondem ao valor digitado
                locations.forEach(location => {
                    if (location.title.toLowerCase().includes(searchValue)) {
                        const option = document.createElement('option');
                        option.value = location.title;
                        dataList.appendChild(option);
                    }
                });

                // Se o usuário selecionar um mercadinho
                const foundLocation = locations.find(location => location.title.toLowerCase() === searchValue);
                
                if (foundLocation) {
                    const marker = markers.find(m => m.getTitle() === foundLocation.title);
                    map.setCenter({ lat: foundLocation.lat, lng: foundLocation.lng });
                    map.setZoom(18);

                    // Abrir a InfoWindow automaticamente
                    google.maps.event.trigger(marker, 'click');
                }
            });
        })
        .catch(error => console.error('Erro ao buscar os dados dos lojistas:', error));
}

// Inicializa o mapa ao carregar a página
google.maps.event.addDomListener(window, 'load', initMap);
