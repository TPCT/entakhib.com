<?php

namespace App\Http\Controllers;

use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\District\District;
use App\Models\Party\Party;
use App\Settings\Site;
use Illuminate\Http\Request;

class ElectionResultsController extends Controller
{


    public function index(){
        if (\request('panel', 'clusters') == 'clusters'){
            $form_data = [
                'city_id' => \request('city_id'),
                'district_id' => \request('district_id'),
                'cluster_id' => \request('cluster_id'),
                'search' => \request('search')
            ];

            $cities = City::get();
            $districts = City::find($form_data['city_id'])?->districts;
            $clusters = District::find($form_data['district_id'])?->clusters;

            $candidates = Candidate::when(
                $form_data['city_id'],
                function ($q, $city_id) {
                    $q->whereHas('cluster', function ($q) use ($city_id) {
                        $q->where('city_id', $city_id);
                    });
                }
            )->when(
                $form_data['district_id'],
                function ($q, $district_id) {
                    $q->whereHas('cluster', function ($q) use ($district_id){
                        $q->where('district_id', $district_id);
                    });
                }
            )->when(
                $form_data['cluster_id'],
                function ($q, $cluster_id) {
                    $q->where('cluster_id', $cluster_id);
                }
            )->when(
                $form_data['search'],
                function ($q, $search) {
                    $q->whereHas('translation', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%');
                        $q->orWhere('slogan', 'like', '%' . $search . '%');
                    });
                }
            )->where('candidate_type', Candidate::CLUSTER_CANDIDATE)
                ->orderBy(\DB::raw('`votes` + `extra_votes`'), 'desc')
                ->paginate(app(Site::class)->candidates_page_size)
                ->withQueryString();

            return $this->view('ElectionResults.filter', compact(
                'cities', 'districts', 'candidates', 'clusters', 'form_data'
            ));
        }

        $form_data = [
            'party_id' => \request('party_id'),
        ];
        $parties = Party::when(
            $form_data['party_id'],
            function ($q, $party_id) {
                $q->where('id', $party_id);
            }
        )->orderBy('votes', 'desc')
        ->paginate(app(Site::class)->parties_page_size)
        ->withQueryString();
        return $this->view('ElectionResults.filter', compact('form_data', 'parties'));
    }

    public function partyWinners($locale, Party $party){
        $candidates = $party->candidates()->orderBy('votes')->where('winner', true)->get();
        return $this->view('ElectionResults.party-winners', compact('candidates', 'party'));
    }
}
