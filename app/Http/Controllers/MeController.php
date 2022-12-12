<?php

namespace App\Http\Controllers;

use App\Models\ExerciseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MeController extends Controller
{
    /**
     * Return current user's profile info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        // Get today achievement data
        $todayAchievement = $user->achievements()->where('recorded_date', Carbon::today())->first();
        if (!$todayAchievement) {
            $todayAchievement = $user->achievements()->create([
                'achieved_rate' => 0,
                'recorded_date' => Carbon::today()
            ]);
        }

        // Get body info data
        $bodyInfo = $user->bodyInfo()->get()->last()->only('height', 'weight', 'fat_percent');

        // Build the response
        $response = $user;
        $response->body_info = $bodyInfo;
        $response->today_achievement = $todayAchievement->only(['achieved_rate', 'recorded_date']);

        return response()->json([
            'data' => $response
        ]);
    }

    /**
     * Return current user's body info histories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bodyInfoHistories(Request $request)
    {
        $user = $request->user();
        $bodyInfo = $user->bodyInfo()->paginate($this->perPageParam($request));;

        return response()->json($bodyInfo);
    }

    /**
     * Return current user's meals histories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function meals(Request $request)
    {
        $user = $request->user();
        $meals = $user->meals()->paginate($this->perPageParam($request));

        return response()->json($meals);
    }

    /**
     * Return current user's exercise histories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exerciseHistories(Request $request)
    {
        $user = $request->user();
        $exerciseHistories = ExerciseHistory::with('exercise')
            ->where('user_id', $user->id)
            ->paginate($this->perPageParam($request));

        return response()->json($exerciseHistories);
    }

    /**
     * Return current user's diaries
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function diaries(Request $request)
    {
        $user = $request->user();
        $diaries = $user->diaries()->paginate($this->perPageParam($request));

        return response()->json($diaries);
    }
}
