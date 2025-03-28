<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateRequest;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CandidateController extends Controller
{
    //
    
    public function index()
    {
        $candidates = Candidate::all();
        return view('recruit.candidates.index', ['candidates' => $candidates]);
    }

    public function create()
    {
        // $departments = Department::all();
        // $levels = ExperienceLevel::all();
        // $majors = Major::all();
        // $jobTypes = JobType::all();

        // return view('recruit.job.create', [
        //     'departments' => $departments,
        //     'levels' => $levels,
        //     'majors' => $majors,
        //     'jobTypes' => $jobTypes
        // ]);
    }

    public function store(CandidateRequest $request)
    {
        try {
            $data = $request->validated();
            Candidate::create($data);

            Log::info('candidate data', [$data]);

            return redirect()->route('recruit.candidates.index')->with('success', 'Ứng viên đã được thêm thành công!');
        } catch (\Throwable $th) {
            Log::error('create candidate error', [$th->getMessage()]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm ứng viên!');
        }
    }

    public function edit() {}

    public function update(CandidateRequest $request) {}

    public function detroy(string $id) {}

    // ajax

}
