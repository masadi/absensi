<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\VerifikasiPendafataran;
use Illuminate\Support\Facades\Mail;
class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('/aplikasi/dashboard', ['pageConfigs' => $pageConfigs]);
  }
  public function kirim_email(){
    Mail::to("masadi.com@gmail.com")->send(new VerifikasiPendafataran());
		return "Email telah dikirim";
  }
}
