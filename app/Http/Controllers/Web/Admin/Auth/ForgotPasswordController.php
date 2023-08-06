<?php

namespace App\Http\Controllers\Web\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return Renderable
     */
    public function showLinkRequestForm(): Renderable
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function sendResetLinkEmail(Request $request): JsonResponse|RedirectResponse
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response === Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param Request $request
     * @return void
     */
    protected function validateEmail(Request $request): void
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param string $res
     * @return RedirectResponse|JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, string $res): JsonResponse|RedirectResponse
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'status' => __($res)
            ])
            :back()->with('status', __($res));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param string $res
     * @return RedirectResponse|JsonResponse
     *
     */
    protected function sendResetLinkFailedResponse(Request $request, string $res): JsonResponse|RedirectResponse
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => false,
                'status' => __($res),
                'errors' => ['email' => __($res)]
            ],404)
            :back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($res)]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker('admins');
    }
}
