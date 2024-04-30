<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class CheckStage
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedStage = $request->query('stage', 1);
        $currentStage = session()->get('current_stage', 1);

        if ($requestedStage > $currentStage) {
            session()->flash('alert', 'Fill in required fields first');
            return back();
        }

        return $next($request);
    }
}
