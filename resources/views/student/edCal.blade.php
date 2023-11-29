  <!-- View Event Modal -->
  <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Event Details') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('student/eveUp') }}">
            @csrf
            @method('PUT')

            <input type="hidden" id="id" name="id" class="viewEventModalId">

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Title') }}</label>
                  <input id="title" type="text" class="viewEventModalTitle form-control" name="title">
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Description') }}</label>
                  <textarea id="description" class="viewEventModalDescription form-control" rows="4" name="description"></textarea>
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('Start') }}</label>
                  <input id="start" type="date" class="viewEventModalStart form-control" name="start">
                </div>
              </div>

              <div class="col">
                <div class="form-outline">
                  <label class="form-label">{{ __('End') }}</label>
                  <input id="end" type="date" class="viewEventModalEnd form-control" name="end">
                </div>
              </div>
            </div>

            <input id="group_project_id" type="hidden" name="group_project_id" value="{{ $group_projects->id }}">
        </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Update Event') }}</button>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal">
            {{ __('Delete') }}
            </a>
          </div>
          <form>
      </div>
    </div>
  </div>