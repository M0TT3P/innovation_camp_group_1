<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <!-- Titel mit Add-Button rechts oben -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Pegeldaten</h1>
                <button
                    @click="addNewRow"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none"
                >
                    +
                </button>
            </div>

            <!-- Container: Jeder Datensatz als Karte -->
            <div class="space-y-4">
                <div
                    v-for="(row, index) in items"
                    :key="row.localKey"
                    class="bg-white shadow-md rounded-lg p-4 space-y-2 border border-gray-300"
                >
                    <!-- Attribut-Zeilen mit unterer Linie -->
                    <div class="space-y-2">
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">ID:</span>
                            <span class="text-sm text-gray-700">{{ row.id || 'Neu' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">See:</span>
                            <span class="text-sm text-gray-700">
                                {{ row.see ? row.see.name : '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Pegelstand:</span>
                            <span class="text-sm text-gray-700">{{ row.pegelstand }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Datum:</span>
                            <span class="text-sm text-gray-700">{{ row.datum }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Verdunstung:</span>
                            <span class="text-sm text-gray-700">{{ row.verdunstung }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Niederschlag:</span>
                            <span class="text-sm text-gray-700">{{ row.niederschlag }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Temperatur:</span>
                            <span class="text-sm text-gray-700">{{ row.temperatur }}</span>
                        </div>
                    </div>

                    <!-- Aktionen -->
                    <div class="flex justify-end space-x-2 mt-4">
                        <button
                            @click="editRow(index)"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none"
                        >
                            Bearbeiten
                        </button>
                        <button
                            @click="deleteRow(index)"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none"
                        >
                            Löschen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    monitoring: {
        type: Array,
        default: () => []
    },
    sees: {
        type: Array,
        default: () => []
    }
})

const items = ref([])

onMounted(() => {
    items.value = props.monitoring.map(entry => ({
        ...entry,
        localKey: `existing-${entry.id}`,
        isEditing: false
    }))
})

const addNewRow = () => {
    Inertia.get(route('monitoring.create'))
}

const editRow = (index) => {
    const row = items.value[index]
    Inertia.get(route('monitoring.edit', row.id))
}

const deleteRow = (index) => {
    const row = items.value[index]
    if (!confirm('Möchten Sie diesen Datensatz wirklich löschen?')) return
    Inertia.delete(route('monitoring.destroy', row.id))
}
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
