<?php

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logAudit')) {
    function logAudit($action, $tableName, $recordId = null, $oldData = [], $newData = [])
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
        ]);
    }
}
