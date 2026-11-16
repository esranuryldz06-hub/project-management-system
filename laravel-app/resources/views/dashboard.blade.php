<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Dashboard') }} | ProjectFlow</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f5fc;
            color: #29213b;
        }

        .sidebar {
            position: fixed;
            width: 230px;
            height: 100vh;
            background: white;
            padding: 30px 20px;
            border-right: 1px solid #eee;
        }

        .logo {
            color: #7c3aed;
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 45px;
        }

        .nav-item {
            display: block;
            padding: 13px;
            margin-bottom: 10px;
            border-radius: 9px;
            color: #777;
            text-decoration: none;
        }

        .nav-item.active {
            background: #f1eaff;
            color: #7c3aed;
            font-weight: bold;
        }

        .main {
            margin-left: 230px;
            padding: 35px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .topbar p {
            color: #888;
            margin-top: 7px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .language a {
            color: #7c3aed;
            text-decoration: none;
            padding: 9px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
        }

        .language a.selected {
            background: #f1eaff;
            border-color: #7c3aed;
            font-weight: bold;
        }

        .logout button {
            padding: 10px 18px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #7c3aed;
            cursor: pointer;
        }

        .welcome {
            background: linear-gradient(120deg, #7c3aed, #a78bfa);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .welcome h2 {
            margin-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 13px;
            border: 1px solid #eee;
        }

        .stat-card p {
            color: #888;
            margin-bottom: 12px;
        }

        .stat-card h2 {
            color: #7c3aed;
            font-size: 28px;
        }

        .project-section {
            background: white;
            padding: 25px;
            border-radius: 13px;
            border: 1px solid #eee;
            margin-bottom: 25px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .create-link {
            background: #7c3aed;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .project-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 15px;
        }

        .project-card:last-child {
            margin-bottom: 0;
        }

        .project-card h4 {
            margin-bottom: 12px;
            color: #39265d;
        }

        .project-info {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            color: #777;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #f1eaff;
            color: #7c3aed;
            font-size: 12px;
        }

        .project-link {
            color: #7c3aed;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .empty {
            color: #999;
            padding: 25px 0;
            text-align: center;
        }

        @media (max-width: 750px) {
            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="logo">✦ ProjectFlow</div>

        <a href="/dashboard" class="nav-item active">
            ▦ {{ __('Dashboard') }}
        </a>

        <a href="/projects" class="nav-item">
            ▣ {{ __('My Projects') }}
        </a>
    </aside>

    <main class="main">

        <div class="topbar">
            <div>
                <h2>{{ __('Dashboard') }}</h2>
                <p>{{ __('Welcome to your workspace.') }}</p>
            </div>

            <div class="top-actions">
                <div class="language">
                    <a href="/language/en"
                       class="{{ app()->getLocale() === 'en' ? 'selected' : '' }}">
                        EN
                    </a>

                    <a href="/language/pl"
                       class="{{ app()->getLocale() === 'pl' ? 'selected' : '' }}">
                        PL
                    </a>
                </div>

                <form class="logout" method="POST" action="/logout">
                    @csrf
                    <button type="submit">{{ __('Log Out') }}</button>
                </form>
            </div>
        </div>

        <section class="welcome">
            <h2>{{ __('Hello, :name!', ['name' => auth()->user()->name]) }} 👋</h2>
            <p>{{ __('Manage your projects and collaborate with your team.') }}</p>
        </section>

        <section class="stats">
            <div class="stat-card">
                <p>{{ __('Total Projects') }}</p>
                <h2>{{ $totalProjects }}</h2>
            </div>

            <div class="stat-card">
                <p>{{ __('Completed Projects') }}</p>
                <h2>{{ $completedProjects }}</h2>
            </div>

            <div class="stat-card">
                <p>{{ __('Team Members') }}</p>
                <h2>{{ $teamMembers }}</h2>
            </div>
        </section>

        <section class="project-section">
            <div class="section-heading">
                <h3>{{ __('Projects I Manage') }}</h3>
                <a href="/projects/create" class="create-link">
                    + {{ __('Create Project') }}
                </a>
            </div>

            @forelse ($managedProjects as $project)
                <div class="project-card">
                    <h4>{{ $project->name }}</h4>

                    <div class="project-info">
                        <span>
                            {{ __('Status') }}:
                            <span class="status">
                                @if ($project->status === 'in_progress')
                                    {{ __('In Progress') }}
                                @else
                                    {{ __(\Illuminate\Support\Str::ucfirst($project->status)) }}
                                @endif
                            </span>
                        </span>

                        <span>{{ __('Price') }}: {{ number_format((float) $project->price, 2) }}</span>

                        <span>{{ __('Jobs Completed') }}: {{ $project->done_jobs }}</span>

                        <span>{{ __('Team Members') }}: {{ $project->teamMembers->count() }}</span>
                    </div>

                    <a href="/projects/{{ $project->id }}" class="project-link">
                        {{ __('View Details') }} →
                    </a>
                    &nbsp; | &nbsp;
                    <a href="/projects/{{ $project->id }}/edit" class="project-link">
                        {{ __('Edit Project') }}
                    </a>
                </div>
            @empty
                <div class="empty">
                    {{ __('No projects yet.') }}
                </div>
            @endforelse
        </section>

        <section class="project-section">
            <div class="section-heading">
                <h3>{{ __('Projects I Belong To') }}</h3>
            </div>

            @forelse ($memberProjects as $project)
                <div class="project-card">
                    <h4>{{ $project->name }}</h4>

                    <div class="project-info">
                        <span>
                            {{ __('Status') }}:
                            <span class="status">
                                @if ($project->status === 'in_progress')
                                    {{ __('In Progress') }}
                                @else
                                    {{ __(\Illuminate\Support\Str::ucfirst($project->status)) }}
                                @endif
                            </span>
                        </span>

                        <span>{{ __('Project Manager') }}: {{ $project->user->name }}</span>

                        <span>{{ __('Jobs Completed') }}: {{ $project->done_jobs }}</span>
                    </div>

                    <a href="/projects/{{ $project->id }}" class="project-link">
                        {{ __('View Details') }} →
                    </a>
                    &nbsp; | &nbsp;
                    <a href="/projects/{{ $project->id }}/edit" class="project-link">
                        {{ __('Update Progress') }}
                    </a>
                </div>
            @empty
                <div class="empty">
                    {{ __('No projects yet.') }}
                </div>
            @endforelse
        </section>

    </main>

</body>
</html>