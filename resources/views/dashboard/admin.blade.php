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

    {{-- Dashboard Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="p-4 bg-blue-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Patients</p>
            <p class="font-bold text-xl">{{ $stats['patients'] }}</p>
        </div>
        <div class="p-4 bg-green-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Dentists</p>
            <p class="font-bold text-xl">{{ $stats['dentists'] }}</p>
        </div>
        <div class="p-4 bg-yellow-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Receptionists</p>
            <p class="font-bold text-xl">{{ $stats['receptionists'] }}</p>
        </div>
        <div class="p-4 bg-purple-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Appointments</p>
            <p class="font-bold text-xl">{{ $stats['appointments'] }}</p>
        </div>
        <div class="p-4 bg-red-50 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Total Users</p>
            <p class="font-bold text-xl">{{ $stats['total_users'] }}</p>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-lg shadow-sm">
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
                        <form action="{{ route('admin.assignRole', $user) }}" method="POST">
                            @csrf
                            <select name="role_id" class="border rounded p-1 text-gray-700" {{ $user->id === auth()->id() ? 'disabled' : '' }} onchange="this.form.submit()">
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
                            <form action="{{ route('admin.toggleStatus', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded text-white {{ $user->status == 'active' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
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
</div>
@endsection
