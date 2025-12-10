<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smile Point Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body { margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden; }
    </style>
</head>

<body class="w-screen h-screen bg-gradient-to-br from-[#E8F0F1] via-[#BDDBD1] to-[#FBF9F1] flex flex-col justify-center items-center relative overflow-hidden">

    
    <!-- Animated background circles -->
    <div class="absolute w-72 h-72 bg-[#C7E7EC] rounded-full opacity-20 animate-pulse -top-32 -left-32"></div>
    <div class="absolute w-96 h-96 bg-[#2F3E3C] rounded-full opacity-10 animate-pulse -bottom-40 -right-40"></div>
    <div class="absolute w-80 h-80 bg-[#E7E9E3] rounded-full opacity-15 animate-pulse top-1/2 left-1/3"></div>

    <!-- Hero content -->
    <div class="relative z-10 w-full max-w-6xl text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-4 animate-bounce text-[#2F3E3C] drop-shadow-lg">
            Welcome to 
            <span class="relative">
                Smile Point
                <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#000000] to-[#000000] rounded-full animate-pulse"></span>
            </span>
            Dental Clinic
        </h1>
        <p class="text-lg md:text-xl text-[#000000] mb-8">Your trusted partner for healthy, bright smiles. Manage appointments, track treatments, and stay updated—all in one place!</p>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-8 relative z-10 animate-bounce-slow">

    <a href="/login" 
       class="flex items-center justify-center gap-3 px-10 py-4 bg-gradient-to-r from-[#2F3E3C] to-[#3F4E4C] text-[#FBF9F1] rounded-full font-semibold shadow-2xl hover:scale-105 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
        </svg>
        Login
    </a>
    <a href="/register" 
       class="flex items-center justify-center gap-3 px-10 py-4 bg-[#C7E7EC] border-2 border-[#2F3E3C] text-[#2F3E3C] rounded-full font-semibold shadow-lg hover:bg-[#AED9D1] hover:scale-105 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Register
    </a>
</div>


        <!-- Features -->

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="p-6 bg-[#E7E9E3] rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Appointments</h3>
                <p class="text-[#2F3E3C] text-sm">Schedule, approve, and track patient appointments efficiently.</p>
            </div>
            <div class="p-6 bg-[#E7E9E3] rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Patient Records</h3>
                <p class="text-[#2F3E3C] text-sm">Access detailed patient information and treatment history at a glance.</p>
            </div>
            <div class="p-6 bg-[#E7E9E3] rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Notifications</h3>
                <p class="text-[#2F3E3C] text-sm">Receive real-time alerts for appointments, cancellations, and updates.</p>
            </div>
            <div class="p-6 bg-[#E7E9E3] rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Track Progress</h3>
                <p class="text-[#2F3E3C] text-sm">Monitor treatments and procedures for better patient outcomes.</p>
            </div>
            
        </div>

        
        <!-- Footer -->
        <p class="mt-16 text-sm text-[#2F3E3C] opacity-80">© 2025 Smile Bright Dental Clinic. All Rights Reserved.</p>
    </div>

</body>
</html>
