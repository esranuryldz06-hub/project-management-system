<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Project') }} | ProjectFlow</title>

    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { margin: 0; padding: 35px; background: #f7f5fc; color: #29213b; }
        .container { max-width: 650px; margin: auto; background: white; padding: 30px; border-radius: 14px; }
        h1 { color: #7c3aed; }
        label { display: block; margin: 18px 0 7px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 7px; }
        textarea { min-height: 100px; resize: vertical; }
        select[multiple] { min-height: 130px; }
        button { margin-top: 22px; padding: 12px 20px; background: #7c3aed; color: white; border: 0; border-radius: 8px; cursor: pointer; }
        a { color: #7c3aed; text-decoration: none; }
        .error { color: #dc2626; margin-top: 6px; font-size: 14px; }
        .hint { color: #888; font-size: 13px; margin-top: 6px; }
        .language { text-align: right; margin-bottom: 20px; }
        .language a { margin-left: 10px; }
    </style>
</head>

<body>
<div class="container">

    <div class="language">
        <a href="/language/en">EN</a>
        <a href="/language/pl">PL</a>
    </div>

    @if($isManager)

        <h1>{{ __('Edit Project') }}</h1>

        <p><a href="/projects">← {{ __('Back to My Projects') }}</a></p>

        <form method="POST" action="/projects/{{ $project->id }}">
            @csrf
            @method('PUT')

            <label for="name">{{ __('Project Name') }} *</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $project->name) }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description">{{ old('description', $project->description) }}</textarea>

            <label for="price">{{ __('Project Price') }} *</label>
            <input type="number" id="price" name="price"
                   step="0.01" min="0"
                   value="{{ old('price', $project->price) }}" required>
            @error('price')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="done_jobs">{{ __('Done Jobs') }} *</label>
            <input type="number" id="done_jobs" name="done_jobs"
                   min="0" step="1"
                   value="{{ old('done_jobs', $project->done_jobs) }}" required>
            @error('done_jobs')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date" id="start_date" name="start_date"
                   value="{{ old('start_date', $project->start_date ? \Illuminate\Support\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}">

            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date" id="end_date" name="end_date"
                   value="{{ old('end_date', $project->end_date ? \Illuminate\Support\Carbon::parse($project->end_date)->format('Y-m-d') : '') }}">

            <label for="status">{{ __('Project Status') }} *</label>
            <select id="status" name="status" required>
                <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
            </select>

            <label for="team_members">{{ __('Project Team Members') }}</label>
            <select id="team_members" name="team_members[]" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ in_array($user->id, old('team_members', $project->teamMembers->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>

            <p class="hint">{{ __('Hold Ctrl (Windows) or Command (Mac) to select multiple users.') }}</p>

            <button type="submit">{{ __('Save Changes') }}</button>
        </form>

    @else

        <h1>{{ __('Update Progress') }}</h1>

        <p><a href="/projects">← {{ __('Back to My Projects') }}</a></p>

        <h3>{{ $project->name }}</h3>
        <p>{{ $project->description }}</p>

        <form method="POST" action="/projects/{{ $project->id }}">
            @csrf
            @method('PUT')

            <label for="done_jobs">{{ __('Done Jobs') }} *</label>
            <input type="number" id="done_jobs" name="done_jobs"
                   min="0" step="1"
                   value="{{ old('done_jobs', $project->done_jobs) }}" required>

            @error('done_jobs')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">{{ __('Update Progress') }}</button>
        </form>

    @endif

</div>
</body>
</html>