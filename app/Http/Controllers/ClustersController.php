<?php

namespace App\Http\Controllers;

use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Settings\Site;
use Illuminate\Http\Request;

class ClustersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $form_data = [
            'city_id' => \request('city_id'),
            'district_id' => \request('district_id'),
         ];

         $cities = City::get();
         $districts = City::find($form_data['city_id'])?->districts;

         $clusters = Cluster::when(
            $form_data['city_id'],
            function ($q, $city_id) {
                $q->where('city_id', $city_id);
            }
         )->when(
            $form_data['district_id'],
            function ($q, $district_id) {
                $q->where('district_id', $district_id);
            }
         )->paginate(app(Site::class)->clusters_page_size)
         ->withQueryString();
         return $this->view('Clusters.index', compact(
            'cities', 'clusters', 'form_data', 'districts')
         );
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Cluster $cluster)
    {
        $user = \Auth::guard('profile')->user();
        $can_vote = !$user || ($user->cluster_votes->pluck('id')->groupBy('id')->count() == 0);
        $can_vote_to_cluster = !$user || $user->city_id == $cluster->city_id && $user->district_id == $cluster->district_id;
        return $this->view('Clusters.show', compact('cluster', 'can_vote', 'can_vote_to_cluster'));
    }

    public function votes(){
        $form_data = [
            'city_id' => \request('city_id'),
            'district_id' => \request('district_id'),
            'search' => \request('search')
        ];

        $cities = City::get();
        $districts = City::find($form_data['city_id'])?->districts;

        $clusters = Cluster::when(
            $form_data['city_id'],
            function ($q, $city_id) {
                $q->where('city_id', $city_id);
            }
        )->when(
            $form_data['district_id'],
            function ($q, $district_id) {
                $q->where('district_id', $district_id);
            }
        )->when($form_data['search'], function ($q, $search){
            $q->whereHas('translations', function ($q) use ($search){
                $q->where('title', 'like', '%'.$search.'%');
            });
        })->paginate(app(Site::class)->clusters_page_size)
        ->withQueryString();
        return $this->view('Clusters.votes', compact(
                'cities', 'clusters', 'form_data', 'districts')
        );
    }

    public function votesShow($locale, Cluster $cluster){
        $total_individual_cluster_votes = $cluster->candidates->sum('votes') + $cluster->candidates->sum('extra_votes');


        $total_district_cluster_votes = $cluster->district->clusters()->sum('votes') + $cluster->district->clusters()->withSum('candidates', 'extra_votes')->get()->sum('candidates_sum_extra_votes');


        $district_cluster_votes = [];
        $candidates_cluster_votes = [];

        foreach($cluster->district->clusters as $district_cluster){
                $district_cluster_votes[$district_cluster->title] = $total_district_cluster_votes ? number_format(
                    ($district_cluster->votes + $district_cluster->candidates->sum('extra_votes')) / $total_district_cluster_votes * 100,
                    2
                ) : 0;
        }

        foreach ($cluster->candidates as $candidate){
            $candidates_cluster_votes[$candidate->title] = $total_individual_cluster_votes ? number_format(
                ($candidate->votes + $candidate->extra_votes) / $total_individual_cluster_votes * 100,
                2
            ) : 0;
        }

        return $this->view(
            'Clusters.votes-show', compact(
                'candidates_cluster_votes',
                'district_cluster_votes',
                'total_individual_cluster_votes',
                'total_district_cluster_votes',
                'cluster'
            )
        );
    }
}
