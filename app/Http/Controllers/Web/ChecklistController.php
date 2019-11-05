<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\ChecklistRequest;
use App\Models\Checklist;
use App\Models\Product;
use Illuminate\Http\Request;

class ChecklistController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        if (isset($params['search'])) {
            $data = (new Checklist)->search($params['search'])->orderBy('date', 'desc')->orderBy('id',
                'desc')->paginate(30);
        } else {
            $data = Checklist::orderBy('date', 'desc')->orderBy('id', 'desc')->paginate();
        }

        return view('pages.checklist.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.checklist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ChecklistRequest $request)
    {
        if (Checklist::create($request->all())) {
            return redirect()
                ->route('web.checklist.index')
                ->with('success', 'Salvo com sucesso');
        }

        return redirect()
            ->route('web.checklist.index')
            ->with('error', 'Erro ao salvar');
    }

    /**
     * Display the specified resource.
     *
     * @param  Checklist  $checklist
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Checklist $checklist)
    {
        $products = Product::productsByChecklist($checklist);

        return view('pages.checklist.show', compact('checklist', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Checklist  $checklist
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklist)
    {
        return view('pages.checklist.edit', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChecklistRequest  $request
     * @param  Checklist  $checklist
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ChecklistRequest $request, Checklist $checklist)
    {
        $checklist->fill($request->all());

        if ($checklist->save()) {
            return redirect()
                ->route('web.checklist.index')
                ->with('success', 'Salvo com sucesso');
        }

        return redirect()
            ->route('web.checklist.index')
            ->with('error', 'Erro ao salvar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Checklist  $checklist
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Checklist $checklist)
    {
        if ($checklist->delete()) {
            return redirect()
                ->route('web.checklist.index')
                ->with('success', 'Deletado com sucesso');
        }

        return redirect()
            ->route('web.checklist.index')
            ->with('error', 'Erro ao deletar');
    }
}
