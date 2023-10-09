<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\FormEleven;
use App\Models\FormFive;
use App\Models\FormUpload;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FormUploadController extends Controller
{
    public function allFiveOne(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormFive/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_FIVE_ONE)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allFiveTwo(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormFiveTwo/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_FIVE_TWO)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allSix(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormSix/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_SIX)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allSeven(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormSeven/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_SEVEN)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allEight(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormEight/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_EIGHT)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allNine(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormNine/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_NINE)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allTen(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormTen/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_TEN)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }
    public function allEleven(Request $request)
    {
        $filter = $request->get('departments') ?? [];
        return inertia('Backend/FormEleven/Admin', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_ELEVEN)
                ->when($filter, fn(Builder $builder) => $builder->whereIn('department_id', $filter))
                ->simplePaginate(),
            'departments' => Department::query()->get(['id as value', 'name as label']),
            'filter' => Department::query()->whereIn('id', $filter)->get(['id as value', 'name as label'])
        ]);
    }

    public function fiveOne(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormFive/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_FIVE_ONE)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }

    public function fiveTwo(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormFiveTwo/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_FIVE_TWO)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }

    public function six(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormSix/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_SIX)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }
    public function seven(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormSeven/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_SEVEN)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }
    public function eight(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormEight/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_EIGHT)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }
    public function nine(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormNine/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_NINE)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }
    public function ten(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormTen/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_TEN)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }
    public function eleven(Request $request)
    {
        $user = auth()->user();
        $departments = $user->departments()->pluck('departments.id');
        return inertia('Backend/FormEleven/Index', [
            'list' => FormUpload::query()->with(['user', 'department'])
                ->where('name', FormUpload::FORM_ELEVEN)
                ->whereHas('department', fn(Builder $builder) => $builder->whereIn('id', $departments))
                ->get()
        ]);
    }


    public function createFiveOne(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormFive/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createFiveTwo(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormFiveTwo/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createSix(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormSix/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createSeven(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormSeven/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createEight(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormEight/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createNine(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormNine/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createTen(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormTen/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function createEleven(Request $request)
    {
        $user = auth()->user();
        return inertia('Backend/FormEleven/Create', [
            'list' => FormUpload::query()->get(),
            'departments' => $user->departments()->get(['departments.id as value', 'departments.name as label'])
        ]);
    }

    public function store(Request $request, string $name)
    {
        $this->validate($request, [
            'attachment' => ['required', Rule::file()],
            'department_id' => ['required', Rule::exists('departments', 'id')]
        ]);
        $file = $request->file('attachment');
        $path = Storage::disk('public')->put($name, $file);
        $data = FormUpload::query()->create([
            'name' => $name,
            'user_id' => auth()->id(),
            'department_id' => $request->get('department_id'),
            'remark' => $request->get('remark'),
            'path' => $path
        ]);
        session()->flash('notification', [
            'type' => 'positive',
            'message' => 'Form  uploaded successfully'
        ]);

        return match ($name) {
            FormUpload::FORM_FIVE_ONE => to_route('form-upload-five-one.index'),
            FormUpload::FORM_FIVE_TWO => to_route('form-upload-five-two.index'),
            FormUpload::FORM_SIX => to_route('form-upload-six.index'),
            FormUpload::FORM_SEVEN => to_route('form-upload-seven.index'),
            FormUpload::FORM_EIGHT => to_route('form-upload-eight.index'),
            FormUpload::FORM_NINE => to_route('form-upload-nine.index'),
            FormUpload::FORM_TEN => to_route('form-upload-ten.index'),
            FormUpload::FORM_ELEVEN => to_route('form-upload-eleven.index'),
            default => back(),
        };
    }

    public function destroy(Request $request, FormFive $form)
    {
        $deleted = Storage::disk('public')->delete($form->path);
        if ($deleted) {
            $form->delete();
        }
        session()->flash('notification', [
            'type' => 'positive',
            'message' => 'Form upload deleted successfully'
        ]);
        return to_route('form-upload.index', ['name' => $form->name]);
    }
}
