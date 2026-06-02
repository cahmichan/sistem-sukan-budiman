<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->action, fn ($query, $action) => $query->where('action', $action))
            ->when($request->model_type, fn ($query, $modelType) => $query->where('model_type', $modelType))
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.audit-logs.index', [
            'logs' => $logs,
            'modelTypes' => AuditLog::query()->select('model_type')->distinct()->orderBy('model_type')->pluck('model_type'),
        ]);
    }
}
