<?php

namespace App\Services;

use App\Models\User;

class PanelPermissionService
{
    public function allows(?User $user, ?string $moduleLabel, string $action): bool
    {
        if (! $user || ! $user->can_access_panel) {
            return false;
        }

        if ($user->is_super_admin) {
            return true;
        }

        $role = $user->panelRole;

        if (! $role?->is_active) {
            return false;
        }

        $module = PanelModuleRegistry::keyForLabel($moduleLabel);

        return $module !== null && in_array($action, $role->permissions[$module] ?? [], true);
    }
}
