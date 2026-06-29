<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Arr;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->logActivity('create', null, $model->getAuditAttributes($model->getAttributes()));
        });

        static::updated(function ($model) {
            $dirty = $model->getDirty();
            if (empty($dirty)) {
                return;
            }

            $oldValues = [];
            $newValues = [];

            foreach ($dirty as $key => $value) {
                $oldValues[$key] = $model->getOriginal($key);
                $newValues[$key] = $value;
            }

            $model->logActivity(
                'update',
                $model->getAuditAttributes($oldValues),
                $model->getAuditAttributes($newValues)
            );
        });

        static::deleted(function ($model) {
            $model->logActivity('delete', $model->getAuditAttributes($model->getAttributes()), null);
        });
    }

    protected function logActivity(string $activity, ?array $oldValues, ?array $newValues): void
    {
        $user = auth()->user();
        $modelName = class_basename($this);
        $displayName = $this->name ?? $this->nama ?? $this->tahun ?? $this->id;

        // Custom description based on activity
        $description = '';
        switch ($activity) {
            case 'create':
                $description = "Menambahkan {$modelName} baru: '{$displayName}'";
                break;
            case 'update':
                $fields = array_keys($newValues ?? []);
                $fieldList = implode(', ', $fields);
                $description = "Mengubah data {$modelName} '{$displayName}' pada kolom: {$fieldList}";
                break;
            case 'delete':
                $description = "Menghapus data {$modelName}: '{$displayName}'";
                break;
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'activity' => $activity,
            'description' => $description,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected function getAuditAttributes(array $attributes): array
    {
        // Exclude sensitive columns
        $ignore = ['password', 'remember_token', 'created_at', 'updated_at'];

        return Arr::except($attributes, $ignore);
    }
}
