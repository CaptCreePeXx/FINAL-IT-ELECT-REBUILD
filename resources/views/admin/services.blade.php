@extends('layouts.app')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Services</h1>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Add Service Form --}}
    <div class="mb-8 p-4 bg-white shadow rounded-lg">
        <form action="{{ route('admin.services.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
            @csrf
            <input type="text" name="name" placeholder="New Service Name" class="flex-1 p-2 border rounded" required>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Add Service
            </button>
        </form>
    </div>

    {{-- Services Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($services as $service)
                <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        {{-- Edit Button (opens modal) --}}
                        <button 
                            onclick="openEditModal({{ $service->id }}, '{{ $service->name }}')" 
                            class="px-4 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </button>
                        {{-- Delete Form --}}
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
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

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Edit Service</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" id="editName" class="w-full p-2 border rounded mb-4" required>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        document.getElementById('editName').value = name;
        document.getElementById('editForm').action = '/admin/services/' + id;
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
    }
</script>
@endsection
