<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataHistorisService;

class DashboardController extends Controller
{
    public function __construct(
        protected DataHistorisService $service
    ) {}

    public function index()
    {
        $data = $this->service->dashboardData();

        return view('dashboard.dashboard', $data);
    }
}
