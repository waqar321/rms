@extends('Admin.layout.main')

@section('content')

        @if(request()->has('id'))
            <div>    
                <livewire:admin.ledger.index :permission="$permission"/>    
            </div>
        @else 

            <div>    
                <livewire:admin.ledger.index : />    
            </div>
        @endif
@endsection 

