<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ActivityLogService
{
    public static function log($action, $description, $model = null, $oldData = null, $newData = null)
    {
        try {
            $petugas = auth('petugas')->user();
            $petugasId = $petugas ? $petugas->id : null;
            $modelType = $model ? get_class($model) : null;
            $modelId = $model ? $model->getKey() : null;

            // Handle login/logout specifically
            if (in_array($action, ['login', 'logout'])) {
                $modelType = $petugas ? 'App\\Models\\Petugas' : 'User';
                $modelId = $petugasId;
                $description = $action === 'login' ? 'User logged in' : 'User logged out';
            }

            // Convert model to array if it's an Eloquent model
            if ($model && method_exists($model, 'getAttributes')) {
                $newData = $newData ?? $model->getAttributes();
                
                // For updates, get the original values
                if ($action === 'update' && method_exists($model, 'getOriginal')) {
                    $oldData = $model->getOriginal();
                }
            }

            // Convert to array if it's an object
            $oldData = self::convertToArray($oldData);
            $newData = self::convertToArray($newData);

            // Remove sensitive data
            $sensitiveFields = ['password', 'remember_token', 'api_token', 'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes'];
            $oldData = self::removeSensitiveData($oldData, $sensitiveFields);
            $newData = self::removeSensitiveData($newData, $sensitiveFields);

            // If it's an update and no changes, don't log
            if ($action === 'update' && empty(array_diff_assoc($newData, $oldData))) {
                return null;
            }

            // Get the model name for the description if not set
            if (!$description && $model) {
                $modelName = class_basename($model);
                $modelName = str_replace('_', ' ', Str::snake($modelName));
                $modelName = ucwords($modelName);
                
                $description = sprintf(
                    '%s %s: %s',
                    $modelName,
                    $action === 'create' ? 'created' : ($action === 'update' ? 'updated' : 'deleted'),
                    $model->name ?? $model->title ?? '#' . $modelId
                );
            }

            return ActivityLog::create([
                'petugas_id' => $petugasId,
                'action' => $action,
                'description' => $description,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'old_data' => !empty($oldData) ? $oldData : null,
                'new_data' => !empty($newData) ? $newData : null,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'url' => Request::fullUrl(),
                'method' => Request::method(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log activity: ' . $e->getMessage());
            return null;
        }
    }

    protected static function convertToArray($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                return $data->toArray();
            }
            return (array) $data;
        }

        return $data;
    }

    protected static function removeSensitiveData($data, array $sensitiveFields): array
    {
        if (!is_array($data)) {
            return [];
        }

        foreach ($sensitiveFields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = '******';
            }
        }

        // Recursively check nested arrays
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::removeSensitiveData($value, $sensitiveFields);
            }
        }

        return $data;
    }
}
