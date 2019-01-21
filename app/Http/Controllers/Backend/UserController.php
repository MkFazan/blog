<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\DeleteUserInformationRequest;
use App\Http\Requests\UserSaveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userService;
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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

        return view('backend.dashboard.user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create new';
        $roles = User::$allUserRoles;

        return view('backend.dashboard.user.form', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserSaveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request)
    {
        list($status, $message) = $this->userService->store($request->all());

        if ($status == 'success'){
            return redirect()->route('users.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
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
        $title = 'Edit new';
        $roles =User::$allUserRoles;

        return view('backend.dashboard.user.form', compact('title', 'roles', 'user'));
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
        list($status, $message) = $this->userService->update($user, $request->except('_token', '_method'));

        if ($status == 'success'){
            return redirect()->route('users.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
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
        list($status, $message) = $this->userService->destroy($user);

        if ($status == 'redirect'){
            return redirect()->route('confirmation.delete', ['user' => $user->id])->with('warning', 'The user has articles. Are you sure you want to erase all data linking to it? Operation is not possible to roll back!');
        }

        if ($status == 'success'){
            return redirect()->route('users.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmationDelete($id)
    {
        $user = $this->userRepository->getUserForId($id);
        $title = 'Delete ';
        $message = session('warning');

        return view('backend.dashboard.user.confirmation_delete', compact('user', 'title', 'message'));
    }

    /**
     * @param DeleteUserInformationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAllInformationForUser(DeleteUserInformationRequest $request)
    {
        list($status, $message) = $this->userService->deleteAllInformationForUser($request->except('_token'));

        if ($status == 'success'){
            return redirect()->route('users.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }
}
