<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Auth\Access\AuthorizationException;

class SettingsController extends Controller
{
    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     * @throws AuthorizationException|AuthorizationException
     */
    public function index(): Renderable
    {
        $this->authorize('view-settings');
        return  view("admin.setting.index");
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request): RedirectResponse
    {

        $this->authorize('edit-settings');

        $keys =  $this->getValidatedData($request);
//            $keys = $request->except(['_token', 'files']);
        foreach ($keys as $key => $value)
        {
            if(str($key)->is('image_size'))
            {
                $value *= 1024;
            }

            Setting::set($key, $value);
        }

        session()->flash("success", __('messages.update'));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getValidatedData(Request $request): array
    {
        return $request->validate([
            'currency_code' => 'nullable|sometimes|string',
            'site_tax' => 'nullable|sometimes|integer|min:0|max:100',
            'min_order_amount' => 'nullable|sometimes|integer',
            'min_withdrawal_amount' => 'nullable|sometimes|integer',
            'image_size' => 'nullable|sometimes|integer',
            'privacy_policy' => 'nullable|sometimes',
            'store_terms_of_use' => 'nullable|sometimes',
            'about_us' => 'nullable|sometimes',
            'help' => 'nullable|sometimes',
        ]);
    }
}
