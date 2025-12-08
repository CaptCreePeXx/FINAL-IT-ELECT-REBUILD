<aside class="w-64 min-h-screen bg-[#2F3E3C] text-[#FBF9F1] shadow-2xl border-r border-[#C7E7EC] flex flex-col py-6">
    <!-- Logo / Title -->
    <div class="px-6 mb-6">
        <h1 class="text-xl font-bold tracking-wide">Patient Panel</h1>
        <div class="mt-1 w-12 h-1 bg-[#C7E7EC] rounded"></div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col gap-1 px-3">
        <a href="{{ route('patient.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent
                  {{ request()->routeIs('patient.dashboard') 
                     ? 'bg-[#C7E7EC] text-[#2F3E3C] font-semibold border-[#FBF9F1]'
                     : 'hover:bg-[#C7E7EC] hover:text-[#2F3E3C]' }}">
            <span class="material-icons text-lg">dashboard</span>
            Dashboard
        </a>

        <a href="{{ route('appointments.create') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent
                  {{ request()->routeIs('appointments.*') 
                     ? 'bg-[#C7E7EC] text-[#2F3E3C] font-semibold border-[#FBF9F1]'
                     : 'hover:bg-[#C7E7EC] hover:text-[#2F3E3C]' }}">
            <span class="material-icons text-lg">event</span>
            Book Appointment
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent
                  {{ request()->routeIs('profile.*') 
                     ? 'bg-[#C7E7EC] text-[#2F3E3C] font-semibold border-[#FBF9F1]'
                     : 'hover:bg-[#C7E7EC] hover:text-[#2F3E3C]' }}">
            <span class="material-icons text-lg">person</span>
            Profile
        </a>
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="px-3 mt-auto mb-3">
        @csrf
        <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left 
                       bg-[#2F3E3C] text-[#FBF9F1] border border-transparent
                       hover:bg-[#BDDBD1] hover:text-[#2F3E3C] hover:border-[#C7E7EC] transition-all">
            <span class="material-icons text-lg">logout</span>
            Logout
        </button>
    </form>
</aside>
