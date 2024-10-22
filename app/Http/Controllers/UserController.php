<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//log
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a paginated listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10); // Devuelve 10 usuarios por página
        return response()->json($users);
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Log cuando la función update es llamada con el ID del usuario
        Log::info('Entering update function with ID: ' . $id);

        // Buscar el usuario
        $user = User::findOrFail($id);

        // Validación de los datos
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        // Log de los datos validados
        Log::info('Validated data: ', $validatedData);

        // Actualizar el usuario con los datos validados
        $user->update($validatedData);

        // Log de éxito en la actualización
        Log::info('User updated successfully: ', $user->toArray());

        // Respuesta JSON con éxito
        return response()->json([
            'message' => 'User update success',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
