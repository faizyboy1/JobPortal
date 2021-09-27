<?php

namespace App\Http\Middleware;

use Closure;
use App\CompanyPackage;
use Illuminate\Support\Facades\DB;

class Package
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $activePackage = CompanyPackage::where('company_id', $user->company_id)
            ->where('status', 'active')
            ->where(function($query){
                $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
                $query->orWhereNull('end_date');
            })
            ->first();

        if (is_null($activePackage)) {
            return redirect()->route('admin.subscribe.index');
        }
        return $next($request);
    }
}
