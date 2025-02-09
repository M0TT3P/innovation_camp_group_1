<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <h1 class="text-2xl font-bold mb-4">Chemic Analytics</h1>

            <!-- Plus-Button oben links -->
            <div class="mb-4 flex justify-end">
                <button @click="addNewRow" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none">
                    +
                </button>
            </div>

            <!-- Container für alle Datensätze als Karten -->
            <div class="grid grid-cols-1 gap-4">
                <div
                    v-for="(row, index) in items"
                    :key="row.localKey"
                    class="bg-white shadow-md rounded-lg p-4 border border-gray-300"
                >
                    <!-- Grid-Layout für die Attribute -->
                    <div class="space-y-2">
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">ID:</span>
                            <span class="text-sm text-gray-700">{{ row.id || 'Neu' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">See:</span>
                            <span class="text-sm text-gray-700">{{ row.see ? row.see.name : '—' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Datum:</span>
                            <span class="text-sm text-gray-700">{{ row.datum }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Wetter:</span>
                            <span class="text-sm text-gray-700">{{ row.wetter }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Sonderzustand:</span>
                            <span class="text-sm text-gray-700">{{ row.sonderzustand }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Temperatur:</span>
                            <span class="text-sm text-gray-700">{{ row.temperatur }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Sauerstoff:</span>
                            <span class="text-sm text-gray-700">{{ row.sauerstoffgehalt }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">pH:</span>
                            <span class="text-sm text-gray-700">{{ row.ph }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">EL:</span>
                            <span class="text-sm text-gray-700">{{ row.el }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Ung. Stoffe:</span>
                            <span class="text-sm text-gray-700">{{ row.ung_stoffe }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Ammonium:</span>
                            <span class="text-sm text-gray-700">{{ row.ammonium }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Nitrit:</span>
                            <span class="text-sm text-gray-700">{{ row.nitrit }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Nitrat:</span>
                            <span class="text-sm text-gray-700">{{ row.nitrat }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">ortho-P:</span>
                            <span class="text-sm text-gray-700">{{ row.ortho_p }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Gesamt-P:</span>
                            <span class="text-sm text-gray-700">{{ row.gesamt_p }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">N/P-Verhältnis:</span>
                            <span class="text-sm text-gray-700">{{ row.np_verhaltnis }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">DOC:</span>
                            <span class="text-sm text-gray-700">{{ row.doc }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Chlorid:</span>
                            <span class="text-sm text-gray-700">{{ row.chlorid }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Chlorophyll:</span>
                            <span class="text-sm text-gray-700">{{ row.chlorophyll }}</span>
                        </div>
                    </div>
                    <!-- Aktionen -->
                    <div class="flex justify-end space-x-2 mt-4">
                        <button @click="editRow(index)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
                            Bearbeiten
                        </button>
                        <button @click="deleteRow(index)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none">
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
    chemicAnalytics: {
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
    items.value = props.chemicAnalytics.map(item => ({
        ...item,
        localKey: `existing-${item.id}`,
        isEditing: false
    }))
})

const addNewRow = () => {
    Inertia.get(route('chemic-analytics.create'))
}

const editRow = (index) => {
    const row = items.value[index]
    Inertia.get(route('chemic-analytics.edit', row.id))
}

const deleteRow = (index) => {
    const row = items.value[index]
    if (!confirm('Möchten Sie diesen Datensatz wirklich löschen?')) return
    Inertia.delete(route('chemic-analytics.destroy', row.id))
}
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
