<?php

namespace App\Http\Controllers\Web\Acl;

use App\Models\Acl\AclRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AclRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = AclRole::paginate();

        return view('pages.acl.role.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.acl.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (AclRole::create($request->all())) {
            return redirect()
                ->route('web.acl.role.index')
                ->with('success', 'Salvo com sucesso');
        }

        return redirect()
            ->route('web.acl.role.index')
            ->with('error', 'Erro ao salvar');
    }

    /**
     * Display the specified resource.
     *
     * @param  AclRole  $aclRole
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(AclRole $aclRole)
    {
        return view('pages.acl.role.show', compact('aclRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AclRole  $aclRole
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AclRole $aclRole)
    {
        return view('pages.acl.role.edit', compact('aclRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  AclRole  $aclRole
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AclRole $aclRole)
    {
        $aclRole->fill($request->all());

        if ($aclRole->save()) {
            return redirect()
                ->route('web.acl.role.index')
                ->with('success', 'Salvo com sucesso');
        }

        return redirect()
            ->route('web.acl.role.index')
            ->with('error', 'Erro ao salvar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AclRole  $aclRole
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(AclRole $aclRole)
    {
        if ($aclRole->delete()) {
            return redirect()
                ->route('web.acl.role.index')
                ->with('success', 'Deletado com sucesso');
        }

        return redirect()
            ->route('web.acl.role.index')
            ->with('error', 'Erro ao deletar');
    }
}
