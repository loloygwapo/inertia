<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4 text-2xl font-semibold">Job Finder</div>
            <ul class="space-y-4 p-4">
                <li>
                    <Link href="/dashboard" class="text-white">Dashboard</Link>
                </li>
                <li>
                    <Link href="/jobs" class="text-white">Job Listings</Link>
                </li>
                <li>
                    <Link href="/post-job" class="text-white">Post a Job</Link>
                </li>
                <li>
                    <Link href="/profile" class="text-white">Profile</Link>
                </li>
                <li>
                    <Link href="/welcome" class="text-white">Logout</Link>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-8">
            <slot></slot> <!-- This will hold the page content -->
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const logout = () => {
    Inertia.post('/logout');
}
</script>

<style scoped>
/* Custom styles if needed */
</style>

