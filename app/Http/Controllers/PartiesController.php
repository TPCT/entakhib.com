<?php

namespace App\Http\Controllers;

use App\Models\Party\Party;
use App\Settings\Site;
use Illuminate\Http\Request;

class PartiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parties = Party::paginate(app(Site::class)->parties_page_size)->withQueryString();
        $user = \Auth::guard('profile')->user();
        $can_vote = !$user || ($user->party_votes->pluck('id')->groupBy('id')->count() == 0);
        return $this->view('Parties.index', compact('parties', 'can_vote'));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Party $party)
    {
        $user = \Auth::guard('profile')->user();
        $can_vote = !$user || ($user->party_votes->pluck('id')->groupBy('id')->count() == 0);
        return $this->view('Parties.show', compact('party', 'can_vote'));
    }

    public function votes($locale){
        $parties = Party::whereHas('translations', function ($query){
            $query->where('language', app()->getLocale());
            $query->when(\request('search'), function ($query, $search){
                $query->where('title', 'like', '%'.$search.'%');
            });
        })->paginate(app(Site::class)->parties_page_size)->withQueryString();

        return $this->view('Parties.votes', compact('parties'));
    }
}
