@extends('layouts.app')

@section('title','Profile Management')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Profile Management
        </h1>
        <p class="text-sm text-gray-500">
            Kelola akun dan keamanan anda
        </p>
    </div>


    {{-- Update Profile Info --}}
    <div class="bg-white p-6 rounded-xl shadow">
        @include('profile.partials.update-profile-information-form')
    </div>


    {{-- Update Password --}}
    <div class="bg-white p-6 rounded-xl shadow">
        @include('profile.partials.update-password-form')
    </div>


    {{-- Delete Account --}}
    <div class="bg-white p-6 rounded-xl shadow border border-red-200">
        @include('profile.partials.delete-user-form')
    </div>

</div>

@endsection
