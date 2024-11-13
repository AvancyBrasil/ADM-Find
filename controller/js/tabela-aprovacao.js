document.addEventListener("DOMContentLoaded", function() {
    let selectedRowTable3 = null; 

    function selectRowTable3(row) {
        if (selectedRowTable3) {
            selectedRowTable3.classList.remove("selected");
        }
        selectedRowTable3 = row; 
        row.classList.add("selected");
    }

    const sendEmail = async (emailData) => {
        try {
            const response = await fetch('http://localhost:4000/validacao/emailAprovado', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(emailData)
            });

            if (!response.ok) {
                throw new Error(`Erro ao enviar email: ${response.statusText}`);
            }

            const data = await response.json();
            console.log(data.message);
        } catch (error) {
            console.error('Erro ao enviar email:', error.message);
        }
    };

    async function handleApprovalTable3(action) {
        if (selectedRowTable3) {
            const id = selectedRowTable3.cells[0].textContent;
            const name = selectedRowTable3.cells[1].textContent;
            const surname = selectedRowTable3.cells[2].textContent;
            const nomeEmpresa = selectedRowTable3.cells[3].textContent;
            const cnpj = selectedRowTable3.cells[4].textContent;
            const cep = selectedRowTable3.cells[5].textContent;
            const logradouro = selectedRowTable3.cells[6].textContent;
            const cidade = selectedRowTable3.cells[7].textContent;
            const estado = selectedRowTable3.cells[8].textContent;
            const numEstab = selectedRowTable3.cells[9].textContent;
            const numContato = selectedRowTable3.cells[10].textContent;
            const email = selectedRowTable3.cells[11].textContent;
            const senha = selectedRowTable3.cells[12].textContent;

            const lojistaData = {
                nome: name,
                sobrenome: surname,
                nomeEmpresa,
                cnpj,
                cep,
                logradouro,
                cidade,
                estado,
                numEstab,
                numContato,
                email,
                senha
            };

            try {
                if (action === 'approve') {
                    const response = await fetch('http://localhost:4000/lojistas', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(lojistaData)
                    });

                    if (!response.ok) throw new Error('Erro na requisição: ' + response.statusText);

                    
                    const emailData = {
                        to: email,
                        subject: 'Cadastro realizado com sucesso',
                        message: `Olá ${name}! Seus dados foram aprovados para Cadastro. Seja bem-vindo(a) à Find!`
                    };

                    await sendEmail(emailData);

                    showAlertTable3(`Aprovado: ${name} ${surname}`, true);
                } else {
                    showAlertTable3(`Reprovado: ${name} ${surname}`, false);
                }

                const deleteResponse = await fetch(`http://localhost:4000/validacao/${id}`, {
                    method: 'DELETE'
                });

                if (!deleteResponse.ok) throw new Error('Erro ao excluir lojista da validação: ' + deleteResponse.statusText);

                selectedRowTable3.remove();
                selectedRowTable3 = null;
            } catch (error) {
                console.error('Erro ao processar a requisição:', error);
                showAlertTable3('Erro ao processar a requisição.', false);
            }
        } else {
            showAlertTable3("Por favor, selecione uma linha antes de aprovar ou reprovar.");
        }
    }

    function showAlertTable3(message, isApproved) {
        const alertBox = document.createElement("div");
        alertBox.className = "alert-box"; 
        alertBox.textContent = message;
        alertBox.style.backgroundColor = isApproved ? "#4caf50" : "#f44336"; 
        document.body.appendChild(alertBox); 

        setTimeout(() => {
            alertBox.remove();
        }, 3000);
    }

    function configurarEventosCliqueLinha() {
        document.querySelectorAll(".tabela3 tr").forEach(row => {
            row.addEventListener("click", () => selectRowTable3(row));
        });
    }

    document.getElementById("btnApprove").addEventListener("click", () => handleApprovalTable3('approve'));
    document.getElementById("btnReject").addEventListener("click", () => handleApprovalTable3('reject'));

    async function carregarLojistas() {
        const url = 'http://localhost:4000/validacao';
        try {
            const resposta = await fetch(url);
            if (!resposta.ok) throw new Error('Resposta de rede não foi ok');
            const dados = await resposta.json();
    
            const corpoTabela = document.querySelector(".tabela3");
    
            if (!corpoTabela) {
                console.error('Elemento tbody não encontrado na tabela com a classe "tabela3"');
                return;
            }
    
            corpoTabela.innerHTML = ''; 
    
            if (dados.length === 0) {
                const linha = document.createElement('tr');
                linha.innerHTML = `<td colspan="12">Nenhum lojista encontrado.</td>`;
                corpoTabela.appendChild(linha);
            } else {
                dados.forEach(item => {
                    const linha = document.createElement('tr');
                    linha.className = 'selectable-table2';
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
                        <td>${item.senha}</td>
                    `;
                    corpoTabela.appendChild(linha);
                });
            }
    
            configurarEventosCliqueLinha(); 
        } catch (error) {
            console.error('Erro ao carregar lojistas:', error);
            showAlertTable3('Erro ao carregar lojistas.', false);
        }
    }
    
    carregarLojistas();
});
