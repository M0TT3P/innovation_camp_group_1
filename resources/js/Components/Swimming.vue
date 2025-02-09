<template>
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="lake in lakes"
                :key="lake.id"
                class="bg-white shadow-lg rounded-lg p-6 border border-gray-300 cursor-pointer"
                @click="goToLake(lake.id)"
            >
                <!-- Bild -->
                <div class="hidden sm:block">
                    <img
                        v-if="lake.image"
                        :src="lake.image"
                        :alt="lake.name"
                        class="w-full h-40 object-cover rounded mb-4"
                    />
                </div>

                <!-- Name -->
                <h2 class="text-xl font-bold mb-2 text-center">
                    {{ lake.name }}
                </h2>

                <!-- Wichtige Infos -->
                <div class="space-y-2">
                    <!-- Wassertemperatur -->
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="font-medium text-gray-700">Wassertemperatur:</span>
                        <span class="text-sm text-gray-700">{{ lake.temperatur }}°C</span>
                    </div>

                    <!-- Aktuelles Wetter -->
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="font-medium text-gray-700">Aktuelles Wetter:</span>
                        <span class="text-sm text-gray-700">{{ lake.wetter }}</span>
                    </div>
                </div>

                <!-- Badeempfehlung -->
                <div class="mt-4 text-center">
                    <span
                        class="px-3 py-1 rounded font-bold"
                        :class="{
                            'bg-green-200 text-green-800': lake.dangerzone === 'Perfekt zum baden',
                            'bg-red-200 text-red-800': lake.dangerzone === 'Baden heute nicht empfohlen'
                        }"
                    >
                        {{ lake.dangerzone }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {usePage} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Entweder direkt aus den Props ...
const props = defineProps({
    lakes: {
        type: Array,
        default: () => []
    }
})

// ... oder per usePage(), falls du keine defineProps() nutzen möchtest.
// const lakes = computed(() => usePage().props.lakes)

const goToLake = (lakeId) => {
    Inertia.get(route('lakes.show', lakeId))
}
</script>

<style scoped>
.container {
    max-width: 1200px;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
