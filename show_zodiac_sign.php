<?php include('layouts/header.php'); ?>

<div class="video-background">
    <video autoplay loop muted>
        <source src="assets/videos/zodiac_video.mp4" type="video/mp4">
        Lamento, seu navegador não suporta o vídeo.
    </video>
</div>

<div class="container mt-5">
    <?php
    // Verifica se a data de nascimento foi recebida
    if (isset($_POST['data_nascimento'])) {
        // Recebe a data de nascimento do formulário
        $data_nascimento = $_POST['data_nascimento'];
        $data_nascimento = date("d/m", strtotime($data_nascimento));

        // Carrega o meu XML com os signos
        $signos = simplexml_load_file("signos.xml");

        // Lógica para encontrar o signo
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

        // Vai exibir o resultado
        if ($signo_encontrado) {
            echo "<h2 class='result-title'>Seu Signo é: " . $signo_encontrado->signoNome . "</h2>";
            echo "<p class='result-description'>" . $signo_encontrado->descricao . "</p>";
        } else {
            echo "<p>Signo não encontrado.</p>";
        }
    } else {
        // Caso o formulário não tenha sido enviado
        echo "<p>Por favor, insira uma data para descobrir seu signo.</p>";
    }
    ?>

    <!-- Aqui o botão de voltar -->
    <div class="btn-container">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</div>

</body>
</html>
