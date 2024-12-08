<?php
// Incluir o banco de dados
require_once($_SERVER['DOCUMENT_ROOT'].'/Database.php');

// Obtém a conexão PDO
$db = Database::getInstance();
$pdo = $db->getConnection();

// Define o diretório de origem das imagens
$directory = $_SERVER['DOCUMENT_ROOT'].'/imagens/';

// Consulta para pegar as URLs das imagens
$querySelect = "SELECT id, url_imagem FROM imagens";
$stmt = $pdo->prepare($querySelect);
$stmt->execute();
$imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$imagens) {
    die("Nenhuma imagem encontrada no banco de dados.\n");
}

echo "Verificando imagens...\n";

foreach ($imagens as $imagem) {
    // Caminhos completos para as imagens
    $imagemPath = $directory . basename($imagem['url_imagem']);

    // Verifica se a imagem principal existe no diretório
    if (file_exists($imagemPath)) {
        
        echo "<span style='color: green;'>Imagem encontrada: $imagemPath</span><br>";
    } else {
        
        echo "<span style='color: red;'>Imagem não encontrada: $imagemPath</span><br>";
    }
}


echo "Verificação concluída.\n";
?>
