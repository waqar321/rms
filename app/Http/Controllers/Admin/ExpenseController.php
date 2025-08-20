<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Hermawan\DataTables\DataTable;
use App\Models\User;

use Illuminate\Support\Facades\Route;

class ExpenseController extends Controller
{
    protected $ecom_admin_user;

    public function __construct()
    {
        // $this->ecom_admin_user =  ecom_admin_user::query();
    }

    public function expense()
    {
        return view('Admin/expense/index');
    }
    public function expense_list()
    {
        return view('Admin/expense-list/index');
    }
    public function tutorials()
    {
        return view('Admin/settings/tutorials');
    }
}
