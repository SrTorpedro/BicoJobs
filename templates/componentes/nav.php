<header>
    <img src="<?php echo $caminho.'/media/Logo.svg'?>" alt="Logo BicoJobs" class="logo">
    <h1>Bico Jobs</h1>
    <nav>
        <a href="<?php echo $caminho."templates/servicos.php"?>">Serviços</a>

        <?php 
            if($_SESSION['tipo_usuario'] != 0){
                include("../functions/retornarServicosFeitos.php");
                $pendencias = $user->getServicosPendencias($pdo);

                echo '
                <div class="meus_bicos">
                    <div class="none" >'.$pendencias.'</div>
                    <a href="../templates/seus_bicos.php">Meus Bicos</a>
                </div>';
            }
        ?>

        <a href="<?php echo $caminho."templates/ultimos_bicos.php"?>">Últimos serviços</a>
        <a href="<?php echo $caminho."templates/regras.php"?>">Regras</a>
    </nav>

    <div class="perfil" onclick="abrir_options()">
        <p class="nome_perfil"><?php echo $_SESSION["nome"]; ?> </p>
        <div class="img">
            <img src="<?php if($_SESSION['img_perfil'] == ""){
                echo "../media/svg/perfil.svg";
            } else{
                echo $caminho."media/img_perfis/".$_SESSION['img_perfil'];
            }
            ?>" alt="perfil">
        </div>
    </div>

    <div class="opçoes op_none">
        <?php 
            if($_SESSION['tipo_usuario'] != 0){
                echo '<a href="'.$caminho.'templates/perfil.php">Perfil</a><div></div>';
            }
        ?>
        <a href="<?php echo $caminho."functions/logout.php"?>">Sair</a>
    </div>
</header>