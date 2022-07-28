<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        try {
            return view('pages.sessions.create');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param SessionRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SessionRequest $request)
    {
        try {
            if (!auth()->attempt($request->except('_token', '_method'))) {
                throw ValidationException::WithMessages([
                    'email' => 'Your provided credentials could not be verified.'
                ]);
            }

            session()->regenerate();
            return redirect('/')->with('success', 'Login successful!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        try {
            auth()->logout();
            return redirect('/')->with('success', 'Goodbye!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }
}
