<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Update approved status of all registerd users
     */
    
    public function update(Request $request, $id)
    {
        // Gate::authorize('modify', $post);      
    
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Manually update specific fields
        $user->selected = $request->selected;
        $user->save(); // Save changes 

        return ['user' => $user];
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return ['user' => $user];
    }
    
}
