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
        })->with(['profile'])
          // Hanya hitung diagnosis yang diizinkan dibagikan (is_shared = true)
          ->withCount(['diagnoses' => function($q) {
              $q->where('is_shared', true);
          }]);

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

        $students = $query->paginate(10)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function show(User $student)
    {
        // Ensure it's a student
        if ($student->role->name !== 'mahasiswa') {
            abort(404);
        }

        $student->load(['profile']);

        // Hanya tampilkan diagnosis yang diizinkan dibagikan (is_shared = true)
        $diagnoses = Diagnosis::with('burnoutLevel')
            ->where('user_id', $student->id)
            ->where('is_shared', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total diagnosis (termasuk yang private) untuk referensi
        $totalDiagnoses = Diagnosis::where('user_id', $student->id)->count();
        $sharedCount = $diagnoses->count();
        $privateCount = $totalDiagnoses - $sharedCount;

        return view('admin.students.show', compact('student', 'diagnoses', 'totalDiagnoses', 'sharedCount', 'privateCount'));
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
