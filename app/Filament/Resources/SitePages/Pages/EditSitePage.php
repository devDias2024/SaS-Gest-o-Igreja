<?php

namespace App\Filament\Resources\SitePages\Pages;

use App\Filament\Resources\SitePages\Schemas\SitePageForm;
use App\Filament\Resources\SitePages\SitePageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSitePage extends EditRecord
{
    protected static string $resource = SitePageResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return SitePageForm::fillVisualEditorData($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['blocks'] ??= $this->record->blocks ?? [];

        return SitePageForm::mergeVisualEditorData($data);
    }

    protected function afterSave(): void
    {
        if ($this->record->slug === 'home') {
            return;
        }

        $homeBlocks = collect($this->record->blocks ?? [])
            ->filter(fn (array $block): bool => str_starts_with((string) ($block['type'] ?? ''), 'home_'))
            ->values()
            ->all();

        if ($homeBlocks === []) {
            return;
        }

        $home = $this->record->newQuery()->firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'type' => 'landing',
                'status' => 'published',
                'published_at' => now(),
                'show_in_menu' => false,
            ],
        );

        $home->forceFill([
            'type' => 'landing',
            'status' => 'published',
            'published_at' => $home->published_at ?? now(),
            'blocks' => $this->mergeHomeBlocks($home->blocks ?? [], $homeBlocks),
        ])->save();
    }

    private function mergeHomeBlocks(array $currentBlocks, array $newHomeBlocks): array
    {
        foreach ($newHomeBlocks as $newBlock) {
            $type = $newBlock['type'] ?? null;

            if (! $type) {
                continue;
            }

            $updated = false;

            foreach ($currentBlocks as $index => $currentBlock) {
                if (($currentBlock['type'] ?? null) !== $type) {
                    continue;
                }

                $currentBlocks[$index] = $newBlock;
                $updated = true;

                break;
            }

            if (! $updated) {
                $currentBlocks[] = $newBlock;
            }
        }

        return $currentBlocks;
    }
}
