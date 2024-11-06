<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubra seu signo - by Yasmin Starke</title>
</head>
<body>
    
<?php include('layouts/header.php'); ?>

<div class="video-background">
    <video autoplay loop muted>
        <source src="assets/videos/zodiac_video.mp4" type="video/mp4">
        Seu navegador não suporta o elemento de vídeo.
    </video>
</div>

<div class="container mt-5">
    <?php
    // Vai verificar se a data de nascimento foi inserida no formulário
    if (isset($_POST['data_nascimento']) && !empty($_POST['data_nascimento'])) {
        $data_nascimento = $_POST['data_nascimento'];
        $data_nascimento = date("d/m", strtotime($data_nascimento));

        // Carrega o XML com os signos
        $signos = simplexml_load_file("signos.xml");

        // Essa é a lógica para encontrar o signo
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

        // Aqui vai exibir o resultado do signo
        if ($signo_encontrado) {
            echo "<h2 class='result-title'>Seu Signo é: " . $signo_encontrado->signoNome . "</h2>";
            echo "<p class='result-description'>" . $signo_encontrado->descricao . "</p>";
        } else {
            echo "<p>Signo não encontrado.</p>";
        }
        // Exibe o botão de voltar após o resultado
        echo '<a href="index.php" class="btn btn-primary">Voltar</a>';  // Botão de voltar com a mesma cor do tema

    } else {
        // Caso a data de nascimento não tenha sido recebida, exibe o formulário
        ?>

        <h1>Descubra qual é o seu Signo do Zodíaco</h1> <!-- Exibe o título apenas quando o formulário está visível -->
        
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
