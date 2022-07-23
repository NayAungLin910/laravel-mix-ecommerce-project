<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function showDashbord()
    {
        $todayIncomeCount = Income::whereDay('created_at', date('d'))->sum('amount');
        $todayOutcomeCount = Outcome::whereDay('created_at', date('d'))->sum('amount');
        $userCount = User::count();
        $productCount = Product::count();

        $months = [date('F')];
        $yearMonth = [
            ['year' => date('Y'), 'month' => date('m')]
        ];

        $dayMonths = [date('F d')]; // for income outcome
        $dayMonthYear = [
            [
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
            ],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $months[] = date('F', strtotime("-$i month"));
            $yearMonth[] = [
                'year' => date('Y', strtotime("-$i month")),
                'month' => date('m', strtotime("-$i month")),
            ];

            $dayMonths[] = date('F d', strtotime("-$i day"));

            $dayMonthYear[] = [
                'day' => date('d', strtotime("-$i day")),
                'year' => date('Y', strtotime("-$i day")),
                'month' => date('m', strtotime("-$i day")),
            ];
        }
        $incomeCount = [];
        $outcomeCount = [];
        foreach ($dayMonthYear as $dmy) {
            $incomeCount[] = Income::whereDay('created_at', $dmy['day'])
                ->whereMonth('created_at', $dmy['month'])
                ->whereYear('created_at', $dmy['year'])->sum('amount');

            $outcomeCount[] = Outcome::whereDay('created_at', $dmy['day'])
                ->whereMonth('created_at', $dmy['month'])
                ->whereYear('created_at', $dmy['year'])->sum('amount');
        }



        $saleData = [];
        foreach ($yearMonth as $ym) {
            $saleData[] = ProductOrder::whereYear('created_at', $ym['year'])->whereMonth('created_at', $ym['month'])->count();
        }

        $revMonths = array_reverse($months);
        $revSaleData = array_reverse($saleData);
        $revDayMonths = array_reverse($dayMonths);
        $revIncomeCount = array_reverse($incomeCount);
        $revOutcomeCount = array_reverse($outcomeCount);

        $latestusers = User::latest()->take(3)->get();
        $products = Product::latest()->take(5)->where('total_quantity', '<', 3)->get();

        return view('admin.dashbord', compact(
            'todayIncomeCount',
            'todayOutcomeCount',
            'userCount',
            'productCount',
            'revMonths',
            'revSaleData',
            'revDayMonths',
            'revIncomeCount',
            'revOutcomeCount',
            'latestusers',
            'products',
        ));
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $cre = request()->only('email', 'password');

        if (auth()->guard('admin')->attempt($cre)) {
            $username = Auth::guard('admin')->user()->name;
            return redirect('/admin')->with('success', "Welcome $username !");
        }

        return redirect()->back()->with('error', "Email and password does not match!");
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect('/');
    }
}
