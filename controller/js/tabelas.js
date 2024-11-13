(async function() {
    let linhaSelecionada = null;

    function exibirAlerta(mensagem, tipoAcao) {
        const caixaAlerta = document.createElement("div");
        caixaAlerta.className = "alert-box";
        caixaAlerta.textContent = mensagem;

        if (tipoAcao === 'ban') {
            caixaAlerta.style.backgroundColor = "#ff9800";
        } else if (tipoAcao === 'delete') {
            caixaAlerta.style.backgroundColor = "#f44336";
        } else if (tipoAcao === 'edit') {
            caixaAlerta.style.backgroundColor = "#2196f3";
        }

        document.body.appendChild(caixaAlerta);

        setTimeout(() => {
            caixaAlerta.remove();
        }, 3000);
    }

    function trocarTabela() {
        const tabelaSelecionada = document.getElementById("tableSelect").value;
        document.getElementById("table1").style.display = tabelaSelecionada === "table1" ? "" : "none";
        document.getElementById("table2").style.display = tabelaSelecionada === "table2" ? "" : "none";
        linhaSelecionada = null;

        if (tabelaSelecionada === "table1") {
            carregarUsuarios();
        } else {
            carregarLojistas();
        }
    }

    function selecionarLinhaTabela(row) {
        if (linhaSelecionada) linhaSelecionada.classList.remove("selected");
        linhaSelecionada = row;
        linhaSelecionada.classList.add("selected");
        console.log("Linha selecionada:", linhaSelecionada);
    }

    async function carregarUsuarios() {
        const url = 'http://localhost:4000/usuarios';
        try {
            const resposta = await fetch(url);
            if (!resposta.ok) throw new Error('Resposta de rede não foi ok');
            const dados = await resposta.json();
            console.log('Usuários carregados:', dados);
            const corpoTabela = document.getElementById("table1Body");

            corpoTabela.innerHTML = '';
            dados.forEach(item => {
                const linha = document.createElement('tr');
                linha.className = 'selectable';
                linha.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.nome}</td>
                    <td>${item.cpf}</td>
                    <td>${item.dataNasc}</td>
                    <td>${item.telefone}</td>
                    <td>${item.email}</td>
                    <td>${item.status}</td>
                `;
                corpoTabela.appendChild(linha);
            });

            configurarEventosCliqueLinha();
        } catch (error) {
            console.error('Erro ao carregar usuários:', error);
            exibirAlerta('Erro ao carregar usuários.', 'edit');
        }
    }

    async function carregarLojistas() {
        const url = 'http://localhost:4000/lojistas';
        try {
            const resposta = await fetch(url);
            if (!resposta.ok) throw new Error('Resposta de rede não foi ok');
            const dados = await resposta.json();
            const corpoTabela = document.getElementById("table2Body");

            corpoTabela.innerHTML = '';
            dados.forEach(item => {
                const linha = document.createElement('tr');
                linha.className = 'selectable';
                linha.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.nome}</td>
                    <td>${item.sobrenome}</td>
                    <td>${item.nomeEmpresa}</td>
                    <td>${item.cnpj}</td>
                    <td>${item.cep}</td>
                    <td>${item.logradouro}</td>
                    <td>${item.cidade}</td>
                    <td>${item.estado}</td>
                    <td>${item.numEstab}</td>
                    <td>${item.numContato}</td>
                    <td>${item.email}</td>
                    <td>${item.status}</td>
                `;
                corpoTabela.appendChild(linha);
            });

            configurarEventosCliqueLinha();
        } catch (error) {
            console.error('Erro ao carregar lojistas:', error);
            exibirAlerta('Erro ao carregar lojistas.', 'edit');
        }
    }

    async function editarLinha() {
        if (linhaSelecionada) {
            console.log("Linha selecionada: ", linhaSelecionada);
            const celulas = linhaSelecionada.getElementsByTagName('td');
            const id = celulas[0].innerText;
            const ehTabelaUsuarios = document.getElementById("table1").style.display === "";
    
            // Converter todas as células em inputs
            const inputs = [];
            for (let i = 1; i < celulas.length; i++) {
                const conteudoCelula = celulas[i].innerText;
                console.log(`Convertendo célula ${i} em input com valor: ${conteudoCelula}`);
                celulas[i].innerHTML = `<input type='text' value='${conteudoCelula}' class='form-control'/>`;
                inputs.push(celulas[i].querySelector('input')); // Armazenar a referência ao input
            }
    
            console.log("Número de inputs convertidos: ", inputs.length);

            const salvarEdicao = async (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    console.log("Enter pressionado. Salvando edição...");
    
                    let dadosAtualizados = {};
                    if (ehTabelaUsuarios) {
                        dadosAtualizados = {
                            nome: inputs[0].value,
                            cpf: inputs[1].value,
                            dataNasc: inputs[2].value,
                            telefone: inputs[3].value,
                            email: inputs[4].value,
                        };
                    } else {
                        dadosAtualizados = {
                            nome: inputs[0].value,
                            sobrenome: inputs[1].value,
                            nomeEmpresa: inputs[2].value,
                            cnpj: inputs[3].value,
                            cep: inputs[4].value,
                            logradouro: inputs[5].value,
                            cidade: inputs[6].value,
                            estado: inputs[7].value,
                            numEstab: inputs[8].value,
                            numContato: inputs[9].value,
                            email: inputs[10].value,
                        };
                    }
                    console.log("Dados atualizados: ", dadosAtualizados);
    
                    const url = ehTabelaUsuarios ? `http://localhost:4000/usuarios/${id}` : `http://localhost:4000/lojistas/${id}`;
                    await fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(dadosAtualizados)
                    });
                    console.log("Dados enviados para a URL: ", url);
    
                    exibirAlerta('Usuário/lojista editado com sucesso!', 'edit');
    
                    // Após salvar, converter os inputs de volta para texto
                    for (let i = 0; i < inputs.length; i++) {
                        if (inputs[i]) {
                            console.log(`Convertendo input ${i + 1} de volta para texto com valor: ${inputs[i].value}`);
                            celulas[i + 1].innerHTML = inputs[i].value; // Acesso correto
                        }
                    }
    
                    
                    Array.from(inputs).forEach(input => {
                        input.removeEventListener('keypress', salvarEdicao);
                        console.log(`Removendo listener do input com valor: ${input.value}`);
                    });
                }
            };
    
            inputs.forEach(input => {
                input.addEventListener('keypress', salvarEdicao);
                console.log(`Adicionando listener ao input com valor: ${input.value}`);
            });
        } else {
            console.log("Nenhuma linha selecionada.");
            exibirAlerta('Selecione uma linha para editar.', 'edit');
        }
    }
    
    function deletarLinha() {
        if (linhaSelecionada) {
            const celulas = linhaSelecionada.getElementsByTagName('td');
            const id = celulas[0].innerText;
            const ehTabelaUsuarios = document.getElementById("table1").style.display === "";

            const url = ehTabelaUsuarios ? `http://localhost:4000/usuarios/${id}` : `http://localhost:4000/lojistas/${id}`;
            fetch(url, {
                method: 'DELETE',
            }).then(() => {
                linhaSelecionada.parentNode.removeChild(linhaSelecionada);
                exibirAlerta('Usuário/lojista deletado com sucesso!', 'delete');
                linhaSelecionada = null;
                if (ehTabelaUsuarios) {
                    carregarUsuarios();
                } else {
                    carregarLojistas();
                }
            }).catch(() => {
                exibirAlerta('Erro ao deletar o usuário/lojista.', 'delete');
            });
        } else {
            console.log("Nenhuma linha selecionada.");
            exibirAlerta('Selecione uma linha para deletar.', 'delete');
        }
    }

    function banirLinha() {
        if (linhaSelecionada) {
            const celulas = linhaSelecionada.getElementsByTagName('td');
            const id = celulas[0].innerText;
            const ehTabelaUsuarios = document.getElementById("table1").style.display === "";
            
            const statusAtual = ehTabelaUsuarios ? celulas[6].innerText === 'true' : celulas[12].innerText === 'true';
            const novoStatus = !statusAtual;
    
            const url = ehTabelaUsuarios
                ? `http://localhost:4000/usuarios/${id}/banir`
                : `http://localhost:4000/lojistas/${id}/banir`;
    
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: novoStatus })
            })
            .then(resposta => {
                if (!resposta.ok) {
                    return resposta.json().then(err => {
                        throw new Error(err.message || 'Erro desconhecido ao atualizar o status');
                    });
                }
    
            
                if (ehTabelaUsuarios) {
                    celulas[6].innerText = novoStatus;
                } else {
                    celulas[12].innerText = novoStatus;
                }
                
                exibirAlerta(novoStatus ? 'Status ativado com sucesso!' : 'Status banido com sucesso!', 'ban');
            })
            .catch(error => {
                console.error('Erro ao atualizar o status:', error);
                exibirAlerta('Erro ao atualizar o status: ' + error.message, 'ban');
            });
        } else {
            exibirAlerta('Selecione uma linha para atualizar o status.', 'ban');
        }
    }

    document.getElementById("editButton").addEventListener("click", editarLinha);
    document.getElementById("banButton").addEventListener("click", banirLinha);
    document.getElementById("deleteButton").addEventListener("click", deletarLinha);
    document.getElementById("tableSelect").addEventListener("change", trocarTabela);

    function configurarEventosCliqueLinha() {
        const linhasSelecionaveis = document.querySelectorAll('.selectable');
        linhasSelecionaveis.forEach(linha => {
            linha.addEventListener('click', () => {
                selecionarLinhaTabela(linha);
            });
        });
    }

    trocarTabela();
})();
