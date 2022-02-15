<?php

    class Usuario {

        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;

        public function getIdusuario() {

            return $this->idusuario;

        }

        public function setIdusuario($value) {

            $this->idusuario = $value;

        }

        public function getDeslogin() {

            return $this->deslogin;

        }

        public function setDeslogin($value) {

            $this->deslogin = $value;

        }

        public function getDessenha() {

            return $this->dessenha;

        }

        public function setDessenha($value) {

            $this->dessenha = $value;

        }

        public function getDtcadastro() {

            return $this->dtcadastro;

        }

        public function setDtcadastro($value) {

            $this->dtcadastro = $value;

        }

        public function __construct($login = "", $password = "") {

            $this->setDeslogin($login);
            $this->setDessenha($password);

        }

        public function loadById($id) {

            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",
                array(
                    ":ID" => $id
                ));

            $row = $results[0];
            //if(count($results > 0))
            if(isset($row)) {

                $this->setData($row);

            }

        }

        public function __toString() {

            return json_encode(array(
                "idusuario: "=>$this->getIdusuario(),
                "deslogin: "=>$this->getDeslogin(),
                "dessenha: "=>$this->getDessenha(),
                "dtcadastro: "=>$this->getDtcadastro()->format("d/m/Y H:i:s")

            ));

        }

        public function getList() {

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

        }

        public static function searchLogin($login) {

            $sql = new Sql();

            return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;",
                array(
                    ":SEARCH"=>"%".$login."%"
                ));

        }

        public function login($login, $password) {

            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD",
                array(
                    ":LOGIN" => $login,
                    ":PASSWORD" => $password
                ));

            $row = $results[0];
            //if(count($row > 0)) {
            if(isset($row)) {

                $this->setData($row);

            } else {

                throw new Exception("Login e/ou senha inválidos");

            }

        }

        public function insert() {

            $sql = new Sql();
            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)",
                array(
                    ":LOGIN" => $this->getDeslogin(),
                    ":PASSWORD" => $this->getDessenha()

                ));
            
            $row = $results[0];
            
            if(isset($row)) {

                $this->setData($row);

            } 

        }

        public function update($login, $password) {

            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();

            $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID",
                array(
                    ":LOGIN" => $this->getDeslogin(),
                    ":PASSWORD" => $this->getDessenha(),
                    ":ID" => $this->getIdusuario()

                ));

        }

        public function setData($rowData) {

            $this->setIdusuario($rowData['idusuario']);
            $this->setDeslogin($rowData['deslogin']);
            $this->setDessenha($rowData['dessenha']);
            $this->setDtcadastro(new DateTime($rowData['dtcadastro']));

        }

    }

?>