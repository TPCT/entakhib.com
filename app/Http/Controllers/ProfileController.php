<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Candidate\Candidate;
use App\Models\Cluster\Cluster;
use App\Models\Party\Party;
use App\Models\Profile;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function register(){
        if (\request()->method() == "POST"){
            \request()->merge([
                'phone_number' => Utilities::getRealPhone(request('phone_number')),
            ]);

            \request()->merge(['phone_number' => Utilities::convert_arabic_numbers_to_english_number(\request('phone_number'))]);

            $data = request()->validate([
                'full_name' => 'required|max:255|regex:/^[^0-9]+$/u',
                'phone_number' => 'required|max:255|phone:INTERNATIONAL,JO|unique:profiles,phone_number|regex:/^[0-9]+$/u',
                'date_of_birth' => 'required|date|max:255|before_or_equal:' . Carbon::today()->subYears(18),
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required|exists:districts,id',
                'email' => 'nullable|max:255|email|unique:profiles,email',
                'agreement' => 'required',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            unset($data['agreement'], $data['g-recaptcha-response']);

            $data['otp'] = random_int(1000, 9999);
            $data['email'] = strtolower($data['email']);


            $user = Profile::create($data);
            $user->sendOtp();
            session()->put('user', $user->id);
            return redirect()->route('profile.otp');
        }
        return $this->view('Profile.register');
    }

    /**
     * @throws RandomException
     */
    public function login(){
        if (\request()->method() == "POST"){
            \request()->merge(['phone_number' => Utilities::convert_arabic_numbers_to_english_number(\request('phone_number'))]);

            \request()->merge([
                'phone_number' => Utilities::getRealPhone(request('phone_number'))
            ]);

            $data = request()->validate([
                'phone_number' => 'required|phone:INTERNATIONAL,JO|exists:profiles,phone_number|regex:/^[0-9]+$/u',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            $user = Profile::wherePhoneNumber($data['phone_number'])->first();

            if (!$user)
                return redirect()->route('profile.register');

            if (!$user->otp || $user->updated_at->diffInMinutes(Carbon::now()) > 5) {
                $user->update([
                    'otp' => random_int(1000, 9999)
                ]);
                $user->sendOtp();
            }
            session()->put('user', $user->id);
            return redirect()->route('profile.otp');
        }

        return $this->view('Profile.login');
    }

    /**
     * @throws RandomException
     */
    public function otp(){
        $user = Profile::find(session('user'));
        if (!$user || $user->updated_at->diffInMinutes(Carbon::now()) > 5 || $user->otp === null) {
            if ($user)
                $user->update(['otp' => null]);
            \Auth::guard('profile')->logout();
            session()->remove('user');
            return redirect()->route('profile.login');
        }


        if (\request()->method() == "POST"){
            $data = \request()->validate([
                'otp' => 'required',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            if ($data['otp'] == $user->otp) {
                $user->update(['otp' => null]);
                \Auth::guard('profile')->login($user);
                $redirect_url = session('requested-url', route('site.index'));
                session()->forget('requested-url');
                return redirect()->to($redirect_url);
            }

            return redirect(route('profile.otp'))->withErrors([
                'otp' => __("Invalid OTP")
            ]);
        }

        return $this->view('Profile.otp', compact('user'));
    }

    public function show(): \Illuminate\Http\JsonResponse|bool|string
    {
        return $this->view('Profile.view', [
            'user' => \Auth::guard('profile')->user()
        ]);
    }

    public function edit(){
        $user = \Auth::guard('profile')->user();

        if (\request()->method() == "POST"){
            \request()->merge([
                'phone_number' => Utilities::getRealPhone($user->phone_number)
            ]);

            $data = request()->validate([
                'full_name' => 'required|regex:/^[^0-9]+$/u|max:255',
                'phone_number' => 'required|max:255|phone:INTERNATIONAL,JO|unique:profiles,phone_number,'.$user->id.'|regex:/^[0-9]+$/u',
                'date_of_birth' => 'required|max:255|date|before_or_equal:' . Carbon::today()->subYears(18),
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required|exists:districts,id',
                'email' => 'nullable|max:255|email|unique:profiles,email,'.$user->id,
            ]);

            $user->email = strtolower($user->email);
            $user->update($data);
            $user->save();
            return redirect()->route('profile.view', compact('data'));
        }

        return $this->view('Profile.edit', [
            'user' => $user
        ]);
    }

    public function vote($locale, $type){
        $user = \Auth::guard('profile')->user();

        if ($type == Profile::PARTY && $user->party_votes->pluck('id')->groupBy('id')->count() == 0){
            $party = Party::findOrFail(\request('party_id'));

            $user->party_votes()->attach([
                'party_id' => $party->id,
            ]);

            $user->party_votes()->increment('votes');
            return redirect()
                ->route('parties.index')
                ->with('voted', 1)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        if ($type == Profile::CLUSTER && $user->cluster_votes->pluck('id')->groupBy('id')->count() == 0){
            $cluster = Cluster::findOrFail(\request('cluster_id'));

            if ($cluster->city_id != $user->city_id || $cluster->district_id != $user->district_id)
                return redirect()
                    ->route(
                        'clusters.index',
                        [
                            'city_id' => $user->city_id,
                            'district_id' => $user->district_id
                        ]
                    )
                    ->with('message', __("site.Voting Must Be Using The Same City, District"))
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate');

            $user->candidate_votes()->attach(\Arr::map(\request('candidate_ids'), function ($item) use ($cluster){
                return [
                    'candidate_id' => $item,
                    'cluster_id' => $cluster->id,
                    'city_id' => $cluster->city_id,
                    'district_id' => $cluster->district_id,
                ];
            }));

            $user->candidate_votes()->increment('votes');
            $user->cluster_votes()->increment('votes');

            return redirect()
                ->route('clusters.show', ['cluster' => $cluster])
                ->with('voted', 1)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        return back()
            ->with('voted', 0)
            ->header('cache-control', 'no-cache, no-store, must-revalidate');
    }

    public function logout(){
        \Auth::guard('profile')->logout();
        return redirect()->route('profile.login');
    }
}
