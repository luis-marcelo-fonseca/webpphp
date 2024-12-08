<?php
// Incluir o banco de dados
require_once($_SERVER['DOCUMENT_ROOT'].'/Database.php');

// Obtém a conexão PDO
$db = Database::getInstance();
$pdo = $db->getConnection();

// Define o diretório de origem das imagens
$directory = $_SERVER['DOCUMENT_ROOT'].'/imagens/';
$quality = 100; // Qualidade do WEBP

// Função para converter uma imagem para WEBP
function convertToWebP($filePath, $quality) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Formato não suportado: $filePath\n";
        return false;
    }

    $outputFile = preg_replace('/\.\w+$/i', '.webp', $filePath);

    if (file_exists($outputFile)) {
        echo "Arquivo WEBP já existe, conversão ignorada: $outputFile\n";
        return true;
    }

    try {
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $image = imagecreatefrompng($filePath);
                break;
            case 'gif':
                $image = imagecreatefromgif($filePath);
                break;
            default:
                echo "Formato não suportado para conversão: $filePath\n";
                return false;
        }

        imagewebp($image, $outputFile, $quality);
        imagedestroy($image);

        echo "Convertido com sucesso: $filePath -> $outputFile\n";
        unlink($filePath);  // Deleta o arquivo original
        return true;
    } catch (Exception $e) {
        echo "Erro ao converter $filePath para WEBP: " . $e->getMessage() . "\n";
        return false;
    }
}

// Lê todos os arquivos de imagem no diretório
$files = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if (empty($files)) {
    echo "Nenhuma imagem encontrada no diretório especificado: $directory\n";
    return false;
}

foreach ($files as $file) {
    try {
        convertToWebP($file, $quality);
    } catch (Exception $e) {
        echo "Erro inesperado ao processar $file: " . $e->getMessage() . "\n";
        return false;
    }
}

// Atualizar URLs no banco de dados
$queryUpdate = "
    UPDATE imagens
    SET 
        url_imagem = REGEXP_REPLACE(url_imagem, '\\.(jpg|jpeg|png|gif)$', '.webp')
    WHERE 
        url_imagem REGEXP '\\.(jpg|jpeg|png|gif)$'
";


$stmtUpdate = $pdo->prepare($queryUpdate);
$stmtUpdate->execute();

// Verifica se as atualizações foram feitas com sucesso
if ($stmtUpdate->rowCount() > 0) {
    echo "Todas as URLs foram atualizadas com sucesso!\n";
} else {
    echo "Nenhuma URL foi atualizada.\n";
}
?>
