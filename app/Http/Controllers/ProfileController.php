<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('perfil', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|string|max:10',
            'contact_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'about' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $user->name = $request->name;
        $user->birth_date = $request->birth_date;
        $user->contact_email = $request->contact_email;
        $user->phone = $request->phone;
        $user->about = $request->about;
    
        if ($request->hasFile('profile_image')) {
            // Deletar imagem anterior se existir
            if ($user->profile_image) {
                $oldImagePath = str_replace('/storage/', '', $user->profile_image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            // Salvar nova imagem
            $path = $request->file('profile_image')->store('profile_images', 'public');
            
            // Atualizar caminho no banco de dados
            $user->profile_image = $path;
        }
    
        $user->save();
    
        return redirect()->route('perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
    
    // Método para atualizar o papel do usuário para gerente
    public function upgradeRole(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'cliente') {
            $user->role = 'gerente';
            $user->save();
            
            return response()->json(['success' => true, 'message' => 'Você agora é um Gerente!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao atualizar papel do usuário']);
    }
}