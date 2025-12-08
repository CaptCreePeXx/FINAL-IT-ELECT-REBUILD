<aside class="w-64 min-h-screen bg-[#2F3E3C] text-[#FBF9F1] shadow-2xl border-r border-[#C7E7EC] flex flex-col py-6">
    <div class="px-6 mb-6">
        <h1 class="text-xl font-bold tracking-wide">Receptionist Panel</h1>
        <div class="mt-1 w-12 h-1 bg-[#C7E7EC] rounded"></div>
    </div>

    <nav class="flex-1 flex flex-col gap-1 px-3">
        <!-- Dashboard -->
        <a href="#" onclick="openTab('dashboard'); return false;"
           id="sidebar-dashboard"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent">
            <span class="material-icons text-lg">dashboard</span>
            Dashboard
        </a>

        <!-- Tabs Links -->
        <a href="#" onclick="openTab('appointments'); return false;"
           id="sidebar-appointments"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent hover:bg-[#C7E7EC] hover:text-[#2F3E3C]">
            <span class="material-icons text-lg">event</span>
            Appointments
        </a>

        <button onclick="openTab('profile')" id="sidebar-profile"
        class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg transition-all">
    <span class="material-icons text-lg">person</span>
    Profile
</button>


    </nav>

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

<script>
function openTab(tabId) {
    const tabs = ['dashboard', 'appointments', 'profile'];

    tabs.forEach(id => {
        const el = document.getElementById('sidebar-' + id);
        if(el) {
            if(id === tabId) {
                el.classList.add('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
            } else {
                el.classList.remove('bg-[#C7E7EC]', 'text-[#2F3E3C]', 'font-semibold', 'border-[#FBF9F1]');
            }
        }
    });

    // Show tab content
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    const content = document.getElementById(tabId);
    if(content) content.classList.remove('hidden');
}

// Initialize dashboard as active on page load
openTab('dashboard');
</script>
