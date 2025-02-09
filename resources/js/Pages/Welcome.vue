<template>
    <!-- Header-Bereich wie im Breeze Starterkit -->
    <header class="bg-white shadow p-4">
        <div class="flex justify-end">
            <button
                @click="goToLogin"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150"
            >
                Login
            </button>
        </div>
    </header>

    <Swimming :lakes="lakes"/>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import Swimming from "@/Components/Swimming.vue"

const props = defineProps({
    lakes: {
        type: Array,
        default: () => []
    }
})

/**
 * Navigiert via Inertia.js zur Login-Seite.
 */
function goToLogin() {
    Inertia.visit('/login')
}
</script>
