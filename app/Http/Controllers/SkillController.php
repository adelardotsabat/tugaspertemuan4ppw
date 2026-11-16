<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('skills', 'name')->ignore($skill->id),   // boleh simpan nama yang sama dengan dirinya sendiri
            ],
        ]);

        $skill->update($validated);

        return redirect()->route('dashboard')
                         ->with('success', 'Skill berhasil diperbarui.');
    }
}
