@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.vendor.index :permission="$permission"/>    
            </div>
        @else 

            <div>    
                <livewire:admin.vendor.index : />    
            </div>
        @endif
@endsection 

