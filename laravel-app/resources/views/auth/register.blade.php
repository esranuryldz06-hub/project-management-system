
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Create Account') }} | ProjectFlow</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f3e8ff, #e9d5ff, #ddd6fe);
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(80, 40, 120, 0.12);
        }

        .language {
            text-align: right;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .language a {
            color: #7c3aed;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .logo {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
            font-size: 14px;
        }

        h2 {
            color: #29213b;
            margin-bottom: 8px;
        }

        .description {
            color: #888;
            font-size: 14px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #444;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            margin-bottom: 18px;
            outline: none;
        }

        input:focus {
            border-color: #8b5cf6;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #7c3aed;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #6d28d9;
        }

        .footer {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #7c3aed;
            text-decoration: none;
            font-weight: bold;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="language">
            <a href="/language/en">EN</a>
            <a href="/language/pl">PL</a>
        </div>

        <div class="logo">✦ ProjectFlow</div>
        <p class="subtitle">{{ __('Manage your projects smarter.') }}</p>

        <h2>{{ __('Create Account') }}</h2>
        <p class="description">{{ __('Join ProjectFlow and organize your work.') }}</p>

        <form method="POST" action="/register">
            @csrf

            <label for="name">{{ __('Full Name') }}</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="{{ __('Enter your name') }}"
                required
            >

            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="email">{{ __('Email Address') }}</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="{{ __('Enter your email') }}"
                required
            >

            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password">{{ __('Password') }}</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="{{ __('At least 8 characters') }}"
                required
            >

            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="{{ __('Repeat your password') }}"
                required
            >

            <button type="submit">{{ __('Create Account') }} →</button>
        </form>

        <div class="footer">
            {{ __('Already have an account?') }}
            <a href="/login">{{ __('Sign In') }}</a>
        </div>

    </div>
</body>
</html>
