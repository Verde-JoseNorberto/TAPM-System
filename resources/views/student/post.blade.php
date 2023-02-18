@foreach($projects as $key => $project)
<div class="col flex my-2">
  <div class="card">
    <div class="card-body text-center">
      <strong>{{ $project->user->name }}{{ __(' posted an update.') }}</strong>
      <h3 class="card-title">{{ $project->title }}</h3>
      <iframe class="fluid" src="/files/{{ $project->file }}" height="700" width="600"></iframe>
      <h6>{{ $project->description }}</h6>
    </div>
    <div class="card-footer">
      @include('student.feedback', ['feedbacks' => $project->feedbacks, 'project_id' => $project->id])
      <form action="{{ route('student/feedback') }}" method="POST">
        @csrf
        <input class="form-control" type="text" id="comment" name="comment" placeholder="Add Feedback">
        <input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}">
        
        <button type="submit" class="btn btn-secondary text-end">{{ __('Send') }}</button>
      </form>
    </div>
  </div>
</div>
@endforeach