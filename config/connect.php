<?php
class Conexao {
    
    public $pdo;

    public function __construct() {
        
        $host = '127.0.0.1'; 
        $dbname = 'quiz'; 
        $port = '3307'; 
        $user = 'root';
        $pass = ''; 

        try {
          
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
          
            $this->pdo = new PDO($dsn, $user, $pass);
            
           
           
            
        } catch(PDOException $e) {
            
            die("Falha na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$conexao = new Conexao();


$conn = $conexao->pdo; 

?>