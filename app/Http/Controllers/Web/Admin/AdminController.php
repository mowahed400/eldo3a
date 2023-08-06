<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Contracts\AdminContract;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;

class AdminController extends Controller
{
    /**
     * @var AdminContract
     */
    protected AdminContract $admin;

    /**
     * @param AdminContract $admin
     */
    public function __construct(AdminContract $admin)
    {
        $this->admin = $admin;


        //$this->middleware(['permission:view-admin'])->only(['index','show']);

        //$this->middleware(['permission:edit-admin'])->only(['edit', 'update']);
        $this->middleware(['permission:create-admin'])->only(['create', 'store']);
        $this->middleware(['permission:delete-admin'])->only(['destroy']);
    }


    public function index(Request $request)
    {
        $admins = $this->admin->setPerPage($request->input('per_page'))->setRelations(['roles'])->findByFilter();
        if ($request->wantsJson())
        {
            return response()->json(compact('admins'));
        }
        $roles = Role::all();

        return view('admin.admins.index',compact('admins', 'roles'));
    }

    /**
     * @return Renderable
     */
    public function create() : Renderable
    {
        return view('admin.admins.create');
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function edit($id): Renderable
    {
        $admin = $this->admin->setRelations(['roles'])->findOneById($id);
        return view('admin.admins.edit',compact('admin'));
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function editPassword($id): Renderable
    {
        $admin = $this->admin->findOneById($id);
        return view('admin.admins.edit-password',compact('admin'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:admins,email',
            'password'  => 'required|string|min:8|max:24|confirmed',
            'roles'  => 'required|array',
            'roles.*'  => 'required|integer',
            'image'       => 'sometimes|nullable|file|image|max:3000',
        ]);

        $this->admin->new($data);

        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.admins.index');
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function show($id): Renderable
    {
        $admin = $this->admin->setRelations(['roles'])->findOneById($id);
        $roles = Role::all();

        return view('admin.admins.show',compact('admin','roles'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword($id,Request $request): RedirectResponse
    {
        $data = $request->validate([
            'password' => 'required|string|max:24|min:8|confirmed'
        ]);

        $this->admin->update($id,$data);

        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.admins.show',$id);
    }


    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id,Request $request)
    {

        //case admin edited his profile he cannot edit roles
        if($request->roles == null){
            $admin = $this->admin->setRelations(['roles'])->findOneById($id);
           $roles = [];
            for($i=0;$i<count($admin->roles);$i++){
                $roles[$i] = "".$admin->roles[0]->id."";
            }
            $request['roles']= $roles;
            $request['roles.*']= $roles;
        }
        //

        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'roles'     => 'required|array',
            'roles.*'   => 'required|integer',
            'email'     => 'required|email|unique:admins,email,'.$id,
            'image'       => 'sometimes|nullable|file|image|max:3000',
        ]);

        $this->admin->update($id,$data);

        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.admins.show',$id);
    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->admin->destroy($id);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.admins.index');
    }
}
