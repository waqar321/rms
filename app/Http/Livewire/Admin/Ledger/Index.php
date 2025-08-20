<?php

namespace App\Http\Livewire\Admin\Ledger;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\Item;
use App\Models\User;
use App\Models\Admin\Ledger;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\LedgerComponent;
use Illuminate\Support\Facades\Redirect;

class Index extends Component
{
    use WithPagination, WithFileUploads, LedgerComponent;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
                            'deleteLedgerOperation' => 'deleteLedgerOperation',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteCategoryOperation' => 'DeleteCategory',
                            'getItemAmount' => 'fetchItemAmount',
                            'UpdateFields' => 'HandleUpdateFields'
                        ];

    public function mount(Ledger $ledger)
    {
        
        $this->Ledger = $ledger;
        $this->setMountData();
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.ledger.index', $this->RenderData());
    }
    public function fetchItemAmount($itemId)
    {
        // Fetch the selected item and its amount
        $item = Item::find($itemId);
        // dd($item);
        if ($item)
        {
            $this->itemAmount = $item->cost_price;  // Assuming the `amount` column exists
        }
        else
        {
            $this->itemAmount = null;
        }
        $this->Collapse = 'uncollapse';

        $this->dispatchBrowserEvent('item_price', ['item_price' => $this->itemAmount]);
    }
    public function saveLedger()
    {

        // dd(
        //     $this->user_payent,
        //     $this->selected_user_id,
        //     $this->selected_payment_id,
        //     $this->selected_item_id,
        //     $this->Ledger
        // );

        if($this->selected_role_id != null)
        {
            $this->Ledger->role_id = $this->selected_role_id;
        }
        if($this->selected_user_id != null)
        {
            $this->Ledger->user_id = $this->selected_user_id;
        }
        if($this->selected_item_id != null)
        {
            $this->Ledger->item_id = $this->selected_item_id;
        }
        if($this->selected_payment_id != null)
        {
            $this->Ledger->payment_type = $this->selected_payment_id;
        }

        // dd($this->Ledger);
        if($this->selected_payment_id == 'Cash')
        {
            $Ledger = Ledger::where('user_id', $this->selected_user_id)
                            ->orderBy('id', 'desc')
                            ->first();

            // dd($this->user_payment == 'credit');

            if($this->user_payment == 'credit') // if cash and credit means increase the remaining balance
            {
                $this->Ledger->remaining_amount = ($this->user_payent = 'credit') && (isset($Ledger->remaining_amount) && $Ledger->remaining_amount != "0.00") ?
                                                    $Ledger->remaining_amount + $this->Ledger->total_amount :
                                                    $this->Ledger->total_amount;

                $this->Ledger->amount_added = 1;
            }
            else if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != "0.00") //// if cash and debit means deduct the remaining balance
            {
                $last_remaining_amount = $Ledger->remaining_amount;
                $new_remaining_amount = $last_remaining_amount - $this->Ledger->total_amount;
                $this->Ledger->remaining_amount = $new_remaining_amount;
            }
        }
        // dd($this->Ledger);

        // if($this->selected_payment_id == 'Buy')
        // {
        //     $Ledger = Ledger::where('user_id', $this->selected_user_id)
        //                     ->orderBy('id', 'desc')
        //                     ->first();

        //     // dd($this->Ledger->total_amount, $Ledger->remaining_amount, $Ledger);

        //     if(isset($Ledger->remaining_amount) && $Ledger->remaining_amount != "0.00")
        //     {
        //         // dd($this->Ledger->total_amount, $Ledger->remaining_amount, $Ledger);
        //         // dd($last_remaining_amount, $new_remaining_amount);
        //         $last_remaining_amount = $Ledger->remaining_amount;
        //         $new_remaining_amount = $last_remaining_amount + $this->Ledger->total_amount; // 142135 + 2000
        //         $this->Ledger->remaining_amount = $new_remaining_amount;
        //     }
        //     else
        //     {
        //         $this->Ledger->remaining_amount = $this->Ledger->total_amount;
        //     }
        // }

        // dd($this->Ledger);
        $this->Ledger->save();

        $this->Ledger = new Ledger();
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('LedgerUpdated', ['message' => 'Ledger updated succesfullyy!!']);
        }
        return Redirect::route('ledgers');
        // dd($this->Ledger);

    }
    public function HandleUpdateFields($data_id, $value)
    {
        $this->unit_price_read_only = 'readonly';


        // dd($data_id == 'payment_type', $data_id);
        $items = collect();

        if($data_id == 'user_role')
        {
            $this->selected_role_id = $value;

            $users = User::whereHas('roles', function ($query)
            {
                $query->where('id', $this->selected_role_id);
            })->pluck('name', 'id');

            $this->dispatchBrowserEvent('LoadedUsers', ['users' => $users]);

            $this->Ledger->cash_amount = 0;
            $this->Ledger->unit_price = 0;
            $this->Ledger->unit_qty = 0;
            $this->Ledger->total_amount = 0;

            // dd($this->selected_role_id, $this->selected_payment_id);

            if($this->selected_role_id != 15 && $this->selected_payment_id == 'product_bought') // if vendor
            {
                $this->show_users = 'd-none';
                $this->show_items = 'd-none';
                $this->cash_amount_show = 'd-none';
                $this->unit_price_show = 'd-none';
                $this->unit_qty_show = 'd-none';
                $this->total_amount_show = 'd-none';

                $this->selected_user_id = null;
                $this->selected_item_id = null;

                $this->dispatchBrowserEvent('item_error', ['message' => 'We Can buy only from vendors']);
                return false;
            }
            else if($this->selected_role_id == 15)
            {
                $this->show_users = '';
                $this->show_items = '';
                $this->cash_amount_show = 'd-none';
                $this->unit_price_show = '';
                $this->unit_qty_show = '';
                $this->total_amount_show = '';

                $items = Item::where('category_id', 12)->pluck('name', 'id');
                $this->dispatchBrowserEvent('LoadedItems', ['items' => $items]);
            }
            // $this->ResetData();
            // $this->RenderData();

            $this->payment_type_show = '';
            $this->Collapse = 'uncollapse';
            // $this->dispatchBrowserEvent('LoadedUsers', ['users' => $users]);
        }
        else if($data_id == 'user_payment')
        {
            $this->user_payment = $value;
        }
        else if($data_id == 'payment_type')
        {
            $this->selected_payment_id = $value;

            $this->show_users = '';
            $this->Collapse = 'uncollapse';

            // dd($this->selected_role_id, $this->selected_payment_id);

            if($this->selected_payment_id == 'Cash')
            {
                $this->Ledger->cash_amount = 0;
                $this->Ledger->unit_price = 0;
                $this->Ledger->unit_qty = 0;
                $this->Ledger->total_amount = 0;

                $this->cash_amount_show = '';
                $this->total_amount_show = '';
                $this->unit_price_show = 'd-none';
                $this->unit_qty_show = 'd-none';
                $this->show_items = 'd-none';
            }
            if($this->selected_payment_id == 'Sale')
            {
                $this->Ledger->cash_amount = 0;
                $this->Ledger->unit_price = 0;
                $this->Ledger->unit_qty = 0;
                $this->Ledger->total_amount = 0;

                $this->show_users = '';
                $this->cash_amount_show = 'd-none';
                $this->unit_price_show = 'd-none';
                $this->unit_qty_show = 'd-none';
                $this->total_amount_show = 'd-none';

                $this->show_items = '';
                $this->unit_price_show = '';

                $this->unit_qty_show = '';
                $this->total_amount_show = '';
                //$this->total_amount_show = 'd-none';

                $items = Item::pluck('name', 'id');
                $this->dispatchBrowserEvent('LoadedItems', ['items' => $items]);
               /*  $items = Item::pluck('name', 'id'); */
                // dd($items);
            }
            else if($this->selected_payment_id == 'Buy')
            {
                $this->Ledger->cash_amount = 0;
                $this->Ledger->unit_price = 0;
                $this->Ledger->unit_qty = 0;
                $this->Ledger->total_amount = 0;

                 // dd($this->selected_role_id == '15');

                if($this->selected_role_id == 15) // from vendor role we can bought only
                {
                    $this->show_users = '';
                    $this->show_items = '';
                    $this->cash_amount_show = 'd-none';
                    $this->unit_price_show = '';
                    $this->unit_qty_show = '';
                    $this->total_amount_show = '';

                    $items = Item::where('category_id', 12)->pluck('name', 'id');
                    $this->dispatchBrowserEvent('LoadedItems', ['items' => $items]);
                }
                else
                {
                    $this->show_users = 'd-none';
                    $this->show_items = 'd-none';
                    $this->cash_amount_show = 'd-none';
                    $this->unit_price_show = 'd-none';
                    $this->unit_qty_show = 'd-none';
                    $this->total_amount_show = 'd-none';

                    $this->dispatchBrowserEvent('item_error', ['message' => 'We Can buy only from vendors']);
                    return false;
                }
            }

            // $this->payment_type_show = '';
            // dd($this->selected_payment_id);
            // dd('seleceted payment_type ', $value);

        }
        else if($data_id == 'user_id')
        {
            $this->selected_user_id = $value;
            // dd('seleceted user_id ', $value);

        }
        else if($data_id == 'item_id')
        {
            $this->selected_item_id = $value;
            $selected_item = Item::find($this->selected_item_id);
            $this->Ledger->unit_price = $selected_item->price;
            $this->Ledger->unit_qty = 1;
            $this->Ledger->total_amount = $this->Ledger->unit_price * $this->Ledger->unit_qty;
        }

        // $items = collect();


      //  if($this->selected_payment_id == 'product_sold' || $this->selected_payment_id == 'product_bought')
      //  {
            // $this->show_items = '';
            // $this->show_items = '';
            // $this->unit_price_show = '';
            // $this->unit_price_read_only = 'readonly';
            // $this->unit_qty_show = '';
            // $this->total_amount_show = '';

        //}


    }
    public function deleteLedgerOperation(Ledger $ledger)
    {
        // dd($ledger);
        $name = $ledger->user->name ?? ' -';
        $ledger->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function ResetDataForCash()
    {
        //add d-none reset user
        //add d-none reset item
        //add d-none reset unit price
        //add d-none reset unit qty
        //add d-none reset unit total amount

        $this->payment_type_show = 'd-none';
        $this->show_users = 'd-none';
        $this->show_items = 'd-none';
        $this->cash_amount_show = 'd-none';
        $this->unit_price_show = 'd-none';
        $this->unit_qty_show = 'd-none';
        $this->total_amount_show = 'd-none';
        $this->payment_detail_show = 'd-none';

        $this->selected_item_id = null;
        $this->selected_role_id = null;
        $this->selected_user_id = null;
        $this->selected_payment_id = null;

        $this->unit_price_read_only = '';

        $this->Ledger->cash_amount = null;
        $this->Ledger->unit_price = null;
        $this->Ledger->unit_qty = null;
        $this->Ledger->total_amount = null;
        $this->Ledger->payment_type = null;
    }
    public function ResetData()
    {
        $this->payment_type_show = 'd-none';
        $this->show_users = 'd-none';
        $this->show_items = 'd-none';
        $this->cash_amount_show = 'd-none';
        $this->unit_price_show = 'd-none';
        $this->unit_qty_show = 'd-none';
        $this->total_amount_show = 'd-none';
        $this->payment_detail_show = 'd-none';

        $this->selected_item_id = null;
        $this->selected_role_id = null;
        $this->selected_user_id = null;
        $this->selected_payment_id = null;

        $this->unit_price_read_only = '';

        $this->Ledger->cash_amount = null;
        $this->Ledger->unit_price = null;
        $this->Ledger->unit_qty = null;
        $this->Ledger->total_amount = null;
        $this->Ledger->payment_type = null;

    }
}
