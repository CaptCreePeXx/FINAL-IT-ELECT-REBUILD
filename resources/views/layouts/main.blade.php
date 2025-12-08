<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Patient Dashboard') - Dental Clinic</title>

    <!-- Tailwind (Dev builds) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
      :root{
        --clr-1: #2F3E3C; /* dark */
        --clr-2: #BDDBD1; /* light mint */
        --clr-3: #E7E9E3; /* light grayish */
        --clr-4: #FBF9F1; /* soft cream */
        --clr-5: #E8F0F1; /* soft blue gray */
        --clr-6: #C7E7EC; /* cool mint blue */
      }

      /* small helper for card border color */
      .card-border {
        border: 1px solid var(--clr-3);
      }
    </style>

</head>
<body class="bg-[color:var(--clr-4)] min-h-screen font-sans text-[14px]">

  <div class="flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content area -->
    <div class="flex-1 flex flex-col">

      <!-- Header -->
      @include('layouts.header')

      <!-- Page content -->
      <main class="p-6">
        <div class="max-w-7xl mx-auto">
          @if(session('success'))
            <div class="mb-4 p-3 rounded shadow card-border bg-white text-green-700">
              {{ session('success') }}
            </div>
          @endif

          @if(session('error'))
            <div class="mb-4 p-3 rounded shadow card-border bg-white text-red-700">
              {{ session('error') }}
            </div>
          @endif

          @yield('content')
        </div>
      </main>

    </div>
  </div>

</body>
</html>
