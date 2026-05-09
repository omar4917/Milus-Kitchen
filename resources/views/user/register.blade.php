<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Lilus Kitchen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:300,400,700,800|Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
        }
        .auth-card h2 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 30px;
            text-align: center;
        }
        .auth-card .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #eee;
        }
        .auth-card .form-control:focus {
            border-color: #ff7a5c;
            box-shadow: 0 0 0 3px rgba(255,122,92,0.1);
        }
        .auth-card .btn-primary {
            background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        .auth-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255,122,92,0.4);
        }
        .auth-links {
            text-align: center;
            margin-top: 20px;
        }
        .auth-links a {
            color: #ff7a5c;
        }
        .logo-link {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card" data-aos="fade-up">
            <a href="{{ route('home') }}" class="logo-link">🍽️ Lilus</a>
            <h2>Create Account</h2>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Phone (optional)</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
            
            <div class="auth-links">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                <p><a href="{{ route('home') }}">← Back to Home</a></p>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/aos.js') }}"></script>
    <script>AOS.init();</script>
</body>
</html>
