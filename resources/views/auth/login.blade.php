<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smile Bright Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body { margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden; }
    </style>
</head>

<body class="w-screen h-screen bg-gradient-to-br from-[#E8F0F1] via-[#BDDBD1] to-[#FBF9F1] flex justify-center items-center relative overflow-hidden">

    <!-- Animated background circles -->
    <div class="absolute w-72 h-72 bg-[#C7E7EC] rounded-full opacity-20 animate-pulse -top-32 -left-32"></div>
    <div class="absolute w-96 h-96 bg-[#2F3E3C] rounded-full opacity-10 animate-pulse -bottom-40 -right-40"></div>
    <div class="absolute w-80 h-80 bg-[#E7E9E3] rounded-full opacity-15 animate-pulse top-1/2 left-1/3"></div>

    <!-- Back to Home Button in Top-Left -->
    <a href="/" 
       class="absolute top-6 left-6 px-4 py-2 bg-[#C7E7EC] text-[#2F3E3C] rounded-full font-semibold shadow hover:bg-[#AED9D1] hover:scale-105 transition-transform flex items-center gap-2 z-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Home
    </a>

    <!-- Login Form Card -->
    <div class="relative z-10 w-full max-w-md bg-[#FBF9F1] p-8 rounded-3xl shadow-2xl space-y-6">

        <h2 class="text-4xl font-extrabold text-[#2F3E3C] text-center mb-4 animate-bounce">Welcome Back</h2>
        <p class="text-center text-[#2F3E3C] opacity-80 mb-6">Login to manage your appointments and track your dental treatments.</p>

       <!-- Session & Validation Messages -->
@if(session('success'))
    <div class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
    </div>
@endif

@if(session('role_error'))
    <div class="alert bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
        {{ session('role_error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Role Selection -->
            <div>
                <label for="role_id" class="block text-[#2F3E3C] font-medium mb-1">Select Role</label>
                <select id="role_id" name="role_id" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
                    <option value="">-- Choose Role --</option>
                    <option value="1">Patient</option>
                    <option value="2">Dentist</option>
                    <option value="3">Receptionist</option>
                    <option value="4">Admin</option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-[#2F3E3C] font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" required autofocus
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-[#2F3E3C] font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2F3E3C]">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-[#2F3E3C]">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 focus:ring-2 focus:ring-[#2F3E3C]">
                    Remember Me
                </label>
                <a href="/forgot-password" class="text-sm text-[#2F3E3C] hover:text-[#3F4E4C]">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-[#2F3E3C] to-[#3F4E4C] text-[#FBF9F1] font-semibold rounded-2xl shadow-lg hover:scale-105 transition-transform">
                Login
            </button>
        </form>

        <p class="text-center text-[#2F3E3C] opacity-80 mt-4">
            Don't have an account? 
            <a href="/register" class="text-[#3F4E4C] font-semibold hover:underline">Sign up</a>
        </p>

    </div>

</body>
</html>
