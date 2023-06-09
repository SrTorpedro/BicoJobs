<?php
    namespace Pi\Bicojobs\Model;
    require_once "../autoload.php";
    use PDO;

    class Servico{
        private  int     $id;
        private  int     $id_usuario;
        private  int     $id_categoria;
        private  int     $id_cidade;
        private  string  $nome;
        private  string  $valor;
        private  string  $valor_descricao;
        private  int     $estado;
        private  string  $horario;
        private  string  $img_servico;
        private  string  $contato;
        private  string  $categoria;

        public function __construct($id_cidade,$nome, $valor, $valor_descricao, $estado, $horario, $img_servico, $contato, $categoria, $id_usuario)
        {
            $this -> nome = $nome;
            $this -> valor = $valor;
            $this -> valor_descricao = $valor_descricao;
            $this -> estado = $estado;
            $this -> horario = $horario;
            $this -> img_servico = $img_servico;
            $this -> contato = $contato;
            $this -> categoria = $categoria;
            $this -> id_usuario = $id_usuario;
            $this -> id_cidade = $id_cidade;
        }

        public function getId() : int
        {
            return $this -> id;
        }

        public function getIdUsuario() : int
        {
            return $this->id_usuario;
        }

        public function getId_categoria() : int
        {
            return $this -> id_categoria;
        }

        public function getId_cidade() : int 
        {
            return $this -> id_cidade;
        }

        public function getNome() : string
        {
            return $this -> nome;
        }

        public function getValor() : float
        {
            return $this -> valor;
        }

        public function getValor_Descricao() : string
        {
            return $this -> valor_descricao;
        }

        public function getEstado() : int 
        {
            return $this -> estado;
        }

        public function getHorario() : string
        {
            return $this -> horario;
        }

        public function getImg_servico() : string
        {
            return $this -> img_servico;
        }

        public function getContato() : string
        {
            return $this->contato;
        }

        public function getCategoria($pdo) : string 
        {
            $sql = "SELECT categoria FROM categoria WHERE id =  '$this->categoria'";
            $sql_query = $pdo->query($sql);
            $categoria = ($sql_query->fetch(PDO::FETCH_ASSOC))['categoria'];

            switch($categoria){
                case("Educação"):
                    $categoria = "educacao.svg";
                    break;
                case("Construção"):
                    $categoria = "construtor.svg";
                    break;
                case("Alimentação"):
                    $categoria = "alimentacao.svg";
                    break;
                case("Digital"):
                    $categoria = "Digital.svg";
                    break;
                case("Elétrica"):
                    $categoria = "eletricista.svg";
                    break;
                case("Limpeza"):
                    $categoria = "limpeza.svg";
                    break;
                case("Cuidados"):
                    $categoria = "cuidados.svg";
                    break;
                case("Encanamento"):
                    $categoria = "encanador.svg";
                    break;
                case("Eventos"):
                    $categoria = "eventos.svg";
                    break;
                default:
                    $categoria = "trabalhos_gerais.svg";
                    break;
            }
            return $categoria;
        }

        public function setId($id) : void
        {
            $this -> id = $id;
        }

        public function setIdUsuario(int $id) : void
        {
            $this->id_usuario = $id;
        }

        public function setId_categoria($id_categoria) : void
        {
            $this -> id_categoria = $id_categoria;
        }

        public function setId_cidade($mysqli, $id) : void
        {
            $this -> id_cidade = $id;
            $sql = "UPDATE servico SET id_cidade = '$id' WHERE id = '$this->id'";
            if($mysqli->query($sql) === FALSE){
                echo "Conection Failed!";
            }
        }

        public function setNome($nome) : void
        {
            $this -> nome = $nome;
        }

        public function setValor($valor) : void 
        {
            $this -> nome = $valor;
        }
        
        public function setValor_Descricao($valor_descricao) : void
        {
            $this -> valor_descricao = $valor_descricao;
        }

        public function setEstado($estado) : void
        {
            $this -> estado = $estado;
        }

        public function setHorario($horario) : void
        {
            $this -> horario = $horario;
        }

        public function setImg_servico($img_servico) : void
        {
            $this -> img_servico = $img_servico;
        }

        public function setContato(string $contato) : void
        {
            $this->contato = $contato;
        }

        public function setCategoria(string $categoria){
            $this->categoria = $categoria;
        }

        public function inserirNoDB($pdo) : void
        {
            $sqlConsult = "SELECT * FROM categoria";
            $stmt = $pdo->query($sqlConsult);
            $last_id = $stmt->rowCount();

            $sqlConsult = "SELECT * FROM categoria WHERE categoria = '$this->categoria'";
            $stmt = $pdo->query($sqlConsult);

            if($stmt->rowCount() == 0){
                $sqlInsertCategoria = "INSERT INTO categoria (id, categoria) VALUES ($last_id, '$this->categoria')";
                $sqlInsert = "INSERT INTO servico (id_cidade, nome, valor, descricao, estado, horario, img_servico, id_categoria, contato,id_usuario, serv_status) VALUES ($this->id_cidade, '$this->nome', '$this->valor', '$this->valor_descricao', '$this->estado', '$this->horario', '$this->img_servico', $last_id, '$this->contato' ,$this->id_usuario, 1)";

                $pdo->query($sqlInsertCategoria);
                if($pdo->query($sqlInsert) === FALSE){
                    echo "Failed Insertion!";
                }
            }
            else{
                $id_categoria = ($stmt->fetch(PDO::FETCH_ASSOC))['id'];
                $sqlInsert = "INSERT INTO servico (id_cidade, nome, valor, descricao, estado, horario, img_servico, id_categoria, contato, id_usuario, serv_status) VALUES ($this->id_cidade, '$this->nome', '$this->valor', '$this->valor_descricao', '$this->estado', '$this->horario', '$this->img_servico', $id_categoria, '$this->contato', $this->id_usuario,1)";

                if($pdo->query($sqlInsert) === FALSE){
                    echo "Failed Insertion!";
                }
            }

            $result = $pdo->query("SELECT max(id) FROM servico");
            if($result->rowCount() > 0){
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $id = $row['max(id)'];   
            }

            $this->id = $id;
        }
        
        public function mostrarServicos($pdo, $id, $id_usuario, $nome_cliente, $cidade, $estado, $id_session) : void
        {
            $img_categoria = $this->getCategoria($pdo);
            $caminho = 'http://localhost/BicoJobs/';
            
            if($this->valor == 0.0){
                $this->valor = "A combinar";
            }

            if(str_contains($this->contato, "@") == true){
                $contatar = "mailto:$this->contato?subject=BicoJobs (Solicitação de serviço) & body=Olá, me chamo $nome_cliente sou de $cidade e estou solicitando o seu serviço de $this->nome' class = 'contatar";
            }
            else{
                $contatar =  "https://wa.me/".$this->contato."?text=Olá!%20Me%20chamo%20".$nome_cliente.",%20sou%20de%20".$cidade."%20e%20vim%20diretamente%20do%20BicoJobs%20para%20solicitar%20o%20seu%20serviço%20de%20".$this->nome;
            }
            
            $sqlConsult = "SELECT * FROM usuario WHERE id = $this->id_usuario";
            $stmt = $pdo->query($sqlConsult);
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $id_user = $user['id'];
            $nome_comp_ofertante = $user['nome_comp'];
            $nome_user = $user['nome'];
            $avaliacao = 0;

            $sqlConsult = "SELECT notas FROM notas WHERE id_usuario = '$id_user'";
            $stmt = $pdo->query($sqlConsult);
            $n = 0;
            if($stmt->rowCount() == 0){
                $avaliacao = "Novo";
            }
            else{
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $n += 1;
                    $avaliacao += $row['notas'];
                }
                $avaliacao = $avaliacao/=$n;
                $avaliacao = number_format($avaliacao, 1, ".", "");
            }
            
            if($estado == 0){
                if($id_session == $this->id_usuario){
                    include("../templates/componentes/card_servico_deletar.php");
                }
                else{
                    include("../templates/componentes/card_servico_home.php");
                }
            }
            else if($estado == 1){
                include("../templates/componentes/card_servico_confirma.php");
            }
            else if($estado == 2){
                include("../templates/componentes/card_servico_finalizar.php");
            }
        }

        public function mostrarServicosAvaliar($pdo, $id) : void 
        {
            $caminho = 'http://localhost/BicoJobs/';
            $img_categoria = $this->getCategoria($pdo);
            
            if($this->valor == 0.0){
                $this->valor = "A combinar";
            }
            
            $sqlConsult = "SELECT * FROM usuario WHERE id = $this->id_usuario";
            $stmt = $pdo->query($sqlConsult);
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $id_user = $user['id'];
            $nome_comp_ofertante = $user['nome_comp'];
            $nome_user = $user['nome'];
            $avaliacao = 0;

            $sqlConsult = "SELECT notas FROM notas WHERE id_usuario = '$id_user'";
            $stmt = $pdo->query($sqlConsult);
            $n = 0;
            if($stmt->rowCount() == 0){
                $avaliacao = "Novo";
            }
            else{
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $n += 1;
                    $avaliacao += $row['notas'];
                }
                $avaliacao = $avaliacao/=$n;
                $avaliacao = number_format($avaliacao, 1, ".", "");
            }

            if($this->img_servico == NULL){
                $this->img_servico = "general_work.svg";
            }
            
            include("../templates/componentes/card_servico_avaliar.php");
        }

        public function alterarEstado($pdo, $estado, $contatar,$id,$id_user) : void
        {
            $sqlUpdate = "UPDATE servico SET estado = $estado WHERE id = $id";
            $pdo->query($sqlUpdate);

            if($estado == 1){
                // QUANDO O USUÁRIO SOLICITAR UM SERVIÇO, SERÁ INSERIDO NA TABELA SERVICOAVALIAR PARA, ASSIM QUE CONFIRMADO, O CLIENTE PODER DAR SUA AVALIAÇÃO
                $this->setServicosAvaliar($pdo, $id, $id_user);

                // VERIFICA SE A FORMA DE CONTATI É EMAIL OU TELEFONE PARA EFETUAR O REDIRECIONAMENTO
                if(str_contains($contatar, "@")){
                    echo "<script>open('$contatar', '_blank');</script>";
                }
                else{
                    echo "<script>open('$contatar', '_blank');</script>";
                }
                echo "<script>open('http://localhost/BicoJobs/templates/servicos.php' , '_self');</script>";
            }

            else{
                echo "<script>open('http://localhost/BicoJobs/templates/seus_bicos.php' , '_self');</script>";
            }
        }

        public function setServicosAvaliar($pdo, $id, $id_user){
            $sqlInsert = "INSERT INTO servicoavaliar (id_usuario, id_servico, id_categoria, nome, valor, descricao, horario, img_servico, contato, id_ofertante) VALUES ('$id_user', '$id', '$this->categoria', '$this->nome', '$this->valor', '$this->valor_descricao', '$this->horario', '$this->img_servico', '$this->contato', '$this->id_usuario')";
            $pdo->query($sqlInsert);
        }

        public function deletarServico($pdo, $id, $servico) : void
        {
            $servico -> deletarServicoAvaliacao($pdo, $id);

            $sqlDelete = "DELETE FROM servico WHERE id = $id";
            $pdo -> query($sqlDelete);
            echo "<script>open('http://localhost/BicoJobs/templates/seus_bicos.php' , '_self');</script>";
        }

        public function finalizarServico($pdo, $id, $user_id) : void
        {
            $sqlSelect = "SELECT valor FROM servico WHERE id = $id";
            $valor = (($pdo->query($sqlSelect))->fetch(PDO::FETCH_ASSOC))['valor'];
            $data = date("Y-m-d",strtotime('-3 hour'));

            $sqlInsert = "INSERT INTO servicosfeitos (valor, id_usuario, dt) VALUES ($valor, $user_id, '$data')";
            $pdo->query($sqlInsert);
        }

        public function deletarServicoAvaliacao($pdo, $id) : void
        {
            $sqlDelete = "DELETE FROM servicoavaliar WHERE id = '$id'";
            $pdo -> query($sqlDelete);
        }
    }
