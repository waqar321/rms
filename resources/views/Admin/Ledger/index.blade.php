@extends('Admin.layout.main')

@section('content')

        @if(request()->has('id'))
            <div>
                <livewire:admin.ledger.index :ledger="$ledger"/>
            </div>
        @elseif(request()->has('customer_id'))
            <div>
                <livewire:admin.ledger.index :ledger="$ledger"/>
            </div>
        @else

            <div>
                <livewire:admin.ledger.index : />
            </div>
        @endif
@endsection

