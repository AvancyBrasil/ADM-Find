<?php
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: ../view/index.php");
    echo "<script>alert('Usuário ou senha incorretos!');</script>";
    exit();
}

$token = $_SESSION['token'];

$jsonUrl = 'http://localhost/Administrador-atual/select/selectProdutos.php';
$url = 'http://localhost:4000/usuarios';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $jsonUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$jsonContent = curl_exec($ch);
$produtosArray = json_decode($jsonContent, true);

curl_close($ch);

if ($response !== false) {
    $usuarios = json_decode($response, true);
} else {
    $usuarios = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--CSS-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../controller/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../controller/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../controller/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../controller/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../controller/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../controller/css/style.css">
    <title>Find ADM</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" style="margin-top: 20px;">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="../img/Icone Branco.png" height="50px" style="margin-bottom: 10px;">
                </div>
                <div class="sidebar-brand-text mx-3" style="font-size: 20px;">Find ADM</div>
            </a>

            

            <!-- Nav Item - Contas Ativas -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-target="overlay1">
                    <i class="fas fa-fw fa-users"></i> <!-- Ícone de grupo de usuários -->
                    <span>Usuários</span>
                </a>
            </li>


           

            <!-- Nav Item - Financeiro -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-target="overlay2">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span>Financeiro</span></a>
            </li>

            

            <!-- Nav Item - Região -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-target="overlay3">
                    <i class="fas fa-fw fa-globe"></i>
                    <span>Região</span></a>
            </li>

            

            <!-- Nav Item - Suporte -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-target="overlay4">
                    <i class="fas fa-fw fa-headset"></i>
                    <span>Suporte</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline" style="margin-top: 20px;">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Pesquisar... -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Pesquisar..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Central de Alertas
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">12 de Dezembro, 2019</div>
                                        <span class="font-weight-bold">Um novo relatório mensal está pronto para
                                            download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">7 de Dezembro, 2019</div>
                                        $290,29 foram depositados em sua conta!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">2 de Dezembro, 2019</div>
                                        Alerta de gastos: Notamos gastos incomumente altos em sua conta.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar todos os
                                    alertas</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Central de Mensagens
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Oi! Preciso de ajuda para resetar minha senha. Pode me orientar?</div>
                                        <div class="small text-gray-500">João Silva · 10m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Estou enfrentando problemas com o login. O sistema diz que minhas credenciais estão erradas.</div>
                                        <div class="small text-gray-500">Ana Souza · 1h</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Minha conta foi bloqueada e não consigo mais acessar. Preciso de ajuda urgente!</div>
                                        <div class="small text-gray-500">Carlos Pereira · 3h</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Eu enviei uma solicitação de suporte, mas ainda não recebi retorno. Pode verificar?</div>
                                        <div class="small text-gray-500">Mariana Lima · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Ler mais mensagens</a>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="ola" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Arthur Dantas</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configurações
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div id="overlay1" class="overlay">
                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Quantidade de usuários</div>
                                                <div id="totalUsuarios" class="h5 mb-0 font-weight-bold text-gray-800">3500</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    novos usuários</div>
                                                <div id="totalUsuarios1" class="h5 mb-0 font-weight-bold text-gray-800">500</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chamados Pendentes -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Chamados Pendentes</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tendência de crescimento das contas -->

                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Tendência de crescimento das
                                            contas</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Distribuição de usuários</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="myPieChart"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-primary"></i> Usuários ativos
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> Usuários inativos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Tabelas</h1>
                        <p class="mb-4">
                            A tabela a seguir apresenta a distribuição dos usuários, diferenciando entre lojistas e não
                            lojistas. Ela ilustra a participação de cada grupo dentro da plataforma, facilitando a
                            análise do comportamento e necessidades específicas de ambos os tipos de usuários.
                        </p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="itens-tabela d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                                <div class="titulo-tabela">
                                    <h6 class="texto-tabela" style="margin-left: 20px; color: #4e73df; font-weight: 700; font-size: 1rem;">
                                        Tabelas de usuários
                                    </h6>
                                </div>
                                <div class="selecao-tabelas d-flex align-items-center">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar"
                                        style="max-width: 200px; margin-right: 20px;">
                                    <select id="tableSelect" class="form-control" style="width: 200px; margin-right: 20px;">
                                        <option value="table1">Usuário comum</option>
                                        <option value="table2">Lojista</option>
                                    </select>
                                    <button class="btn btn-danger" id="deleteButton" style="margin-right: 10px;">
                                        <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> Deletar
                                    </button>
                                    <button class="btn btn-warning" id="banButton" style="margin-right: 10px;">
                                        <i class="fas fa-user-slash" style="margin-right: 5px;"></i> Banir
                                    </button>
                                    <button class="btn btn-info" id="editButton" style="margin-right: 20px;">
                                        <i class="fas fa-edit" style="margin-right: 5px;"></i> Editar
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Tabela 1 -->
                                    <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>CPF</th>
                                                <th>Data de Nascimento</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table1Body">
                                         
                                        </tbody>
                                    </table>

                                    <!-- Tabela 2 -->
                                    <table class="table table-bordered" id="table2" width="100%" cellspacing="0"
                                        style="display:none;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Sobrenome</th>
                                                <th>Nome da Empresa</th>
                                                <th>CNPJ</th>
                                                <th>CEP</th>
                                                <th>Logradouro</th>
                                                <th>Cidade</th>
                                                <th>Estado</th>
                                                <th>Número do Estabelecimento</th>
                                                <th>Número de Contato</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table2Body">
                                            
                                        </tbody>
                                    </table>
                                    <!-- Paginação -->
                                    <div class="pagination">
                                        <button id="prevBtn" class="btn btn-secondary" disabled>Anterior</button>
                                        <span id="pageInfo" style="padding: 10px;">Página 1 de 1</span>
                                        <button id="nextBtn" class="btn btn-secondary">Próximo</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>
                </div>
                <!-- Overlay 2 -->
                <div id="overlay2" class="overlay">
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Financeiro</h1>
                        </div>
                        <div class="row">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Lojistas
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">1500</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="h5 mb-0 font-weight-bold text-gray-800">FREE</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Lojistas
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">2000</div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="h5 mb-0 font-weight-bold text-gray-800">PRO</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Gerenciamento de assinaturas</h1>
                        </div>
                        <!-- Area Chart -->
                        <div class="assinaturas">
                            <div class="card-assinaturas">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc; height: 60px;">
                                    <h6 class="m-0 font-weight-bold text-primary">Selecione a Tabela</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <select id="tabelaSelect" class="form-control" onchange="toggleTables()">
                                        <option value="sem-assinatura">Lojistas FREE</option>
                                        <option value="com-assinatura">Lojistas PRO</option>
                                    </select>

                                    <div class="table-responsive mt-3">
                                        <!-- Tabela Lojistas sem Assinatura -->
                                        <table id="tableSemAssinatura" class="table table-bordered" width="100%" cellspacing="0" style="display: table;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>Sobrenome</th>
                                                    <th>CPF</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table3Body">
                                                <tr class="selectable-table2">
                                                    <td>1</td>
                                                    <td>Lucas</td>
                                                    <td>Silva</td>
                                                    <td>123.456.789-00</td>
                                                    <td>lucas.silva@example.com</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>2</td>
                                                    <td>Fernanda</td>
                                                    <td>Souza</td>
                                                    <td>987.654.321-00</td>
                                                    <td>fernanda.souza@example.com</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>3</td>
                                                    <td>Guilherme</td>
                                                    <td>Oliveira</td>
                                                    <td>111.222.333-44</td>
                                                    <td>guilherme.oliveira@example.com</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>4</td>
                                                    <td>Beatriz</td>
                                                    <td>Pereira</td>
                                                    <td>222.333.444-55</td>
                                                    <td>beatriz.pereira@example.com</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>5</td>
                                                    <td>Rafael</td>
                                                    <td>Almeida</td>
                                                    <td>333.444.555-66</td>
                                                    <td>rafael.almeida@example.com</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>6</td>
                                                    <td>Aline</td>
                                                    <td>Barbosa</td>
                                                    <td>444.555.666-77</td>
                                                    <td>aline.barbosa@example.com</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Tabela Lojistas com Assinatura Pro -->
                                        <table id="tableComAssinatura" class="table table-bordered" width="100%" cellspacing="0" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>Sobrenome</th>
                                                    <th>CPF</th>
                                                    <th>Email</th>
                                                    <th>Status de Pagamento</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table3Body">
                                                <tr class="selectable-table2">
                                                    <td>1</td>
                                                    <td>Lucas</td>
                                                    <td>Silva</td>
                                                    <td>123.456.789-00</td>
                                                    <td>lucas.silva@example.com</td>
                                                    <td class="pago">Pago</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>2</td>
                                                    <td>Fernanda</td>
                                                    <td>Souza</td>
                                                    <td>987.654.321-00</td>
                                                    <td>fernanda.souza@example.com</td>
                                                    <td class="nao-pago">Não Pago</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>3</td>
                                                    <td>Guilherme</td>
                                                    <td>Oliveira</td>
                                                    <td>111.222.333-44</td>
                                                    <td>guilherme.oliveira@example.com</td>
                                                    <td class="pago">Pago</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>4</td>
                                                    <td>Beatriz</td>
                                                    <td>Pereira</td>
                                                    <td>222.333.444-55</td>
                                                    <td>beatriz.pereira@example.com</td>
                                                    <td class="nao-pago">Não Pago</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>5</td>
                                                    <td>Rafael</td>
                                                    <td>Almeida</td>
                                                    <td>333.444.555-66</td>
                                                    <td>rafael.almeida@example.com</td>
                                                    <td class="pago">Pago</td>
                                                </tr>
                                                <tr class="selectable-table2">
                                                    <td>6</td>
                                                    <td>Aline</td>
                                                    <td>Barbosa</td>
                                                    <td>444.555.666-77</td>
                                                    <td>aline.barbosa@example.com</td>
                                                    <td class="nao-pago">Não Pago</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>
                </div>

                <!-- Overlay 3 -->
                <div id="overlay3" class="overlay">
                    <div class="container-fluid">
                        <!-- Area Chart -->
                        <div class="localizacao">
                            <div class="card-localizacao">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #f8f9fc; height: 60px;">
                                    <h6 class="m-0 font-weight-bold text-primary">localização de estabelecimentos</h6>
                                    <input id="searchBox" type="text" placeholder="Buscar locais...">
                                    <datalist id="mercadinhoList"></datalist>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div id="map"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Overlay 4 -->
                <div id="overlay4" class="overlay">
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Chamados</h1>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2" data-id="card1"> <!-- Mudança aqui -->
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Carlos Alberto</div>
                                                <div class="" style="margin-top: 10px;">
                                                    Preciso de ajuda com a localização
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-1000"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Repetir com IDs diferentes para os demais cards -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2" data-id="card2"> <!-- Outro card -->
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Carlos Alberto</div>
                                                <div class="" style="margin-top: 10px;">
                                                    Preciso de ajuda com a localização
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-1000"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2" data-id="card3"> <!-- Outro card -->
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Carlos Alberto</div>
                                                <div class="" style="margin-top: 10px;">
                                                    Preciso de ajuda com a localização
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x text-gray-1000"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="chamadoModal" tabindex="-1" role="dialog" aria-labelledby="chamadoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="chamadoModalLabel">Opções de Chamado</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            O que você deseja fazer com este chamado?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="responderChamado">Responder Chamado</button>
                                            <button type="button" class="btn btn-danger" id="encerrarChamado">Encerrar Chamado</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Aprovação de Lojistas</h1>
                        </div>
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="itens-tabela d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                                <div class="titulo-tabela">
                                    <h6 class="texto-tabela" style="margin-left: 20px; color: #4e73df; font-weight: 700; font-size: 1rem;">
                                        Aprovação de Lojistas
                                    </h6>
                                </div>
                                <div class="selecao-tabelas d-flex align-items-center">
                                    <button class="btn btn-approve custom-button" id="btnApprove" style="margin-right: 10px;">
                                        <i class="fas fa-check" style="margin-right: 5px;"></i> Aprovar
                                    </button>
                                    <button class="btn btn-reject custom-button" id="btnReject" style="margin-right: 20px;">
                                        <i class="fas fa-times" style="margin-right: 5px;"></i> Reprovar
                                    </button>

                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Tabela 1 -->
                                    <table id="customTable3" class="table table-bordered" width="100%" cellspacing="0" style="display: table;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Sobrenome</th>
                                                <th>Nome da Empresa</th>
                                                <th>CNPJ</th>
                                                <th>CEP</th>
                                                <th>Logradouro</th>
                                                <th>Cidade</th>
                                                <th>Estado</th>
                                                <th>Número do Estabelecimento</th>
                                                <th>Número de Contato</th>
                                                <th>Email</th>
                                                <th>Senha</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="tabela3" id="table3Body">
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>
                </div>
                <!-- Modal de Logout-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pronto para Sair?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Selecione "Sair" abaixo se você estiver pronto para encerrar sua sessão atual.
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                <a class="btn btn-primary" href="../controller/logout.php">Sair</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!--JavaScript-->
                <script src="../controller/vendor/jquery/jquery.min.js"></script>
                <script src="../controller/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="../controller/vendor/jquery-easing/jquery.easing.min.js"></script>
                <script src="../controller/vendor/chart.js/Chart.min.js"></script>
                <script src="../controller/js/nav-esquerda.min.js"></script>
                <script src="../controller/js/crescimento.js"></script>
                <script src="../controller/js/rosquinha.js"></script>
                <script src="../controller/js/tabelas.js"></script>
                <script src="../controller/js/pesquisa.js"></script>
                <script src="../controller/js/paginacao.js"></script>
                <script src="../controller/js/overlay.js"></script>
                <script src="../controller/js/modal.js"></script>
                <script src="../controller/js/tabela-aprovacao.js"></script>
                <script src="../controller/js/mapa.js"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQhcE8wYt1ukHH6sZOUC0W3dwrad7JLhc&libraries=places&callback=initMap" async defer></script>
                <script src="../controller/js/modal-chamado.js"></script>
                <script src="../controller/js/assinaturas.js"></script>
</body>

</html>