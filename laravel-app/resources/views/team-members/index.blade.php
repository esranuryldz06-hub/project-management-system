
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members - ProjectFlow</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px;
            font-family: Arial, sans-serif;
            background: #f5f4fb;
            color: #292544;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
        }

        .subtitle {
            color: #77738b;
        }

        a {
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 8px;
            background: #6955d9;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .back {
            color: #6955d9;
            display: inline-block;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            text-align: left;
            padding: 16px 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #77738b;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .edit {
            color: #6955d9;
        }

        .delete {
            color: #dc4545;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .success {
            padding: 12px;
            margin-bottom: 20px;
            background: #e5f7eb;
            color: #237342;
            border-radius: 8px;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #77738b;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="/dashboard" class="back">← Back to Dashboard</a>

    <div class="top">
        <div>
            <h1>Team Members</h1>
            <p class="subtitle">Manage your team members.</p>
        </div>

        <a href="/team-members/create" class="btn">
            + Add Member
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        @if($teamMembers->count() > 0)

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($teamMembers as $teamMember)
                        <tr>
                            <td>{{ $teamMember->name }}</td>
                            <td>{{ $teamMember->email ?? '-' }}</td>
                            <td>{{ $teamMember->position ?? '-' }}</td>
                            <td>{{ $teamMember->phone ?? '-' }}</td>

                            <td>
                                <div class="actions">

                                    <a
                                        class="edit"
                                        href="/team-members/{{ $teamMember->id }}/edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="/team-members/{{ $teamMember->id }}"
                                        onsubmit="return confirm('Are you sure you want to delete this member?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else

            <div class="empty">
                <h3>No team members yet</h3>
                <p>Add your first team member to get started.</p>
            </div>

        @endif

    </div>

</div>

</body>
</html>