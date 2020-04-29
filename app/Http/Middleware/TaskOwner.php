<?php

namespace App\Http\Middleware;

use App\Models\Tasks\Task;
use Closure;
use Illuminate\Support\Facades\Auth;

class TaskOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $task = $request->route()->parameters()['task'];

        if ($task->creator_id != Auth::user()->id)
        {
           abort(403);
        }

        return $next($request);
    }
}
