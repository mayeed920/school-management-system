<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Clasess;
use App\Models\Country;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Student::with(['class_iid', 'country_code'])->select(sprintf('%s.*', (new Student())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'student_show';
                $editGate = 'student_edit';
                $deleteGate = 'student_delete';
                $crudRoutePart = 'students';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('class_iid_class_name', function ($row) {
                return $row->class_iid ? $row->class_iid->class_name : '';
            });

            $table->addColumn('country_code_name', function ($row) {
                return $row->country_code ? $row->country_code->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'class_iid', 'country_code']);

            return $table->make(true);
        }

        return view('admin.students.index');
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $class_iids = Clasess::pluck('class_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $country_codes = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.students.create', compact('class_iids', 'country_codes'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());

        return redirect()->route('admin.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $class_iids = Clasess::pluck('class_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $country_codes = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $student->load('class_iid', 'country_code');

        return view('admin.students.edit', compact('class_iids', 'country_codes', 'student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return redirect()->route('admin.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('class_iid', 'country_code');

        return view('admin.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        Student::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
