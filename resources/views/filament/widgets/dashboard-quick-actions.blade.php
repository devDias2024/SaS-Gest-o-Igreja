<x-filament-widgets::widget class="dashboard-quick-actions">
    <x-filament::section>
        <style>
            .dashboard-command-list {
                display: flex;
                flex-wrap: wrap;
                gap: .65rem;
            }

            .dashboard-command {
                align-items: center;
                border: 1px solid rgba(148, 163, 184, .23);
                border-radius: .45rem;
                color: inherit;
                display: inline-flex;
                font-size: .9rem;
                font-weight: 600;
                gap: .5rem;
                height: 2.7rem;
                padding: 0 .95rem;
                text-decoration: none;
                transition: background-color .15s ease, border-color .15s ease, color .15s ease;
            }

            .dashboard-command:hover {
                background: rgba(245, 158, 11, .11);
                border-color: rgba(245, 158, 11, .6);
                color: rgb(245, 158, 11);
            }
        </style>

        <div class="dashboard-command-list">
            @foreach ($actions as $action)
                <a href="{{ $action['url'] }}" class="dashboard-command">
                    <x-filament::icon :icon="$action['icon']" style="width: 1.08rem; height: 1.08rem;" />
                    <span>{{ $action['label'] }}</span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
