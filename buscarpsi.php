<?php
include('db.php'); // Conecta com o banco de dados

// Recupera os filtros aplicados
$especialidade = isset($_GET['especialidade']) ? $_GET['especialidade'] : '';
$abordagem = isset($_GET['abordagem']) ? $_GET['abordagem'] : '';
$idioma = isset($_GET['idioma']) ? $_GET['idioma'] : '';
$nome = isset($_GET['nome']) ? $_GET['nome'] : '';

// Consultar psicólogos com base nos filtros
$query = "SELECT * FROM psicologos WHERE nome LIKE '%$nome%'";

// Filtros adicionais
if ($especialidade) {
    $query .= " AND JSON_CONTAINS(especialidades, '\"$especialidade\"')";
}

if ($abordagem) {
    $query .= " AND abordagem = '$abordagem'";
}

if ($idioma) {
    $query .= " AND publico = '$idioma'";
}

// Limitar os resultados a 20 psicólogos por vez
$query .= " LIMIT 20";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="Assets/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="Assets/favicon.svg" />
    <link rel="shortcut icon" href="Assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="Assets/apple-touch-icon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
          <a class="navbar-brand" href="#">
              <img src="Assets/Logo.png" alt="PsiNote" height="50">
          </a>
          <!-- Botão do menu hamburguer -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list"></i>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="buscarpsi.php">Psicólogos</a></li>
                  <li class="nav-item"><a class="nav-link" href="soupsi.html">Sou Psicólogo</a></li>
                  <li class="nav-item"><a class="nav-link" href="index.html#anchor">Conteúdo</a></li>
              </ul>
          </div>
      </div>
  </nav>
  </header> 

  <div class="container mt-4">
        <!-- Seção de Busca -->
        <div class="search-box p-4 shadow-sm rounded">
            <h4 class="text-center mb-3">Encontre Especialistas</h4>
            <form id="searchForm" class="row g-2">
    
    <!-- Formulário de Filtros -->
    <form action="" method="GET">

    <div class="col-md-3">
        <select name="especialidade" class="form-select">
            <option value="">Especialidade</option>
            <option value="Ansiedade">Ansiedade</option>
            <option value="Depressão">Depressão</option>
            <!-- Adicione mais especialidades -->
        </select>
    </div>

    <div class="col-md-3">
        <select name="abordagem" class="form-select">
            <option value="">Abordagem</option>
            <option value="Cognitiva">Cognitiva</option>
            <option value="Psicanalítica">Psicanalítica</option>
            <!-- Adicione mais abordagens -->
        </select>
    </div>

    <div class="col-md-3">
        <select name="idioma" class="form-select">
            <option value="">Idioma</option>
            <option value="Português">Português</option>
            <option value="Espanhol">Espanhol</option>
            <!-- Adicione mais idiomas -->
        </select>
    </div>

    <div class="col-md-3">
        <input type="text" name="nome" class="form-control" placeholder="Buscar por nome" value="<?= $nome ?>">
    </div>   

    <div class="col-md-3 d-flex">
        <button type="submit" class="btn btn-primary w-50">Buscar</button>
    </div>

      </form>
    </div>

    <!-- Lista de Psicólogos -->
    <div class="results mt-4">
            <div id="resultsContainer" class="row">
        <?php while ($psicologo = $result->fetch_assoc()): ?>
            <div class="col-md-12 mb-3">
                <div class="result-card p-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <img src="<?= $psicologo['imagem'] ?>" class="rounded-circle profile-img me-3">
                            <div>
                                <p class="text-muted small mb-1"><?= $psicologo['crp'] ?></p>
                                <p class="fw-bold">ABORDAGEM: <?= $psicologo['abordagem'] ?></p>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <i class="fas fa-users text-secondary"></i>
                                    <span class="text-muted"><?= $psicologo['publico'] ?></span>
                                </div>
                                <div class="text-success fw-bold mt-2">💰 R$<?= $psicologo['valor'] ?></div>
                            </div>
                        </div>
                        <a href="perfil.php?id=<?= $psicologo['id'] ?>" class="text-decoration-none text-dark small fw-bold">VER PERFIL</a>
                    </div>

                    <h5 class="mt-3"><?= $psicologo['nome'] ?></h5>
                    <p class="text-muted"><?= $psicologo['descricao'] ?></p>

                    <div class="specialties bagde">
                        <?php 
                            $especialidades = json_decode($psicologo['especialidades']);
                            foreach ($especialidades as $especialidade) {
                                echo "<span class='badge'>$especialidade</span>";
                            }
                        ?>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="#" class="contact-btn">Entre em Contato</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
     </div>
    </div>

    <!-- Botão Ver Mais -->
    <button id="ver-mais-btn">Ver Mais</button>

    <script src="script.js"></script>

<?php $conn->close(); ?>



    <footer class="container-fluid">
        <div class="container">
          <div class="row d-flex justify-content-between align-items-start">
      
            <!-- Logo e Social Media -->
            <div class="col-md-3 mb-4 text-center d-flex flex-column align-items-center">
              <img src="Assets/Logo.png" alt="Logo da PsiNote" class="img-fluid mb-3" style="max-width: 150px;">
              <div class="social-icons">
                <i class="fab fa-whatsapp"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-linkedin-in"></i>
              </div>
            </div>
      
            <!-- Contact -->
            <div class="col-md-3 mb-4 footer-link">
              <h5>Contato</h5>
              <p>(12) 1234-5677</p>
              <p>Contato@psinote.com.br</p>
              <p>Rua José Elache, Jardim Santo Afonso, Aparecida-Sp</p>
            </div>
      
            <!-- Recommended Links -->
            <div class="col-md-3 mb-4 footer-link">
              <h5>Links Recomendados</h5>
              <p><a href="https://site.cfp.org.br/">Conselho Federal de Psicologia</a></p>
              <p><a href="https://site.cfp.org.br/wp-content/uploads/2018/05/RESOLU%C3%87%C3%83O-N%C2%BA-11-DE-11-DE-MAIO-DE-2018.pdf">Resolução CFP 011/2018</a></p>
              <p><a href="https://site.cfp.org.br/wp-content/uploads/2012/07/codigo-de-etica-psicologia.pdf">Código de Ética do Psicólogo</a></p>
            </div>
      
            <!-- Content -->
            <div class="col-md-3 mb-4 footer-link">
              <h5>Conteúdo</h5>
              <p><a href="https://www.hiwellapp.com/pt-BR/testes">Testes Psicológicos</a></p>
              <p><a href="https://www.instagram.com/psi.note/">Instagram</a></p>
            </div>
      
            <!-- Navigation -->
            <div class="col-md-3 mb-4 footer-link">
              <h5>Navegação</h5>
              <p><a href="index.html#comofunciona">Como Funciona</a></p>
              <p><a href="termosdeuso.html">Termos de Uso</a></p>
              <p><a href="politicasdeprivacidade.html">Políticas de Privacidade</a></p>
              <p><a href="index.html#faq">Perguntas Frequentes</a></p>
            </div>
          </div>
      
          <!-- Copyright -->
          <div class="row">
            <div class="col-12 copyright text-center">
              <p>&copy; PsiNote 2025 / Todos os Direitos Reservados</p>
            </div>
          </div>
        </div>
      </footer>
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>