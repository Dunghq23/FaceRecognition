<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostRequest;
use App\Models\Department;
use App\Models\ExperienceLevel;
use App\Models\JobPost;
use App\Models\JobType;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    //
    public function index()
    {
        $jobPosts = JobPost::all();
        return view('recruit.jobs.index', ['jobPosts' => $jobPosts]);
    }

    public function create()
    {
        $departments = Department::all();
        $levels = ExperienceLevel::all();
        $majors = Major::all();
        $jobTypes = JobType::all();

        return view('recruit.job.create', [
            'departments' => $departments,
            'levels' => $levels,
            'majors' => $majors,
            'jobTypes' => $jobTypes
        ]);
    }

    public function store(JobPostRequest $request)
    {
        try {
            $data = $request->validated();
            JobPost::create($data);

            Log::info('job post data', [$data]);

            return redirect()->route('recruit.jobs.index')->with('success', 'Tin tuyển dụng đã được tạo thành công!');
        } catch (\Throwable $th) {
            Log::error('create job post error', [$th->getMessage()]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm tin tuyển dụng!');
        }
    }

    public function edit() {}

    public function update(JobPostRequest $request) {}

    public function detroy(string $id) {}

    // ajax

}
