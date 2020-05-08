<?php

namespace App\Http\Middleware;

use App\Models\TodayJobs\TodayJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOverdueJobs
{
    /**
     * это всё для того чтобы если у сотрудника были незавершенные задачи которые помечены красным то чтобы его перебрасывало всегда на них
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $todayJobs = TodayJob::where('user_id', auth()->id())->whereNotNull('red')->get();

        if ($todayJobs->isNotEmpty()) {
            $currentRout = parse_url($request->url(), PHP_URL_PATH);
            $allowedRouts = [];
            foreach ($todayJobs as $job) {
                if($job->missed == 1) {
                    flash('Ознакомтесь с задачами на сегодня')->info()->important();
                    return redirect()->route('today_jobs.index');
                }
                $allowedRouts = array_merge($allowedRouts, unserialize($job->allowed_routes));
            }

            if (!in_array($currentRout, $allowedRouts)) {
                flash('Необходимо обработать задачи, выделенные красным')->error()->important();
                return redirect()->route('today_jobs.index');
            }
        }

        return $next($request);
    }
}
