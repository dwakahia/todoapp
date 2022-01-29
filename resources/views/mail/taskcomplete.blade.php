@component('mail::message')
# Hello {{$user->name}} !!

Your task {{$task->name}} was checked as {{$task->status == 1 ? 'completed' : 'incomplete'}}.

Task Description <br>
{{$task->description}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
