@foreach ($feedbacks as $key => $feedback)
<div class="d-flex">
    <p><strong> {{ ($feedback->user->name .': ') }}</strong>{{ $feedback->comment}}</p>
</div>
@endforeach
