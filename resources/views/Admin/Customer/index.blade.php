@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.customer.index :permission="$permission"/>    
            </div>
        @else 

            <div>    
                <livewire:admin.customer.index : />    
            </div>
        @endif
@endsection 

