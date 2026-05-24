<x-filament-widgets::widget class="church-member-highlights">
    <x-filament::section>
        <style>
            .church-member-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1.5rem;
            }

            .church-member-panel + .church-member-panel {
                border-left: 1px solid rgba(148, 163, 184, .18);
                padding-left: 1.5rem;
            }

            .church-member-heading {
                color: inherit;
                font-size: 1rem;
                font-weight: 600;
                margin: 0 0 .9rem;
            }

            .church-member-table {
                border-collapse: collapse;
                font-size: .875rem;
                width: 100%;
            }

            .church-member-table th {
                border-bottom: 1px solid rgba(148, 163, 184, .18);
                color: rgba(148, 163, 184, .95);
                font-size: .72rem;
                font-weight: 600;
                padding: 0 0 .55rem;
                text-align: left;
                text-transform: uppercase;
            }

            .church-member-table td {
                border-bottom: 1px solid rgba(148, 163, 184, .12);
                padding: .68rem 0;
            }

            .church-member-date {
                color: rgba(148, 163, 184, .95);
                width: 5.5rem;
            }

            .church-member-empty {
                color: rgba(148, 163, 184, .95);
                margin: 1.25rem 0 .25rem;
                text-align: center;
            }

            @media (max-width: 760px) {
                .church-member-grid {
                    grid-template-columns: minmax(0, 1fr);
                }

                .church-member-panel + .church-member-panel {
                    border-left: 0;
                    border-top: 1px solid rgba(148, 163, 184, .18);
                    padding-left: 0;
                    padding-top: 1.25rem;
                }
            }
        </style>

        <div class="church-member-grid">
            <section class="church-member-panel" aria-label="Aniversariantes de hoje">
                <h2 class="church-member-heading">Aniversariantes de hoje</h2>

                <table class="church-member-table">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($birthdaysToday as $member)
                            <tr>
                                <td class="church-member-date">{{ $member->birth_date->format('d/m') }}</td>
                                <td>{{ $member->preferred_name ?: $member->full_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <p class="church-member-empty">Nenhum aniversariante hoje</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <section class="church-member-panel" aria-label="Proximos aniversarios">
                <h2 class="church-member-heading">Proximos aniversarios</h2>

                <table class="church-member-table">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($upcomingBirthdays as $birthday)
                            <tr>
                                <td class="church-member-date">{{ $birthday['date']->format('d/m') }}</td>
                                <td>{{ $birthday['member']->preferred_name ?: $birthday['member']->full_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <p class="church-member-empty">Nenhum aniversario nos proximos dias</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
