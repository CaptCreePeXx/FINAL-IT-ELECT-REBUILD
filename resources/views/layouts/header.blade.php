<header class="bg-[color:var(--clr-1)] text-white p-4 flex items-center justify-between shadow">
  <div class="flex items-center gap-4">
    <button id="sidebarToggle" class="md:hidden p-2 bg-[color:var(--clr-2)] text-[color:var(--clr-1)] rounded">☰</button>
    <h2 class="text-lg font-semibold">@yield('title','Dashboard')</h2>
  </div>

  <div class="flex items-center gap-4">
    <div class="hidden sm:block text-sm text-[color:var(--clr-2)]">
      {{ auth()->user()?->name ?? 'Guest' }}
    </div>

    <!-- Notification placeholder -->
    <div class="relative">
      <button class="p-2 rounded bg-[color:var(--clr-2)] text-[color:var(--clr-1)]">🔔</button>
      <!-- small badge -->
      <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs rounded-full bg-red-600 text-white">2</span>
    </div>

    <!-- Profile dropdown simple -->
    <div class="relative">
      <button class="p-2 rounded bg-white/10 hover:bg-white/20">▼</button>
    </div>
  </div>
</header>
