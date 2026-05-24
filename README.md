# SaaS de Gestão de Igreja

## Sobre o Projeto
Este é um sistema SaaS completo para gestão de igrejas, construído com Laravel 13, PHP e MySQL. Oferece funcionalidades para administração de membros, eventos, finanças e conteúdo digital.

## Módulos Principais
- **Painel de Administração (Filament v5):** Painel intuitivo para gerenciamento de dados
- **Solicitações de Oração:** Sistema para coleta e acompanhamento de pedidos de oração
- **Contatos e Blog:** Gestão de informações de contato e publicação de artigos
- **Site Público:** Interface para visitantes com funcionalidades de contato e divulgação

## Instalação
1. Clone o repositório
2. Execute `composer install`
3. Configure o arquivo `.env` com as credenciais do MySQL
4. Execute `php artisan key:generate`
5. Rode as migrações com `php artisan migrate`
6. Inicie o servidor com `php artisan serve`

## Requisitos
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js (se necessário para frontend)
- Filament v5

## Como Contribuir
- Siga as diretrizes de estilo de código
- Crie novos módulos conforme necessário
- Mantenha a documentação atualizada

## Licença
O framework Laravel é software de código aberto licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT) por Manoel Dias da Silva Junior (dev.mdsj@gmail.com).
