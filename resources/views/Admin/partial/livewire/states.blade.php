 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Total Sale:
        {{ $readyToLoad ? $states['total_sale'] : 0 }}
    </button>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Partion ko diye:
        {{ $readyToLoad ? $states['ledger_cash'] : 0 }}
    </button>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> udhar pe maal diye:
        {{ $readyToLoad ? $states['ledger_credit_sale'] : 0 }}
    </button>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Total Kharcha:
        {{ $readyToLoad ? $states['total_expense'] : 0 }}
    </button>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Bachi Hui Raqam:
        @if($readyToLoad)
            {{ $states['total_sale'] - ($states['total_expense'] + $states['ledger_cash'] + $states['ledger_credit_sale'] ) }}
        @endif
    </button>
</div>
