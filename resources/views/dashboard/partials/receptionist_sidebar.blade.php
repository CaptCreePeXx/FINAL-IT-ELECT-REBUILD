<aside class="w-64 min-h-screen bg-[#2F3E3C] text-[#FBF9F1] shadow-2xl border-r border-[#C7E7EC] flex flex-col py-6">
    <div class="px-6 mb-6">
        <h1 class="text-xl font-bold tracking-wide">Receptionist Panel</h1>
        <div class="mt-1 w-12 h-1 bg-[#C7E7EC] rounded"></div>
    </div>

    <nav class="flex-1 flex flex-col gap-1 px-3">

        <!-- Dashboard -->
        <button 
            onclick="openSidebarTab('dashboard')" 
            id="sidebar-dashboard"
            class="sidebar-btn sidebar-inactive flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent">
            <span class="material-icons text-lg">dashboard</span>
            Dashboard
        </button>

        <!-- Profile -->
        <button 
            onclick="openSidebarTab('profile')" 
            id="sidebar-profile"
            class="sidebar-btn sidebar-inactive flex items-center gap-3 px-4 py-3 rounded-lg transition-all border border-transparent">
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
// WORKING TAB SWITCHING WITH ACTIVE EFFECT
function openSidebarTab(tab) {
    const tabs = ['dashboard', 'profile'];

    tabs.forEach(id => {
        const btn = document.getElementById('sidebar-' + id);
        if (!btn) return;

        if (id === tab) {
            btn.classList.add('sidebar-active');
            btn.classList.remove('sidebar-inactive');
        } else {
            btn.classList.remove('sidebar-active');
            btn.classList.add('sidebar-inactive');
        }
    });

    // show/hide content containers
    document.getElementById('dashboard-container').classList.toggle('hidden', tab !== 'dashboard');
    document.getElementById('profile-container').classList.toggle('hidden', tab !== 'profile');
}

// Set Dashboard visible at first load WITHOUT forcing it permanently active
// We simulate one click so active can still switch correctly.
document.addEventListener("DOMContentLoaded", () => openSidebarTab('dashboard'));
</script>

<style>
/* Base button style */
.sidebar-btn {
    border: 1px solid transparent;
}

/* Hover for inactive buttons */
.sidebar-inactive:hover {
    background-color: #C7E7EC;
    color: #2F3E3C;
}

/* ACTIVE tab (matches your reference sidebar) */
.sidebar-active {
    background-color: #C7E7EC;
    color: #2F3E3C;
    font-weight: 600;
    border-color: #FBF9F1 !important;
}
</style>
