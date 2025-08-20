
<?php
use App\Models\Admin\SideBar;
use App\Models\Admin\Item;

function getPageTitle()
{
    $all_segments = request()->segments();
    $pageTitle = implode("/", $all_segments);

    if (count($all_segments) == 2)
    {
        $pageTitle = implode("/", $all_segments);
    }

    $sideBar = SideBar::where('url', $pageTitle)->first();
    $title = '';

    if ($sideBar) {
        $title = $sideBar->title;
    }

    return $title;
}

function formatIndianNumber($number)
{
    $decimal = '';
    if (strpos($number, '.') !== false) {
        list($number, $decimal) = explode('.', number_format((float)$number, 2, '.', ''));
    }

    $lastThree = substr($number, -3);
    $restUnits = substr($number, 0, -3);
    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $number = $restUnits . "," . $lastThree;
    } else {
        $number = $lastThree;
    }

    return $decimal ? $number . '.' . $decimal : $number;
}

function GetItemDetailsForPrinting($PurchaseOrPurchase, $Receipt=false)
{
    if($Receipt)
    {
        $PurchaseOrPurchase->load(['receiptItems', 'entry_person', 'vendor']);
        $details_of_items = $PurchaseOrPurchase->receiptItems->KeyBy('item_id')->toArray();
    }
    else
    {
        $PurchaseOrPurchase->load(['purchaseItems', 'entry_person', 'vendor']);
        $details_of_items = $PurchaseOrPurchase->purchaseItems->KeyBy('item_id')->toArray();
    }

    $item_ds = array_keys($details_of_items);
    $itemDetails = Item::select('id','name', 'price', 'image_path')->whereIn('id', $item_ds)->get()->KeyBy('id')->toArray();
    // dd($itemDetails);

    foreach ($details_of_items as $item)
    {
        $itemDetail = $itemDetails[$item['item_id']];

        $cart[$item['item_id']] = [
            'id'         => $item['item_id'],
            'name'       => $itemDetail['name'],
            'price'      => $itemDetail['price'],
            'image_path' => $itemDetail['image_path'],
            'qty'        => $item['item_qty'],
            'subtotal'   => $item['item_sub_total'],
        ];
    }

    session()->put('cart', $cart);
    return route('print.receipt');
}
?>
