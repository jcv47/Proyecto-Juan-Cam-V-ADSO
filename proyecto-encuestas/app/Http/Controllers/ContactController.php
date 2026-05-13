<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'asunto' => ['required', 'string', 'max:255'],
            'mensaje' => ['required', 'string', 'max:5000'],
        ]);

        // Buscar admins verificados
        $admins = User::where('role', 'admin')
            ->whereNotNull('email_verified_at')
            ->get();

        // Enviar correo
        foreach ($admins as $admin) {

            Mail::to($admin->email)
                ->send(new ContactMessageMail($data));
        }

        return back()->with('success', 'Tu mensaje fue enviado correctamente.');
    }
}