<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Desktop-Sidebar (ab sm sichtbar, bleibt links) -->
        <aside class="hidden sm:block w-64 bg-white shadow-lg sticky top-0 h-screen overflow-y-auto">
            <!-- Logo-Bereich -->
            <div class="5flex items-center justify-items-center justify-center p-4 border-b border-gray-100">
                <Link :href="route('dashboard')" class="flex justify-center items-center space-x-2">
                    <img class="w-1/2" src="./image002.png" alt="Logo" />
                </Link>
            </div>

            <!-- Menübereich -->
            <nav class="p-4 space-y-4">
                <Link
                    v-for="item in menuItems"
                    :key="item.title"
                    :href="route(item.route)"
                    class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none"
                >
                    {{ item.title }}
                </Link>
            </nav>

            <!-- Logout-Bereich -->
            <div class="p-4 border-t border-gray-100">
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="block w-full text-left text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"
                >
                    Logout
                </Link>
            </div>
        </aside>

        <!-- Mobile-Sidebar (toggable, nur auf kleinen Bildschirmen, rechts positioniert) -->
        <div
            class="fixed inset-y-0 right-0 z-30 w-64 bg-white shadow-lg transition-transform transform sm:hidden"
            :class="{ 'translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }"
        >
            <!-- Logo & Schließen-Button -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <Link :href="route('dashboard')" class="flex items-center space-x-2">
                    <img class="w-1/2" src="./image002.png" alt="Logo" />
                </Link>
                <button @click="toggleSidebar" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menübereich -->
            <nav class="p-4 space-y-4">
                <Link
                    v-for="item in menuItems"
                    :key="item.title"
                    :href="route(item.route)"
                    class="block px-4 py-2 text-gray-700 rounded-md hover:bg-gray-200"
                    @click="toggleSidebar"
                >
                    {{ item.title }}
                </Link>
            </nav>

            <!-- Logout-Bereich -->
            <div class="p-4 border-t border-gray-100">
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="block w-full text-left text-gray-700 hover:bg-gray-100 px-4 py-2 rounded"
                    @click="toggleSidebar"
                >
                    Logout
                </Link>
            </div>
        </div>

        <!-- Hauptinhalt -->
        <div class="flex-1">
            <!-- Mobile-Header: sticky, oben und rechts positioniert; wird nur visuell ausgeblendet, wenn die Sidebar geöffnet ist -->
            <header
                class="sm:hidden sticky top-0 right-0 z-40 flex items-center justify-end p-4 bg-white border-b shadow transition-opacity duration-300"
                :class="{ 'opacity-0 pointer-events-none': isSidebarOpen, 'opacity-100': !isSidebarOpen }"
            >
                <!-- Sidebar-Toggle-Button -->
                <button @click="toggleSidebar" class="text-gray-500 focus:outline-none mr-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold">
                    <slot name="header" />
                </h1>
            </header>

            <!-- Seiteninhalt mit extra Top-Padding, damit der sticky Header nicht überlappt -->
            <main class="p-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';

// Reaktive Variable für die mobile Sidebar
const isSidebarOpen = ref(false);

// Menüeinträge für die Sidebar
const menuItems = ref([
    { title: 'Seen', route: 'lakes.index' },
    { title: 'Chemische Daten', route: 'chemic-analytics.index' },
    { title: 'Pegeldaten', route: 'monitoring.index' },
    { title: 'Swiss Meteo', route: 'chemic-analytics.index' },
    { title: 'Flüssigkeiten Managment', route: 'fluid-management.index' }
]);

// Umschalten der mobilen Sidebar
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Schließen der mobilen Sidebar, wenn außerhalb geklickt wird
const handleClickOutside = (event) => {
    if (isSidebarOpen.value && !event.target.closest('.sm\\:hidden')) {
        isSidebarOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* Zusätzliche Styles können hier ergänzt werden */
</style>
