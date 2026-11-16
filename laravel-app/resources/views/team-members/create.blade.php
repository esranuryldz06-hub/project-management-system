
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team Member - ProjectFlow</title>

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
            max-width: 650px;
            margin: auto;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #6955d9;
            text-decoration: none;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        h1 {
            margin-top: 0;
        }

        .subtitle {
            color: #77738b;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #6955d9;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            background: #6955d9;
            color: white;
            cursor: pointer;
        }

        .cancel {
            color: #77738b;
            text-decoration: none;
            margin-left: 15px;
        }

        .error {
            color: #dc4545;
            font-size: 13px;
            margin-top: -14px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="/team-members" class="back">← Back to Team Members</a>

    <div class="card">

        <h1>Add Team Member</h1>
        <p class="subtitle">Enter the information of your new team member.</p>

        <form method="POST" action="/team-members">
            @csrf

            <label for="name">Full Name *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter full name"
                required
            >
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter email address"
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="position">Position</label>
            <input
                type="text"
                id="position"
                name="position"
                value="{{ old('position') }}"
                placeholder="e.g. Developer, Designer"
            >
            @error('position')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="phone">Phone Number</label>
            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Enter phone number"
            >
            @error('phone')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn">
                Add Member
            </button>

            <a href="/team-members" class="cancel">Cancel</a>

        </form>

    </div>

</div>

</body>
</html>