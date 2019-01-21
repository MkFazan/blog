<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\DeleteUserInformationRequest;
use App\Http\Requests\UserSaveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = User::$allUserRoles;
        $users = User::paginate(config('app.paginate'));

        return view('backend.dashboard.user.index',[
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dashboard.user.form',[
            'title' => 'Create new',
            'roles' =>User::$allUserRoles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserSaveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            User::create($data);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User created!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend.dashboard.user.form',[
            'title' => 'Edit new',
            'roles' =>User::$allUserRoles,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->except('_token', '_method');

        DB::beginTransaction();
        try {
            if (Hash::check($data['current_password'], $user->password)){

                $data['status'] = isset($data['status']) ? $data['status'] : 0;

                $user->update($data);

                DB::commit();

                return redirect()->route('users.index')->with('success', 'User created!');
            }else{
                return back()->with('error', 'Error! Current password failed!');
            }
        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error!' . $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->load('articles', 'favorite');

            if (count($user->articles) > 0 or count($user->favorite) > 0)
            {
                return redirect()->route('confirmation.delete', ['user' => $user->id])->with('warning', 'The user has articles. Are you sure you want to erase all data linking to it? Operation is not possible to roll back!');
            }
            $user->delete();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Used deleted!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error!' . $e);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmationDelete($id)
    {
        return view('backend.dashboard.user.confirmation_delete',[
            'user' => User::find($id),
            'title' => 'Delete ',
            'message' => session('warning')
        ]);
    }

    /**
     * @param DeleteUserInformationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAllInformationForUser(DeleteUserInformationRequest $request)
    {
        DB::beginTransaction();
        try {
            $message = $this->userService->deleteAllInformationForUser($request->except('_token'));

            DB::commit();

            return redirect()->route('users.index')->with('success', $message);

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }
}
