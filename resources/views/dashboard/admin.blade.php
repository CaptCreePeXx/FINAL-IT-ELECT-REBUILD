@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div id="flash-message" 
         class="fixed top-4 right-4 max-w-sm w-full p-4 bg-green-600 text-white rounded-lg shadow-lg border-l-4 border-green-800 flex items-start gap-3 opacity-0 translate-x-10 z-50">
        <svg class="w-6 h-6 flex-shrink-0 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <div class="flex-1">
            <p class="font-medium">Success</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('flash-message').remove()" class="text-white hover:text-gray-200 font-bold">&times;</button>
    </div>
    <script>
        const flash = document.getElementById('flash-message');
        if(flash){
            setTimeout(() => {
                flash.classList.add('transition', 'duration-500', 'ease-out');
                flash.classList.remove('opacity-0', 'translate-x-10');
                flash.classList.add('opacity-100', 'translate-x-0');
            }, 50);
            setTimeout(() => {
                flash.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => flash.remove(), 500);
            }, 4000);
        }
    </script>
    @endif

    {{-- Dashboard Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mb-8">
        <div class="p-4 bg-blue-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
            <p class="text-gray-600 text-sm">Patients</p>
            <p class="font-bold text-xl">{{ $stats['patients'] }}</p>
        </div>
        <div class="p-4 bg-green-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
            <p class="text-gray-600 text-sm">Dentists</p>
            <p class="font-bold text-xl">{{ $stats['dentists'] }}</p>
        </div>
        <div class="p-4 bg-yellow-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
            <p class="text-gray-600 text-sm">Receptionists</p>
            <p class="font-bold text-xl">{{ $stats['receptionists'] }}</p>
        </div>
        <div class="p-4 bg-purple-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
            <p class="text-gray-600 text-sm">Appointments</p>
            <p class="font-bold text-xl">{{ $stats['appointments'] }}</p>
        </div>
        <div class="p-4 bg-red-50 rounded shadow text-center hover:shadow-lg hover:scale-105 transition transform duration-300">
            <p class="text-gray-600 text-sm">Total Users</p>
            <p class="font-bold text-xl">{{ $stats['total_users'] }}</p>
        </div>
    </div>

    {{-- Users List Table --}}
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Users List</h2>
        <a href="{{ route('admin.reports.pdf') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Generate Report (PDF)
        </a>
    </div>

    <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-lg shadow-sm mb-6">
        <table class="min-w-full border-collapse text-left">
            <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 border-r border-gray-300">Name</th>
                    <th class="px-4 py-2 border-r border-gray-300">Email</th>
                    <th class="px-4 py-2 border-r border-gray-300">Role</th>
                    <th class="px-4 py-2 border-r border-gray-300">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach($users as $user)
                <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                    <td class="py-2 px-4 border-r border-gray-200">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-r border-gray-200">
                        <form class="role-form" action="{{ route('admin.assignRole', $user) }}" method="POST" data-user="{{ $user->name }}">
                            @csrf
                            <select name="role_id" class="border rounded p-1 text-gray-700" {{ $user->id === auth()->id() ? 'disabled' : '' }} data-original="{{ $user->role_id }}">
                                <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Patient</option>
                                <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Dentist</option>
                                <option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Receptionist</option>
                                <option value="4" {{ $user->role_id == 4 ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td class="py-2 px-4 border-r border-gray-200 capitalize">{{ $user->status ?? 'active' }}</td>
                    <td class="py-2 px-4">
                        @if($user->id !== auth()->id())
                            <form class="status-form inline" action="{{ route('admin.toggleStatus', $user) }}" method="POST" data-user="{{ $user->name }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded text-white {{ $user->status == 'active' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} transition">
                                    {{ $user->status == 'active' ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500"></span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Services Card below Users List --}}
    <div class="w-1/3 p-4 rounded-lg bg-transparent">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-gray-700">Manage Services</h2>
            <form action="{{ route('admin.services.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="name" placeholder="New Service" required
                       class="border rounded px-2 py-1 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <button type="submit" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Add
                </button>
            </form>
        </div>
        <div class="max-h-64 overflow-y-auto">
            <table class="min-w-full border-collapse text-left">
                <thead class="bg-gray-200 sticky top-0 border-b border-gray-300">
                    <tr>
                        <th class="px-3 py-2 border-r border-gray-300">#</th>
                        <th class="px-3 py-2 border-r border-gray-300">Service</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    @foreach($services as $service)
                    <tr class="text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                        <td class="py-2 px-3 border-r border-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-2 px-3 border-r border-gray-200">
                            <form action="{{ route('admin.services.update', $service) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $service->name }}" 
                                       class="border rounded px-2 py-1 w-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                <button type="submit" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                                    Save
                                </button>
                            </form>
                        </td>
                        <td class="py-2 px-3">
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Confirmation Modal -->
<div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-lg w-96 p-6">
        <h2 class="text-xl font-bold mb-4" id="modal-title">Confirm Action</h2>
        <p class="text-gray-700 mb-6" id="modal-message">Are you sure?</p>
        <div class="flex justify-end gap-3">
            <button id="modal-cancel" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</button>
            <button id="modal-confirm" class="px-4 py-2 rounded bg-red-500 hover:bg-red-600 text-white font-semibold">Confirm</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmation-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalConfirm = document.getElementById('modal-confirm');
    const modalCancel = document.getElementById('modal-cancel');
    const modalBox = modal.querySelector('div');
    let activeForm = null;

    function showModal(title, message, form) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        activeForm = form;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            modalBox.classList.add('scale-100');
        }, 50);
    }

    function hideModal() {
        modal.classList.remove('opacity-100');
        modalBox.classList.remove('scale-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            activeForm = null;
        }, 300);
    }

    document.querySelectorAll('.role-form select').forEach(select => {
        select.addEventListener('change', function(e) {
            const userName = this.closest('form').dataset.user;
            const roleName = this.options[this.selectedIndex].text;
            showModal('Change Role', `Are you sure you want to change ${userName}'s role to "${roleName}"?`, this.form);
        });
    });

    document.querySelectorAll('.status-form button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const userName = form.dataset.user;
            const action = this.textContent.trim();
            showModal('Confirm Action', `Are you sure you want to ${action.toLowerCase()} "${userName}"?`, form);
        });
    });

    modalConfirm.addEventListener('click', function() {
        if(activeForm) activeForm.submit();
    });

    modalCancel.addEventListener('click', hideModal);
    modal.addEventListener('click', function(e) {
        if(e.target === modal) hideModal();
    });
});
</script>
@endsection
