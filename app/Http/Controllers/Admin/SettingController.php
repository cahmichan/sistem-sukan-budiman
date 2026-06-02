<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\AuditLog;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => Setting::allAsArray(),
        ]);
    }

    public function update(SettingRequest $request)
    {
        $oldValues = Setting::allAsArray();
        $data = $request->validated();
        $data['registration_is_open'] = $request->boolean('registration_is_open') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model_type' => Setting::class,
            'model_id' => null,
            'old_values' => $oldValues,
            'new_values' => Setting::allAsArray(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.settings.edit')->with('success', 'Tetapan sistem berjaya dikemaskini.');
    }
}
