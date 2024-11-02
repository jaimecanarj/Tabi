<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render("Auth/Register");
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" =>
                "required|string|lowercase|email|max:255|unique:" . User::class,
            "password" => ["required", "confirmed", Rules\Password::defaults()],
            "index" => "required|in:escolar,heisig,wanikani",
            "estudio_diario" => "required|integer|numeric|min:1|max:50",
            "avatar" => "image|max:2048",
        ]);

        // Almacenar la imagen
        if ($request->hasFile("avatar")) {
            $file = $request->file("avatar");
            $path = $file->store("avatares", "public");
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "indice" => $request->index,
            "estudio_diario" => $request->estudio_diario,
            "avatar" => $path,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route("home", absolute: false));
    }
}
