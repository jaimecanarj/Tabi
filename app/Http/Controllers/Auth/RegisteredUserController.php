<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Estudio;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            "avatar" => "image|max:2048|nullable",
        ]);

        // Almacenar la imagen
        $path = null;
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

    public function show($id)
    {
        //Obtener información del usuario
        $user = User::find($id);

        //Obtener numero de repasos de este usuario donde kanji es unico
        $data = Estudio::select("estudios.*")
            ->where("user_id", $id)
            ->join(
                DB::raw(
                    "(SELECT MAX(id) as max_id FROM estudios WHERE user_id = " .
                        $id .
                        " GROUP BY kanji_id) as latest"
                ),
                "estudios.id",
                "=",
                "latest.max_id"
            )
            ->orderBy("estudios.id", "desc")
            ->get();

        $studyCount = count($data);

        //Obtener ultimos 10 repasos
        $studys = $data->take(10);
        $studys->load("kanji");

        return Inertia::render("Usuario", [
            "user" => $user,
            "studyCount" => $studyCount,
            "studys" => $studys,
        ]);
    }
}
