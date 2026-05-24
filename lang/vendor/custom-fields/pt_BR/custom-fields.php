<?php

$translations = require base_path('vendor/relaticle/custom-fields/resources/lang/en/custom-fields.php');

return array_replace_recursive($translations, [
    'heading' => [
        'title' => 'Campos personalizados',
        'description' => 'Crie campos extras para complementar os cadastros do sistema.',
    ],

    'nav' => [
        'label' => 'Campos personalizados',
        'group' => 'Configuracoes',
        'icon' => 'heroicon-o-adjustments-horizontal',
    ],

    'section' => [
        'form' => [
            'name' => 'Nome',
            'code' => 'Codigo',
            'type' => 'Tipo',
            'description' => 'Descricao',
            'add_section' => 'Adicionar secao',
        ],
        'default' => [
            'new_section' => 'Nova secao',
        ],
        'default_section_name' => 'Padrao',
    ],

    'field' => [
        'form' => [
            'general' => 'Geral',
            'entity_type' => 'Cadastro',
            'type' => 'Tipo',
            'name' => 'Nome',
            'code' => 'Codigo',
            'settings' => 'Configuracoes',
            'encrypted' => 'Criptografado',
            'searchable' => 'Pesquisavel',
            'visible_in_list' => 'Exibir na lista',
            'list_toggleable_hidden' => 'Oculto inicialmente',
            'visible_in_view' => 'Exibir na visualizacao',
            'visibility_settings' => 'Visibilidade',
            'data_settings' => 'Tratamento de dados',
            'appearance_settings' => 'Aparencia',
            'add_field' => 'Adicionar campo',
            'search_placeholder' => 'Pesquisar campos...',
        ],
        'actions' => [
            'activate' => 'Ativar',
            'deactivate' => 'Desativar',
        ],
    ],

    'empty_states' => [
        'sections' => [
            'heading' => 'Pronto para comecar?',
            'description' => 'Crie uma secao para organizar seus campos personalizados.',
        ],
        'fields' => [
            'heading' => 'Esta secao esta vazia',
            'description' => 'Adicione o primeiro campo desta secao.',
        ],
        'fields_no_sections' => [
            'heading' => 'Nenhum campo personalizado',
            'description' => 'Adicione seu primeiro campo personalizado.',
        ],
        'search_no_results' => [
            'heading' => 'Nenhum campo encontrado',
            'description' => 'Nenhum campo corresponde a pesquisa.',
        ],
    ],

    'common' => [
        'inactive' => 'Inativo',
        'active_fields' => 'Campos ativos',
        'inactive_fields' => 'Campos inativos',
        'required' => 'Obrigatorio',
        'archived' => 'Arquivado',
    ],
]);
