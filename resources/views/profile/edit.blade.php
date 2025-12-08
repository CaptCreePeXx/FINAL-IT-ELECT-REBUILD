@extends('layouts.app')

@section('title', 'Profile')

@section('sidebar')
    @include('dashboard.partials.patient_sidebar')
@endsection

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-3xl space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-left">Profile</h2>

        <!-- Update profile info -->
        <div class="p-6 bg-gray-100 shadow rounded-lg">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update password -->
        <div class="p-6 bg-gray-100 shadow rounded-lg">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete user -->
        <div class="p-6 bg-gray-100 shadow rounded-lg">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
