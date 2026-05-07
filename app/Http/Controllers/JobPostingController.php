<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobPostingController extends Controller
{
    public function DisplayJob(Request $req)
        {
            $jobs = Job::all();
            return view('displayJob', compact('jobs'));
        }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id'       => ['required', 'integer', 'exists:jobs,id'],
            'first_name'   => ['required', 'string', 'max:100'],
            'last_name'    => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'address'      => ['nullable', 'string', 'max:255'],
            'cover_letter' => ['required', 'string', 'max:5000'],
            'resume'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5 MB
        ]);
 
        $job = Job::findOrFail($validated['job_id']);
        if (\Carbon\Carbon::parse($job->enddate)->lt(\Carbon\Carbon::today())) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this position is no longer accepting applications.',
            ], 422);
        }

        $file          = $request->file('resume');
        $originalName  = $file->getClientOriginalName();
        $storedPath    = $file->store("resumes/{$validated['job_id']}", 'public');
 
        JobApplication::create([
            'job_id'               => $validated['job_id'],
            'first_name'           => $validated['first_name'],
            'last_name'            => $validated['last_name'],
            'email'                => $validated['email'],
            'phone'                => $validated['phone'] ?? null,
            'address'              => $validated['address'] ?? null,
            'cover_letter'         => $validated['cover_letter'],
            'resume_path'          => $storedPath,
            'resume_original_name' => $originalName,
        ]);
 
        // 5. Return JSON success (blade fetches this via JS)
        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
        ]);
    }
    public function showFile($path)
{
    if (!Storage::disk('public')->exists($path)) {
        return response()->json([
            'message' => 'File not found'
        ], 404);
    }

    return response()->download(
        storage_path('app/public/' . $path)
    );
}
}
