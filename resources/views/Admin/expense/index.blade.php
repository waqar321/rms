@extends('Admin.layout.main')

@section('content')


        @if(request()->has('id'))
            <div>
                <livewire:admin.expense.index :permission="$permission"/>
            </div>
        @else

            <div>
                <livewire:admin.expense.index : />
            </div>
        @endif
@endsection

