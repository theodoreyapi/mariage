<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('welcome', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'message' => 'required|string',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        // Photo
        if ($request->file('attachment') !== null) {
            $photo = $request->file('attachment');
            $photoName = 'koudougnonedwige' . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('koudou/edwige'), $photoName);
            $photoPath = 'mariage/public/koudou/edwige/' . $photoName;
        }

        $message = $request->message . "\n\nTéléchargez ici : " . url($photoPath);

        session()->flash('success', 'Fichier importé avec succès. Utilisez les liens WhatsApp générés ci-dessous.');

        return redirect()->route('import.links', ['message' => urlencode($message)]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', "L'utilisateur a été supprimé avec succès.");
    }
}
