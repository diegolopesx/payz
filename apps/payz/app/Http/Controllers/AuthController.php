<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','create']]);
    }

    /**
     * Cria um nonvo usuário.
     *
     * @param   Request  $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        //validate incoming request
        $user = new User;
        $document = $request->input('document');
        if(isset($document)){
            $request->merge(['document' =>  $user->removeChars($document)]);
        }

        $this->validate($request, [
            'nome' => 'required|string',
            'document' => 'required|string|unique:users|cpf_cnpj',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {
            $user->name = $request->input('nome');
            $user->email = $request->input('email');
            $user->document = $user->removeChars($request->input('document'));
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();
            //return successful response
            return response()->json(
                ['user' => $user, 'message' => 'Usuário criado com sucesso.'], 201
            );

        } catch (\Exception $e) {
            //return error message
            return response()->json(
                ['message' => 'Houve um erro ao criar o registro.'], 409
            );
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(
                ['message' => 'Unauthorized'], 401
            );
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logo the user out of the application.
     *
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(
            ['message' => 'Deslogado do sistema.']
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

}
