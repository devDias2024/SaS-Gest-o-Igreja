<?php

namespace App\Services;

class PanelModuleRegistry
{
    public const SETTINGS_LABEL = 'Configuracao do Sistema';

    public static function modules(): array
    {
        return [
            'gestao_membros' => 'Gestao de Membros',
            'api_webhooks' => 'API & Webhooks',
            'patrimonio_estoque' => 'Patrimonio & Estoque',
            'criancas_seguranca' => 'Criancas & Seguranca',
            'eventos_cultos' => 'Eventos & Cultos',
            'comunicacao' => 'Comunicacao',
            'refeitorio_despensa' => 'Refeitorio & Despensa',
            'financeiro' => 'Financeiro',
            'ministerios_celulas' => 'Ministerios & Celulas',
            'aconselhamento_pastoral' => 'Aconselhamento Pastoral',
            'formularios_registros' => 'Formularios & Registros',
            'biblioteca_cultos' => 'Biblioteca de Cultos',
            'site_publico' => 'Site Publico',
            'escola_dominical' => 'Escola Dominical',
            'configuracao_sistema' => self::SETTINGS_LABEL,
        ];
    }

    public static function keyForLabel(?string $label): ?string
    {
        return array_search($label, self::modules(), true) ?: null;
    }

    public static function actions(): array
    {
        return [
            'view' => 'Visualizar',
            'create' => 'Criar',
            'update' => 'Editar',
            'delete' => 'Excluir',
        ];
    }
}
