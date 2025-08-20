<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Controller;
use App\Models\Admin\Item;
use App\Models\Admin\Receipt;
use App\Models\Admin\ReceiptItem;
use App\Models\Admin\Purchase;
use App\Models\Admin\PurchaseItem;
use App\Models\Admin\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Validator;
// use App\Models\ecom_merchant_role;

class POSController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            // $permission = Permission::find(base64_decode($request->id));
            // return view('Admin/post/data-entry/index', compact('permission'));
        }
        else
        {
            return view('Admin/POS/index');
        }
    }
    public function saveCartReceipt(Request $request)
    {
        // $request->items = [id, id, …]
        // $request->qty   = { id: qty, … }
        $ids = $request->items;
        $qty = $request->qty;
        $pricing = $request->pricing;
        // Fetch item data in one go
        $items = Item::whereIn('id', $ids)->get([
            'id','name','price','image_path'
        ])->keyBy('id');

        $cart = [];
        foreach ($ids as $id)
        {
            if (! isset($items[$id])) continue;

            $item = $items[$id];
            // $q    = max(1, (int)($qty[$id] ?? 1));   //ensures that the quantity or price value stored in $q is always at least 1, and it safely handles missing or invalid entries.
            $q    = $qty[$id];
            $price  = $pricing[$id];
            $sub  = $price * $q;

            $cart[$id] = [
                'id'         => $item->id,
                'name'       => $item->name,
                'price'      => $price,
                'image_path' => $item->image_path,
                'qty'        => $q,
                'subtotal'   => $sub,
            ];
        }

        // dd($cart);

        // 1️⃣ Calculate total amount from the subtotals
        $totalAmount = array_sum(array_column($cart, 'subtotal'));

        // 2️⃣ Build the purchase payload
        $ReceiptData = [
            'total_amount' => $totalAmount,
            'created_at'   => now(),
            'entry_by'     => auth()->id(),
        ];


        $Receipt = Receipt::create($ReceiptData);

            // 4️⃣ Prepare purchaseItem rows
        $ReceiptItems = [];
        foreach ($cart as $item)
        {
            $ReceiptItems[] = [
                'Receipt_id'     => $Receipt->id,
                'item_id'        => $item['id'],
                'item_price'     => $item['price'],
                'item_qty'       => $item['qty'],
                'item_sub_total' => $item['subtotal'],
                'created_at'     => now(),
            ];
        }

        // 5️⃣ Bulk insert all ReceiptItems
        ReceiptItem::insert($ReceiptItems);

        if($request->user_id != null)
        {
            $user_id = $request->user_id;

            $Ledger = Ledger::where('user_id', $user_id)
                            ->orderBy('id', 'desc')
                            ->first();
            // dd(User::find($user_id)->roles);

            $new_Ledger = new Ledger();
            $new_Ledger->role_id = User::find($user_id)->roles->first()->id;
            $new_Ledger->user_id =  $user_id;
            $new_Ledger->Receipt_id = $Receipt->id;
            $new_Ledger->payment_type = 'Sale';  //vendor id
            $new_Ledger->cash_amount = $Receipt['total_amount'] ?? 0.0;
            $new_Ledger->total_amount = $Receipt['total_amount'] ?? 0.0;
            $new_Ledger->payment_detail = 'entry from POS';                 //vendor id

            if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != 0)
            {
                if(User::find($user_id)->roles->first()->id == 15)   // if vendor, deduct entered amount
                {
                    $new_remaining_amount = $Ledger->remaining_amount - $ReceiptData['total_amount'];
                }
                else if(User::find($user_id)->roles->first()->id == 12) // if employee, add in previous amount
                {
                    $new_remaining_amount = $Ledger->remaining_amount - $ReceiptData['total_amount'];
                }
                $new_Ledger->remaining_amount = $new_remaining_amount;
            }
            else
            {
                $new_Ledger->remaining_amount = $ReceiptData['total_amount'];
            }

            $new_Ledger->created_at = now();  //vendor id
            $new_Ledger->save();
        }

        // Log::info($cart);

        // return response()->json(['status' => 'ok', 'data' => $cart]);

        session(['cart' => $cart]);
        return response()->json(['status' => 'ok']);
    }
    public function saveCartPurchase(Request $request)
    {
        // $request->items = [id, id, …]
        // $request->qty   = { id: qty, … }
        $ids = $request->items;
        $qty = $request->qty;
        $pricing = $request->pricing;

        // Fetch item data in one go
        $items = Item::whereIn('id', $ids)->get([
            'id','name','price','image_path'
        ])->keyBy('id');

        $cart = [];
        foreach ($ids as $id)
        {
            if (! isset($items[$id])) continue;
            $item = $items[$id];
            // $q    = max(1, (int)($qty[$id] ?? 1));
            $q    = $qty[$id];
            $price  = $pricing[$id];
            $sub  = $price * $q;

            $cart[$id] = [
                'id'         => $item->id,
                'name'       => $item->name,
                'price'      => $price,
                'image_path' => $item->image_path,
                'qty'        => $q,
                'subtotal'   => $sub,
            ];
        }

        // dd($cart);

        // 1️⃣ Calculate total amount from the subtotals
        $totalAmount = array_sum(array_column($cart, 'subtotal'));

        // 2️⃣ Build the purchase payload
        $purchaseData = [
            'total_amount' => $totalAmount,
            'created_at'   => now(),
            'entry_by'     => auth()->id(),
        ];

        $purchase = Purchase::create($purchaseData);

        // 4️⃣ Prepare purchaseItem rows
        $purchaseItems = [];
        foreach ($cart as $item) {
            $purchaseItems[] = [
                'purchase_id'     => $purchase->id,
                'item_id'        => $item['id'],
                'item_price'     => $item['price'],
                'item_qty'       => $item['qty'],
                'item_sub_total' => $item['subtotal'],
                'created_at'     => now(),
            ];
        }

        // 5️⃣ Bulk insert all purchaseItems
        PurchaseItem::insert($purchaseItems);
        //
        if($request->user_id != null)
        {
            $user_id = $request->user_id;

            $Ledger = Ledger::where('user_id', $user_id)
                            ->orderBy('id', 'desc')
                            ->first();

            //===================================================================
                // $new_remaining_amount = 0;

                // if($Ledger->payment_type == 'Cash')
                // {
                //     if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != 0)
                //     {
                //         $new_remaining_amount = $Ledger->remaining_amount + $purchaseData['total_amount'];
                //     }
                //     else
                //     {
                //         $new_remaining_amount = $purchaseData['total_amount'];
                //     }
                // }
                // if($Ledger->payment_type == 'Buy')
                // {
                //     if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != 0)
                //     {
                //         $new_remaining_amount = $Ledger->remaining_amount + $purchaseData['total_amount'];
                //     }
                //     else
                //     {
                //         $new_remaining_amount = $purchaseData['total_amount'];
                //     }
                // }
                // if($Ledger->payment_type == 'Sale')
                // {
                //     dd('last Sale lia ');
                // }

            //===================================================================

            $new_Ledger = new Ledger();
            $new_Ledger->role_id = User::find($user_id)->roles->first()->id;
            $new_Ledger->user_id =  $user_id;
            $new_Ledger->purchase_id = $purchase->id;
            $new_Ledger->payment_type = 'Buy';  //vendor id
            $new_Ledger->cash_amount = $purchase['total_amount'] ?? 0.0;
            $new_Ledger->total_amount = $purchase['total_amount'] ?? 0.0;
            $new_Ledger->payment_detail = 'entry from Item Purchasing';  //vendor id

            if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != 0)
            {
                $new_Ledger->remaining_amount = $Ledger->remaining_amount + $purchaseData['total_amount'];  //new_remaining_amount;
            }
            else
            {
                $new_Ledger->remaining_amount = $purchaseData['total_amount'];
            }

            $new_Ledger->created_at = now();  //vendor id
            $new_Ledger->save();
        }


        session(['cart' => $cart]);
        return response()->json(['status' => 'ok']);
    }
    public function printReceipt()
    {
        $cart = session('cart', []);

        return view('print_receipt', compact('cart'));
    }

}
