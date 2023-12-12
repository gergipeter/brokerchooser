<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Session\Session as SessionManager;
use Illuminate\Http\Request;

class StartSession
{
    const DB_SESSION_ID_KEY = 'db_session_id';

    private Application $application;
    private SessionManager $session;

    public function __construct(
        Application $application,
        SessionManager $session
    ) {
        $this->application = $application;
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $session = null;

        if ($this->session->has(self::DB_SESSION_ID_KEY)) {
            $sessionIdForDb = $this->session->get(self::DB_SESSION_ID_KEY);
            $session = Session::query()->find($sessionIdForDb);
        }

        if ($session === null) {
            $session = new Session();
            $session->save();
            $this->session->put(self::DB_SESSION_ID_KEY, $session->id);
        }

        if ($request->getMethod() === 'GET' && !$request->isXmlHttpRequest()) {
            $session->events()->create([
                'category' => 'pageview',
                'action' => 'pageview',
                'label' => 'pageview',
                'url' => url($request->path())
            ]);
        }

        $this->application->instance(Session::class, $session);

        return $next($request);
    }
}
