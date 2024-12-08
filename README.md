
# Conversor em Massa de Imagens para WebP

Este projeto é uma solução em PHP para converter imagens de um banco de dados em massa para o formato WebP, otimizando o desempenho da web ao reduzir o tamanho das imagens. É voltado para desenvolvedores que precisam migrar imagens de forma eficiente para este formato moderno.

## Funcionalidades

- Conversão de imagens no banco de dados para o formato WebP.
- Controle da qualidade das imagens convertidas.
- Operação baseada em diretórios e integração com banco de dados.

## Requisitos

- PHP 7.4 ou superior.
- Banco de dados (compatível com PDO, como MySQL).
- Extensões GD habilitadas no PHP.
- Ambiente local para execução.

## Como Usar

1. **Clone o projeto**:

   ```bash
 git clone https://github.com/luis-marcelo-fonseca/webpphp.git
 cd webpphp
   ```

2. **Configure o banco de dados**:

   No arquivo `Database.php`, atualize as credenciais do banco de dados:

   ```php
   private string $host = 'localhost';
   private string $db_name = 'nome_do_banco';
   private string $username = 'usuario';
   private string $password = 'senha';
   ```

3. **Ajuste o diretório de origem das imagens**:

   No arquivo `webp.php`, defina o caminho correto para o diretório onde as imagens estão armazenadas:

   ```php
   $directory = $_SERVER['DOCUMENT_ROOT'].'/caminho_para_suas_imagens/';
   ```

4. **Execute o script**:

   Certifique-se de que está executando no localhost para evitar problemas de performance em produção:

   ```bash
   php webp.php
   ```

## Recomendações e Precauções

- **Faça backup**: Antes de executar o script, crie backups do banco de dados e das imagens originais.
- **Aumente o limite de execução do PHP**: Este script pode ser demorado dependendo do número de imagens. No seu arquivo `php.ini`, ajuste o valor de `max_execution_time`:

   ```ini
   max_execution_time = 999999999
   ```

- **Ambiente local**: Recomendamos executar este script em um servidor local para evitar interrupções devido a limites de tempo ou conexão.

## Estrutura do Código

- `webp.php`: Contém a lógica para a conversão de imagens em massa.
- `Database.php`: Classe para gerenciar a conexão com o banco de dados.
- `teste.php`: Script para testar a integração entre a conversão e o banco de dados.

## Contribuição

Sinta-se à vontade para contribuir com melhorias, sugestões ou reportar problemas. Basta abrir uma *issue* ou enviar um *pull request* no repositório.

---

**Nota:** Este projeto é distribuído como está, sem garantia de funcionamento para casos específicos. Use por sua conta e risco.
