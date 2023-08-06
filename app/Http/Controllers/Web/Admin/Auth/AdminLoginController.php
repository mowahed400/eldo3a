<?php

namespace App\Http\Controllers\Web\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::ADMIN_HOME;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * return login form for admin
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $data = $this->getCredentials($request);

        // login success
        if ($this->guard()->attempt($data,$request->has('remember_me'))){
            return $request->wantsJson()
                ? response()->json([
                    'success' => true,
                    'message' =>__('messages.login_success',['name' => auth('admin')->user()->name]),
                ])
                : redirect()->to($this->redirectTo);
        }

        //login fails
        session()->flash('error',trans('auth.failed'));
        return $request->wantsJson()
            ? response()->json([
                'success' => false,
                'message' =>__('auth.failed'),
            ],401)
            : redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login.index');
    }

    /**
     * get the credential for sign in
     *
     * @param Request $request
     * @return array
     */
    private function getCredentials(Request $request): array
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);
    }


    private function guard()
    {
        return auth('admin');
    }


}
