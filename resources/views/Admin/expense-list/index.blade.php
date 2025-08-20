@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>
                <livewire:admin.expense-list.index :permission="$permission"/>
            </div>
        @else

            <div>
                <livewire:admin.expense-list.index : />
            </div>
        @endif
@endsection

