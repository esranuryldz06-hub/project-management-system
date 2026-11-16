<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('View Details') }} | ProjectFlow</title>

    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { margin: 0; padding: 35px; background: #f7f5fc; color: #29213b; }
        .container { max-width: 750px; margin: auto; }
        .card { background: white; padding: 30px; border-radius: 14px; border: 1px solid #eee; }
        h1 { color: #7c3aed; }
        .item { margin: 22px 0; }
        .item strong { display: block; margin-bottom: 8px; }
        .status { color: #7c3aed; font-weight: bold; }
        a { color: #7c3aed; text-decoration: none; }
        .btn { display: inline-block; padding: 11px 18px; background: #7c3aed; color: white; border-radius: 8px; margin: 15px 10px 0 0; }
        .back { display: inline-block; margin-bottom: 20px; }
        .member { padding: 9px 12px; background: #f7f5fc; border-radius: 7px; margin: 7px 0; }
        .role { display: inline-block; padding: 5px 9px; background: #ede9fe; color: #6d28d9; border-radius: 6px; font-size: 13px; }
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

    @php
        $isManager = $project->user_id === auth()->id();
    @endphp

    <a class="back" href="/projects">← {{ __('Back to My Projects') }}</a>

    <div class="card">
        <h1>{{ $project->name }}</h1>

        <span class="role">
            {{ $isManager ? __('Project Manager') : __('Team Member') }}
        </span>

        <div class="item">
            <strong>{{ __('Description') }}</strong>
            <p>{{ $project->description ?? __('No description provided.') }}</p>
        </div>

        <div class="item">
            <strong>{{ __('Project Manager') }}</strong>
            <p>{{ $project->user->name ?? 'Unknown' }}</p>
        </div>

        <div class="item">
            <strong>{{ __('Project Price') }}</strong>
            <p>{{ number_format($project->price, 2) }}</p>
        </div>

        <div class="item">
            <strong>{{ __('Done Jobs') }}</strong>
            <p>{{ $project->done_jobs }}</p>
        </div>

        <div class="item">
            <strong>{{ __('Project Status') }}</strong>
            <p class="status">
                @if ($project->status === 'in_progress')
                    {{ __('In Progress') }}
                @else
                    {{ __(\Illuminate\Support\Str::ucfirst($project->status)) }}
                @endif
            </p>
        </div>

        <div class="item">
            <strong>{{ __('Start Date') }}</strong>
            <p>{{ $project->start_date ?? __('Not specified') }}</p>
        </div>

        <div class="item">
            <strong>{{ __('End Date') }}</strong>
            <p>{{ $project->end_date ?? __('Not specified') }}</p>
        </div>

        <div class="item">
            <strong>{{ __('Team Members') }}</strong>

            @forelse($project->teamMembers as $member)
                <div class="member">
                    {{ $member->name }} — {{ $member->email }}
                </div>
            @empty
                <p>{{ __('No team members assigned.') }}</p>
            @endforelse
        </div>

        <div class="item">
            <strong>{{ __('Created At') }}</strong>
            <p>{{ $project->created_at->format('d M Y, H:i') }}</p>
        </div>

        <a class="btn" href="/projects/{{ $project->id }}/edit">
            {{ $isManager ? __('Edit Project') : __('Update Done Jobs') }}
        </a>
    </div>

</div>
</body>
</html>