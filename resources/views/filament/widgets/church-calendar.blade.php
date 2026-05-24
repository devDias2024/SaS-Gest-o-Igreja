<x-filament-widgets::widget class="church-calendar">
    <x-filament::section>
        <style>
            .church-calendar-header {
                align-items: center;
                display: flex;
                gap: .65rem;
                justify-content: space-between;
                margin-bottom: 1rem;
            }

            .church-calendar-title {
                font-size: 1rem;
                font-weight: 600;
                margin: 0;
            }

            .church-calendar-controls {
                align-items: center;
                display: flex;
                gap: .45rem;
            }

            .church-calendar-button,
            .church-calendar-add {
                align-items: center;
                border: 1px solid rgba(148, 163, 184, .24);
                border-radius: .45rem;
                color: inherit;
                display: inline-flex;
                font-size: .85rem;
                font-weight: 500;
                gap: .35rem;
                height: 2.15rem;
                justify-content: center;
                padding: 0 .72rem;
                transition: background-color .15s ease, border-color .15s ease;
            }

            .church-calendar-button {
                background: transparent;
                cursor: pointer;
                min-width: 2.15rem;
            }

            .church-calendar-button:hover {
                background: rgba(148, 163, 184, .12);
            }

            .church-calendar-add {
                background: rgb(245, 158, 11);
                border-color: rgb(245, 158, 11);
                color: rgb(17, 24, 39);
                text-decoration: none;
            }

            .church-calendar-month {
                font-size: .92rem;
                font-weight: 600;
                min-width: 8.6rem;
                text-align: center;
            }

            .church-calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }

            .church-calendar-weekday {
                color: rgba(148, 163, 184, .95);
                font-size: .72rem;
                font-weight: 600;
                padding: .2rem .45rem .65rem;
                text-align: center;
                text-transform: uppercase;
            }

            .church-calendar-day {
                border: 1px solid rgba(148, 163, 184, .13);
                min-height: 6.3rem;
                overflow: hidden;
                padding: .42rem;
                transition: background-color .15s ease, border-color .15s ease;
            }

            .church-calendar-day:nth-child(n + 8) {
                margin-left: -1px;
                margin-top: -1px;
            }

            .church-calendar-drop-target {
                background: rgba(245, 158, 11, .08);
                border-color: rgba(245, 158, 11, .72);
            }

            .church-calendar-muted {
                opacity: .4;
            }

            .church-calendar-day-number {
                align-items: center;
                display: flex;
                font-size: .78rem;
                height: 1.45rem;
                justify-content: center;
                margin-left: auto;
                width: 1.45rem;
            }

            .church-calendar-today .church-calendar-day-number {
                background: rgb(245, 158, 11);
                border-radius: 50%;
                color: rgb(17, 24, 39);
                font-weight: 700;
            }

            .church-calendar-event {
                background: rgba(245, 158, 11, .16);
                border-left: 2px solid rgb(245, 158, 11);
                border-radius: .22rem;
                color: inherit;
                display: block;
                font-size: .72rem;
                line-height: 1.25;
                margin-top: .27rem;
                overflow: hidden;
                padding: .22rem .28rem;
                text-decoration: none;
                text-overflow: ellipsis;
                cursor: grab;
                white-space: nowrap;
            }

            .church-calendar-event:hover {
                background: rgba(245, 158, 11, .27);
            }

            .church-calendar-event:active {
                cursor: grabbing;
            }

            .church-calendar-dragging {
                opacity: .4;
            }

            .church-calendar-more {
                color: rgba(148, 163, 184, .95);
                font-size: .7rem;
                margin: .27rem 0 0 .2rem;
            }

            @media (max-width: 760px) {
                .church-calendar-header {
                    align-items: stretch;
                    flex-direction: column;
                }

                .church-calendar-controls {
                    justify-content: space-between;
                }

                .church-calendar-day {
                    min-height: 4.4rem;
                    padding: .25rem;
                }

                .church-calendar-event {
                    font-size: 0;
                    height: .38rem;
                    padding: 0;
                }
            }
        </style>

        <header class="church-calendar-header">
            <h2 class="church-calendar-title">Agenda</h2>

            <div class="church-calendar-controls">
                <button class="church-calendar-button" type="button" wire:click="previousMonth" title="Mes anterior" aria-label="Mes anterior">
                    <x-filament::icon icon="heroicon-m-chevron-left" style="width: 1rem; height: 1rem;" />
                </button>
                <button class="church-calendar-button" type="button" wire:click="goToCurrentMonth">Hoje</button>
                <span class="church-calendar-month">{{ $monthLabel }}</span>
                <button class="church-calendar-button" type="button" wire:click="nextMonth" title="Proximo mes" aria-label="Proximo mes">
                    <x-filament::icon icon="heroicon-m-chevron-right" style="width: 1rem; height: 1rem;" />
                </button>
                <a class="church-calendar-add" href="{{ $createEventUrl }}">
                    <x-filament::icon icon="heroicon-m-plus" style="width: 1rem; height: 1rem;" />
                    Adicionar
                </a>
            </div>
        </header>

        <div
            class="church-calendar-grid"
            x-data="{ draggingEvent: null, dropTarget: null }"
            @dragend.window="draggingEvent = null; dropTarget = null"
        >
            @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'] as $weekday)
                <div class="church-calendar-weekday">{{ $weekday }}</div>
            @endforeach

            @foreach ($days as $day)
                <div @class([
                    'church-calendar-day',
                    'church-calendar-muted' => ! $day['inMonth'],
                    'church-calendar-today' => $day['isToday'],
                ])
                    :class="{ 'church-calendar-drop-target': dropTarget === '{{ $day['date']->format('Y-m-d') }}' }"
                    @dragenter.prevent="dropTarget = '{{ $day['date']->format('Y-m-d') }}'"
                    @dragover.prevent="dropTarget = '{{ $day['date']->format('Y-m-d') }}'"
                    @drop.prevent="
                        const eventId = $event.dataTransfer.getData('text/plain');
                        dropTarget = null;
                        draggingEvent = null;
                        if (eventId) {
                            $wire.moveEvent(Number(eventId), '{{ $day['date']->format('Y-m-d') }}');
                        }
                    "
                >
                    <span class="church-calendar-day-number">{{ $day['date']->day }}</span>

                    @foreach ($day['events']->take(2) as $event)
                        <a
                            class="church-calendar-event"
                            :class="{ 'church-calendar-dragging': draggingEvent === {{ $event->id }} }"
                            draggable="true"
                            href="{{ $event->edit_url }}"
                            title="Clique para editar ou arraste para reagendar: {{ $event->title }}"
                            @dragstart="
                                draggingEvent = {{ $event->id }};
                                $event.dataTransfer.effectAllowed = 'move';
                                $event.dataTransfer.setData('text/plain', '{{ $event->id }}');
                            "
                        >
                            {{ $event->starts_at->format('H:i') }} {{ $event->title }}
                        </a>
                    @endforeach

                    @if ($day['events']->count() > 2)
                        <p class="church-calendar-more">+ {{ $day['events']->count() - 2 }} eventos</p>
                    @endif
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
