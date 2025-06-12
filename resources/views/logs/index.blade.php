@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-3">
        <p class="text-3xl">Logs</p>
        @forelse($logs as $log)
            <div class="flex justify-between items-center bg-white rounded overflow-hidden">
                <div class="flex gap-2 items-center">
                    <div class="py-6 px-1
                            @if($log->type == 'red') bg-red-500
                            @elseif($log->type == 'green')  bg-green-500
                            @elseif($log->type == 'orange')  bg-yellow-500
                            @endif h-full"></div>
                    <p class="text-lg">{{$log->message}}</p>
                </div>
                <p class="text-lg px-2">{{\Carbon\Carbon::parse($log->created_at)->format('F m, Y H:i')}}</p>
            </div>
        @empty
            <p>No Log is saved.</p>
        @endforelse

    </div>
@endsection
