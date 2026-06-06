<x-app-layout>
    <x-slot name="header">Admin Dashboard</x-slot>
    <div class="p-6">Welcome, {{ Auth::user()->name }}!</div>
</x-app-layout>
