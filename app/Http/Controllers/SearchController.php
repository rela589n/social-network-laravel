<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            redirect()->route('home');
        }

        $users = User::where(
            DB::raw("CONCAT (first_name, ' ', last_name)"),
            'LIKE',
            "%{$query}%"
        )
            ->orWhere('username', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('users'));
    }
}
