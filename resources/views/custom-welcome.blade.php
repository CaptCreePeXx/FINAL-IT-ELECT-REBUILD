<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smile Point Dental Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body { 
            margin: 0; 
            padding: 0; 
            width: 100%; 
            min-height: 100%; 
            overflow-x: hidden;
        }

        /* Bounce animation for hero title */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .bounce {
            animation: bounce 2s infinite;
        }
    </style>
</head>

<body class="w-screen min-h-screen bg-gradient-to-br from-[#E8F0F1] via-[#BDDBD1] to-[#FBF9F1] flex flex-col items-center pt-20">

    <!-- Background Circles -->
    <div class="absolute w-72 h-72 bg-[#C7E7EC] rounded-full opacity-20 -top-32 -left-32"></div>
    <div class="absolute w-96 h-96 bg-[#2F3E3C] rounded-full opacity-10 -bottom-40 -right-40"></div>
    <div class="absolute w-80 h-80 bg-[#E7E9E3] rounded-full opacity-15 top-1/2 left-1/3"></div>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="relative z-10 w-full max-w-6xl text-center px-6">

        <!-- Hero Title -->
        <h1 class="bounce text-5xl md:text-6xl font-extrabold mb-4 text-[#2F3E3C] drop-shadow-lg">
            Welcome to 
            <span class="relative">
                Smile Point
                <span class="absolute bottom-0 left-0 w-full h-1 bg-[#000000] rounded-full"></span>
            </span>
            Dental Clinic
        </h1>

        <p class="text-lg md:text-xl text-[#000000] mb-10">
            Your trusted partner for healthy, bright smiles. Manage appointments, track treatments, 
            and stay updated—all in one place!
        </p>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-16">
            <a href="/login" 
               class="flex items-center justify-center gap-3 px-10 py-4 bg-gradient-to-r from-[#2F3E3C] to-[#3F4E4C] 
                      text-[#FBF9F1] rounded-full font-semibold shadow-xl hover:scale-105 transition-transform">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Login
            </a>

            <a href="/register" 
               class="flex items-center justify-center gap-3 px-10 py-4 bg-[#C7E7EC] border-2 border-[#2F3E3C] 
                      text-[#2F3E3C] rounded-full font-semibold shadow-lg hover:bg-[#AED9D1] hover:scale-105 transition-transform">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Register
            </a>
        </div>

        <!-- Why Choose Section -->
        <div class="mt-6 mb-8 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-[#2F3E3C] mb-4">Why Choose Smile Point?</h2>
            <p class="text-[#2F3E3C] text-sm md:text-base">
                Our Dental Clinic Management System helps you manage appointments, patient records, and treatments 
                effortlessly. Stay organized, reduce errors, and provide your patients with a seamless experience.
            </p>
        </div>

        <!-- Features Grid (MATCHING SERVICE CARD STYLE) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">

            <!-- Card -->
            <div class="p-8 bg-[#FBF9F1] border-2 border-[#2F3E3C] rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Appointments</h3>
                <p class="text-[#2F3E3C] text-sm">Schedule, approve, and track patient appointments with ease.</p>
            </div>

            <div class="p-8 bg-[#FBF9F1] border-2 border-[#2F3E3C] rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Secure & Reliable</h3>
                <p class="text-[#2F3E3C] text-sm">Your data is protected and only accessible to authorized users.</p>
            </div>

            <div class="p-8 bg-[#FBF9F1] border-2 border-[#2F3E3C] rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Track Progress</h3>
                <p class="text-[#2F3E3C] text-sm">Monitor procedures, treatments, and recovery easily.</p>
            </div>

            <div class="p-8 bg-[#FBF9F1] border-2 border-[#2F3E3C] rounded-3xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                <h3 class="text-xl font-bold text-[#2F3E3C] mb-2">Reports & Analytics</h3>
                <p class="text-[#2F3E3C] text-sm">Analyze clinic performance with in-depth reports.</p>
            </div>
        </div>

        <!-- SERVICES (SWAPPED ABOVE MISSION) -->
        <div class="mt-20 flex justify-center">
            <div class="p-8 w-full max-w-md bg-[#FBF9F1] border-2 border-[#2F3E3C] 
            rounded-3xl shadow-lg transform transition-transform duration-300 hover:scale-105">
                <h2 class="text-2xl font-bold text-center mb-6 text-[#2F3E3C]">Services Offered</h2>
                <ul class="space-y-4 text-left text-base md:text-lg text-[#2F3E3C]">
                    <li><span class="font-semibold">Teeth Cleaning:</span> Removes plaque, tartar, and stains.</li>
                    <li><span class="font-semibold">Tooth Extraction:</span> Safe removal of damaged teeth.</li>
                    <li><span class="font-semibold">Dental Filling:</span> Restores teeth with cavities.</li>
                    <li><span class="font-semibold">Root Canal:</span> Removes infection and saves teeth.</li>
                    <li><span class="font-semibold">Braces Consultation:</span> Orthodontic evaluation.</li>
                    <li><span class="font-semibold">Check-up:</span> Routine oral examinations.</li>
                </ul>
            </div>
        </div>

        <!-- Mission Statement -->
        <div class="mt-24 max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#2F3E3C] mb-4">Our Mission</h2>
            <p class="text-[#2F3E3C] text-base md:text-lg leading-relaxed">
                At Smile Point Dental Clinic, we aim to deliver high-quality, accessible, and compassionate dental care. 
                Our commitment is to ensure your comfort, confidence, and long-term oral health.
            </p>
        </div>

        <!-- Testimonials -->
        <div class="mt-24">
            <h2 class="text-3xl font-bold text-center text-[#2F3E3C] mb-10">What Our Patients Say</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto px-4">

                <div class="bg-[#FBF9F1] p-6 rounded-3xl shadow-lg border-2 border-[#2F3E3C] hover:scale-105 transition-transform">
                    <!-- Star Rating -->
                    <div class="flex text-3xl font-bold mb-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-transparent bg-clip-text">
                        ★★★★★
                    </div>

                    <p class="text-[#2F3E3C] italic mb-3">“Very friendly staff and excellent service!”</p>
                    <p class="font-semibold text-[#2F3E3C]">— Maria F.</p>
                </div>

                <div class="bg-[#FBF9F1] p-6 rounded-3xl shadow-lg border-2 border-[#2F3E3C] hover:scale-105 transition-transform">
                    <!-- Star Rating -->
                    <div class="flex text-3xl font-bold mb-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-transparent bg-clip-text">
                        ★★★★★
                    </div>

                    <p class="text-[#2F3E3C] italic mb-3">“Booking appointments online was so easy, the system keeps everything organized!”</p>
                    <p class="font-semibold text-[#2F3E3C]">— Joseph D.</p>
                </div>

                <div class="bg-[#FBF9F1] p-6 rounded-3xl shadow-lg border-2 border-[#2F3E3C] hover:scale-105 transition-transform">
                    <!-- Star Rating -->
                    <div class="flex text-3xl font-bold mb-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-transparent bg-clip-text">
                        ★★★★★
                    </div>

                    <p class="text-[#2F3E3C] italic mb-3">“Clean clinic and very accommodating staff. I feel confident booking through their system!”</p>
                    <p class="font-semibold text-[#2F3E3C]">— Angela R.</p>
                </div>

            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-24 mb-16 text-center">
            <h2 class="text-3xl font-bold text-[#2F3E3C] mb-4">Ready for a Brighter Smile?</h2>
            <p class="text-[#2F3E3C] mb-6">Book your dental appointment with us today!</p>

            <a href="/login"
                class="inline-flex items-center justify-center px-10 py-4 bg-gradient-to-r from-[#2F3E3C] to-[#3F4E4C] 
                    text-[#FBF9F1] rounded-full font-semibold shadow-xl 
                    transform transition duration-300 hover:scale-105">
                Book an Appointment Today
            </a>
        </div>

        <!-- Footer -->
        <p class="mt-10 mb-10 text-sm text-[#2F3E3C] opacity-80">
            © 2025 Smile Point Dental Clinic. All Rights Reserved.
        </p>

    </div>

</body>
</html>
