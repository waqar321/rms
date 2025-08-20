@extends('Admin.layout.main')

@section('content')
        @if(request()->has('id'))
            <div>
                <livewire:admin.report.index :permission="$permission"/>
            </div>
        @else

            <div>
                <livewire:admin.report.index : />
            </div>
        @endif
@endsection

