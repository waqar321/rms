@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.user-management.role.index :role="$role"/>    
            </div>
        @else 
            <div>    
                <livewire:admin.user-management.role.index : />    
            </div>
        @endif
@endsection 

