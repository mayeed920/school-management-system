<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyClasessRequest;
use App\Http\Requests\StoreClasessRequest;
use App\Http\Requests\UpdateClasessRequest;
use App\Models\Clasess;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClasessController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('clasess_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Clasess::query()->select(sprintf('%s.*', (new Clasess())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'clasess_show';
                $editGate = 'clasess_edit';
                $deleteGate = 'clasess_delete';
                $crudRoutePart = 'clasesses';

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
            $table->editColumn('class_name', function ($row) {
                return $row->class_name ? $row->class_name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.clasesses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('clasess_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clasesses.create');
    }

    public function store(StoreClasessRequest $request)
    {
        $clasess = Clasess::create($request->all());

        return redirect()->route('admin.clasesses.index');
    }

    public function edit(Clasess $clasess)
    {
        abort_if(Gate::denies('clasess_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clasesses.edit', compact('clasess'));
    }

    public function update(UpdateClasessRequest $request, Clasess $clasess)
    {
        $clasess->update($request->all());

        return redirect()->route('admin.clasesses.index');
    }

    public function show(Clasess $clasess)
    {
        abort_if(Gate::denies('clasess_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clasesses.show', compact('clasess'));
    }

    public function destroy(Clasess $clasess)
    {
        abort_if(Gate::denies('clasess_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clasess->delete();

        return back();
    }

    public function massDestroy(MassDestroyClasessRequest $request)
    {
        Clasess::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
