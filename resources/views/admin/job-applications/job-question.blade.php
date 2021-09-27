@if(count($jobQuestion) > 0)
    @forelse($jobQuestion as $question)
        <div class="form-group">
            <label class="control-label" for="answer[{{ $question->id}}]">
                {{ $question->question }}
            </label>
            <input
                class="form-control"
                type="text"
                id="answer[{{ $question->id}}]"
                name="answer[{{ $question->id}}]"
                placeholder="@lang('modules.front.yourAnswer')"
                @if (count($question->answers) > 0) value="{{ $question->answers->first()->answer }}" @endif
            >
        </div>
    @empty
    @endforelse
@endif