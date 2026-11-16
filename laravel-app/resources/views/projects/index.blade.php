
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('My Projects') }} | ProjectFlow</title>

    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { margin: 0; padding: 35px; background: #f7f5fc; color: #29213b; }
        .container { max-width: 1000px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap; }
        h1 { color: #7c3aed; }
        a, button { text-decoration: none; cursor: pointer; }
        .btn { display: inline-block; padding: 11px 18px; background: #7c3aed; color: white; border: 0; border-radius: 8px; }
        .back { color: #7c3aed; }
        .project { background: white; padding: 22px; margin-bottom: 15px; border-radius: 12px; border: 1px solid #eee; }
        .project h3 { margin-top: 0; }
        .status { color: #7c3aed; font-weight: bold; }
        .role { display: inline-block; padding: 5px 9px; background: #ede9fe; color: #6d28d9; border-radius: 6px; font-size: 13px; }
        .actions { display: flex; gap: 15px; margin-top: 15px; align-items: center; flex-wrap: wrap; }
        .actions a { color: #7c3aed; }
        .delete { background: #dc2626; color: white; border: 0; padding: 8px 12px; border-radius: 6px; }
        .empty { background: white; padding: 35px; text-align: center; border-radius: 12px; color: #888; }
        .success { background: #dcfce7; padding: 12px; margin-bottom: 20px; border-radius: 8px; color: #166534; }
        .muted { color: #777; }
        .language { text-align: right; margin-bottom: 20px; }
        .language a { color: #7c3aed; margin-left: 10px; }
    </style>
</head>

<body>
<div class="container">

    <div class="language">
        <a href="/language/en">EN</a>
        <a href="/language/pl">PL</a>
    </div>

    <div class="header">
        <div>
            <h1>{{ __('My Projects') }}</h1>
            <a class="back" href="/dashboard">← {{ __('Back to Dashboard') }}</a>
        </div>

        <a class="btn" href="/projects/create">+ {{ __('Create Project') }}</a>
    </div>

    @if(session('success'))
        <div class="success">{{ __(session('success')) }}</div>
    @endif

    @forelse($projects as $project)

        @php
            $isManager = $project->user_id === auth()->id();

            $statusLabel = $project->status === 'in_progress'
                ? 'In Progress'
                : ucfirst($project->status);
        @endphp

        <div class="project">
            <h3>{{ $project->name }}</h3>

            <span class="role">
                {{ $isManager ? __('Project Manager') : __('Team Member') }}
            </span>

            <p>{{ $project->description ?? __('No description provided.') }}</p>

            <p class="status">
                {{ __('Status') }}: {{ __($statusLabel) }}
            </p>

            <p>
                <strong>{{ __('Project Price') }}:</strong>
                {{ number_format($project->price, 2) }}
                <br>
                <strong>{{ __('Done Jobs') }}:</strong>
                {{ $project->done_jobs }}
            </p>

            <p>
                <strong>{{ __('Start Date') }}:</strong>
                {{ $project->start_date ?? __('Not specified') }}
                <br>
                <strong>{{ __('End Date') }}:</strong>
                {{ $project->end_date ?? __('Not specified') }}
            </p>

            <p>
                <strong>{{ __('Project Manager') }}:</strong>
                {{ $project->user->name ?? 'Unknown' }}
            </p>

            <p>
                <strong>{{ __('Team Members') }}:</strong>
                @forelse($project->teamMembers as $member)
                    {{ $member->name }}@if(!$loop->last), @endif
                @empty
                    <span class="muted">{{ __('No team members assigned.') }}</span>
                @endforelse
            </p>

            <div class="actions">
                <a href="/projects/{{ $project->id }}">
                    {{ __('View Details') }}
                </a>

                <a href="/projects/{{ $project->id }}/edit">
                    {{ $isManager ? __('Edit Project') : __('Update Done Jobs') }}
                </a>

                @if($isManager)
                    <form
                        method="POST"
                        action="/projects/{{ $project->id }}"
                        data-confirm-message="{{ __('Are you sure you want to delete this project?') }}"
                        onsubmit="return confirm(this.dataset.confirmMessage)"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="delete" type="submit">
                            {{ __('Delete') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

    @empty
        <div class="empty">
            <h3>{{ __('No projects yet.') }}</h3>
            <p>{{ __('Projects you create or join will appear here.') }}</p>
        </div>
    @endforelse

</div>
</body>
</html>
