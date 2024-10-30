<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(7);
        return view('admin.user.list',[
            'users' => $users,
            
        ]);
    }

    public function edit($id)
    {
        // Find the user by the ID passed from the route
        $user = User::findOrFail($id);
    
        // Pass the user data to the view
        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }
    
    public function update($id, Request $request)
    {
        // Find the user by the ID passed from the route
        $user = User::findOrFail($id);
    
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id, // Validate against the current user
            'mobile' => 'nullable|string|max:15',  // Assuming mobile is optional and has a max length
            'designation' => 'nullable|string|max:50',  // Assuming designation is optional
        ]);
    
        // Check if the validation fails
        if ($validator->fails()) {
            // Return JSON response with errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    
        // If validation passes, update the user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->designation = $request->input('designation');
        $user->save();  // Save the updated user data
    
        // Flash success message
        session()->flash('success', 'User information updated by admin!');
    
        // Return JSON response
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
    
        if ($user == null) {
            session()->flash('error', 'User not found!');
            return response()->json([
                'status' => false,
                'errors' => [],
            ]);
        }
    
        $user->delete();
        session()->flash('success', 'User deleted!');
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }
    
}
