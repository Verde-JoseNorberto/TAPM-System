@foreach ($feedbacks as $key => $feedback)
<div>
    <strong> {{ $feedback->user->name }}</strong>
    <h6>{{ $feedback->comment}}</h6>
</div>
@endforeach
