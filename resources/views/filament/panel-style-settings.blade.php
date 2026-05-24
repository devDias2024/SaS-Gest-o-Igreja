<style>
    @if ($settings->visual_style === 'compact')
        .fi-main { --spacing: .21rem; }
        .fi-ta-row, .fi-section-content { font-size: .875rem; }
        .fi-sidebar-item-btn { min-height: 2.15rem; }
    @elseif ($settings->visual_style === 'soft')
        .fi-main-ctn { border-radius: 0 !important; }
        .fi-ta, .fi-sc-section, .fi-tabs { border-color: transparent !important; padding: 0 !important; }
        .fi-section, .fi-ta-ctn { border-color: transparent !important; box-shadow: 0 1px 3px rgb(15 23 42 / .08) !important; }
        .fi-sidebar-item.fi-active .fi-sidebar-item-btn { border-radius: .5rem !important; }
    @endif
</style>
