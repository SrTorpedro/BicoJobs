<?php
include("../conection/conection.php");

//Cria as variáveis, puxando do form no template
$nome = $_POST['user_cad'];
$cpf = $_POST['cpf'];
$dt_nasci = $_POST['dtNasci'];
$pass = $_POST['password_cad'];
$pass1 = $_POST['password2'];
$cep = $_POST['cep'];
$contato = $_POST['email_cad'];
$sql_codes = [];


/*===================================================================================================================*/

if(strlen($cpf) != 11 || $cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333"|| $cpf == "44444444444"|| $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" || $cpf == "99999999999"){
    die("CPF inválido");
}

if($pass != $pass1){
    die("As senhas não coincidem");
} else if(strlen($pass) < 8){
    die("A senha deve ter no mínimo 8 caracteres");
}

if(strlen($cep) != 8 || $cep == "00000000"){
    die("Cep inválido");
}

/*===================================================================================================================*/



// Verifica se tem a cidade no banco
$sql_code_mesmo_cep = "SELECT id FROM cidade WHERE cep = $cep";
$sql_code_last_id = "SELECT id FROM cidade";

// Verifica se é possível efetuar o código ou da erro;
$sql_query = $mysqli->query($sql_code_mesmo_cep) or die("Falha na execuça do código SQL" .$mysqli->error);
// Verifica a qauntidade de lihas afetadas;
$row = $sql_query->fetch_assoc();

// Verifica se é possível efetuar o código ou da erro;
$sql_query_last_id = $mysqli->query($sql_code_last_id) or die("Falha na execuça do código SQL" .$mysqli->error);
// Verifica a qauntidade de lihas afetadas;
$last_id = $sql_query_last_id->num_rows;


if($sql_query->num_rows <= 0){
    $sql = "INSERT INTO cidade (id, cep) VALUES ($last_id, $cep)";
    $sql_codes[] = $sql;
    //(mysqli_query($mysqli, $sql));
    $cep = $last_id;
}
else{
    $cep = $row["id"];
}



/*===================================================================================================================*/



// Verifica se tem contato no banco
$sql_code_contato = "SELECT id FROM contato WHERE contato = '$contato'";
$sql_code_last_id = "SELECT id FROM contato";


$sql_query = $mysqli->query($sql_code_contato) or die("Falha na execuça do código SQL" .$mysqli->error);
$row = $sql_query->fetch_assoc();

$sql_query_last_id = $mysqli->query($sql_code_last_id) or die("Falha na execuça do código SQL" .$mysqli->error);
$last_id = $sql_query_last_id->num_rows;


if($sql_query->num_rows <= 0){
    if($sql_query_last_id->num_rows <=0){
        $sql = "INSERT INTO contato (id, contato) VALUES ($last_id, '$contato')";
        $sql_codes[] = $sql;
        //(mysqli_query($mysqli, $sql));
        $contato = $last_id;
    }
    else{
        $sql = "INSERT INTO contato (id, contato) VALUES ($last_id, '$contato')";
        $sql_codes[] = $sql;
        //(mysqli_query($mysqli, $sql));
        $contato = $last_id;
    }
}
else{
    die("O email já está cadastrado");
}

/*===================================================================================================================*/



// Verifica se tem cpf no banco
$sql_code_cpf = "SELECT id FROM usuario WHERE cpf = '$cpf'";
$sql_code_last_id = "SELECT id FROM usuario";


$sql_query = $mysqli->query($sql_code_cpf) or die("Falha na execuça do código SQL" .$mysqli->error);
$row = $sql_query->fetch_assoc();

$sql_query_last_id = $mysqli->query($sql_code_last_id) or die("Falha na execuça do código SQL" .$mysqli->error);
$last_id = $sql_query_last_id->num_rows;


if($sql_query->num_rows == 1){
    die("O cpf já está cadastrado");
}


/*===================================================================================================================*/


// Verifica se tem usuario no banco
$sql_code_cpf = "SELECT id FROM usuario WHERE nome = '$nome'";
$sql_code_last_id = "SELECT id FROM usuario";


$sql_query = $mysqli->query($sql_code_cpf) or die("Falha na execuça do código SQL" .$mysqli->error);
$row = $sql_query->fetch_assoc();

if($sql_query->num_rows == 1){
    die("O nome de usuario já está cadastrado");
}


/*===================================================================================================================*/

$sql_code = "SELECT id, nome FROM usuario";
$sql_query = $mysqli->query($sql_code) or die("Falha na execuça do código SQL" .$mysqli->error);



if($sql_query->num_rows <= 0){

    if(count($sql_codes) !=3){
        for($i=0 ; $i<count($sql_codes) ; $i++){
            (mysqli_query($mysqli, $sql_codes[$i]));
        }
    
        $sql = "INSERT INTO usuario (id ,nome, cpf, senha, id_cidade, id_contato,tipo_usuario ) VALUES (0 ,'$nome', '$cpf', '$pass', $cep, $contato, 0)";
    
        $mysqli->query($sql);


        $sql_code = "SELECT id, nome FROM usuario";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execuça do código SQL" .$mysqli->error);

        //fazendo login
        $user = $sql_query->fetch_assoc();
        // start da sessao
        session_start();

        //Criado a sessao do USER
        $_SESSION["id"] = $user["id"];
        $_SESSION["nome"] = $user["nome"];

        //redicionando o user
        header("Location: http://localhost/BicoJobs/templates/servicos.php");
    }
}
else{
    $last_id = $sql_query->num_rows;
    if(count($sql_codes) !=3){
        for($i=0 ; $i<count($sql_codes) ; $i++){
            (mysqli_query($mysqli, $sql_codes[$i]));
        }
    
        $sql = "INSERT INTO usuario (id ,nome, cpf, senha, id_cidade, id_contato,tipo_usuario ) VALUES ($last_id ,'$nome', '$cpf', '$pass', $cep, $contato, 0)";
    
        ($mysqli->query($sql));

        $sql_code = "SELECT id, nome FROM usuario WHERE nome = '$nome'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execuça do código SQL" .$mysqli->error);


        //fazendo login
        $user = $sql_query->fetch_assoc();
        // start da sessao
        
        if(!isset($_SESSION)){
            session_start();
        }

        //Criado a sessao do USER
        $_SESSION["id"] = $user["id"];
        $_SESSION["nome"] = $user["nome"];

        //redicionando o user
        header("Location: http://localhost/BicoJobs/templates/servicos.php");
    }
}