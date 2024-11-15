<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubra seu signo - by Yasmin Starke</title>
    <style>
        /* Estilos para o título sobre o vídeo */
        .titulo-video {
            position: absolute;
            top: 15%; /* Subi ainda mais o título em relação ao centro */
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10; /* título acima do vídeo */
            color: white; /* Cor do texto */
            text-align: center; /* Centraliza o texto */
            width: 100%; /* A largura do título será igual à largura da tela */
            animation: bounce 3s ease-in-out infinite; /* Animação contínua de "bounce" */
        }

        /* Animação de bounce */
        @keyframes bounce {
            0%, 100% {
                transform: translate(-50%, -50%); /* Posição inicial (sem movimento) */
            }
            30% {
                transform: translate(-50%, -60%); /* Sobe um pouco */
            }
            50% {
                transform: translate(-50%, -50%); /* Volta para o centro */
            }
            70% {
                transform: translate(-50%, -55%); /* Sobe um pouco mais */
            }
            90% {
                transform: translate(-50%, -50%); /* Volta para o centro */
            }
        }

        /* Estilos para o vídeo */
        .video-background {
            position: relative;
            width: 100%;
            height: 100vh; /* Ocupa toda a altura da tela */
            overflow: hidden;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Overlay escuro sobre o vídeo */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Cor preta com opacidade de 50% */
            z-index: 5; /* Coloca o overlay abaixo do título, mas acima do vídeo */
        }
    </style>
</head>
<body>
    
<?php include('layouts/header.php'); ?>

<!-- meu título sobre o vídeo -->
<div class="titulo-video">
    <h1 class="display-4 fw-bold">Descubra Seu Signo do Zodíaco</h1>
    <p class="lead">Deixe os astros guiarem você! Descubra o que o universo revela sobre sua personalidade.</p>
</div>

<div class="video-background">
    <!-- Overlay escuro -->
    <div class="video-overlay"></div>
    <video autoplay loop muted>
        <source src="assets/videos/zodiac_video.mp4" type="video/mp4">
        Lamento, seu navegador não suporta o vídeo.
    </video>
</div>

<div class="container mt-5">
    <?php
    // Vai verificar se a data de nascimento foi inserida no formulário
    if (isset($_POST['data_nascimento']) && !empty($_POST['data_nascimento'])) {
        $data_nascimento = $_POST['data_nascimento'];
        $data_nascimento = date("d/m", strtotime($data_nascimento));

        // Carrega o XML com todas as caracteristicas que criei dos signos 
        $signos = simplexml_load_file("signos.xml");

        // Aqui esta a lógica para encontrar o signo
        $signo_encontrado = null;
        foreach ($signos->signo as $signo) {
            $dataInicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
            $dataFim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);
            $dataUsuario = DateTime::createFromFormat('d/m', $data_nascimento);

            if (($dataUsuario >= $dataInicio && $dataUsuario <= $dataFim) ||
                ($dataInicio > $dataFim && ($dataUsuario >= $dataInicio || $dataUsuario <= $dataFim))) {
                $signo_encontrado = $signo;
                break;
            }
        }

        // Aqui ele vai exibir o resultado do signo
        if ($signo_encontrado) {
            echo "<h2 class='result-title'>Seu Signo é: " . $signo_encontrado->signoNome . "</h2>";
            echo "<p class='result-description'>" . $signo_encontrado->descricao . "</p>";
        } else {
            echo "<p>Signo não encontrado.</p>";
        }
        // Exibe o botão de voltar após o resultado
        echo '<a href="index.php" class="btn btn-primary">Voltar</a>';  // Botão de voltar com a mesma cor do tema

    } else {
        // Caso a data de nascimento não tenha sido recebida, mostra o formulário
        ?>

        <h1>Descubra qual é o seu Signo do Zodíaco</h1> <!-- Mostra o título apenas quando o formulário está visível -->
        
        <form id="signo-form" method="POST" action="">
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            <button type="submit" class="btn btn-primary">Ver meu Signo</button>
        </form>

        <?php
    }
    ?>
</div>

</body>
</html>
