<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Get all users who have the role 'mahasiswa'
        $query = User::whereHas('role', function($q) {
            $q->where('name', 'mahasiswa');
        })->with(['profile'])->withCount('diagnoses');

        // Apply filters
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($q2) use ($search) {
                      $q2->where('nim', 'like', "%{$search}%");
                  });
            });
        }

        if ($prodi = $request->input('prodi')) {
            $query->whereHas('profile', function($q) use ($prodi) {
                $q->where('major', $prodi);
            });
        }

        if ($angkatan = $request->input('angkatan')) {
            $query->whereHas('profile', function($q) use ($angkatan) {
                $q->where('semester', $angkatan);
            });
        }

        if ($status = $request->input('status')) {
            if ($status == 'aktif') {
                $query->where('is_active', true);
            } elseif ($status == 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        $students = $query->get();

        return view('admin.students.index', compact('students'));
    }

    public function show(User $student)
    {
        // Ensure it's a student
        if ($student->role->name !== 'mahasiswa') {
            abort(404);
        }

        $student->load(['profile']);
        $diagnoses = Diagnosis::with('burnoutLevel')->where('user_id', $student->id)->orderBy('created_at', 'desc')->get();

        return view('admin.students.show', compact('student', 'diagnoses'));
    }

    public function destroy(User $student)
    {
        // Ensure it's a student
        if ($student->role->name !== 'mahasiswa') {
            abort(403, 'Unauthorized action.');
        }

        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
