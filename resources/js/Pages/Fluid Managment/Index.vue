<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Fluidmanagement</h1>

                <!-- Add-Button rechts oben -->
                <button
                    @click="addNewRow"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none"
                >
                    +
                </button>
            </div>

            <!-- Container: Jeder Datensatz als Karte -->
            <div class="grid grid-cols-1 gap-4">
                <div
                    v-for="(row, index) in items"
                    :key="row.localKey"
                    class="bg-white shadow-md rounded-lg p-4 space-y-4 border border-gray-300"
                >
                    <!-- Attribute im Grid, jede Zeile mit unterer Linie -->
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
                            <span class="font-medium text-gray-700">Type:</span>
                            <span class="text-sm text-gray-700">{{ row.type }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Kommt von:</span>
                            <span class="text-sm text-gray-700">{{ row.comming_from }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Geht zu:</span>
                            <span class="text-sm text-gray-700">{{ row.going_too }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Grund:</span>
                            <span class="text-sm text-gray-700">{{ row.reason }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Pegelstand vor:</span>
                            <span class="text-sm text-gray-700">{{ row.pegelstand_vor }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Pegelstand nach:</span>
                            <span class="text-sm text-gray-700">{{ row.pegelstand_nach }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="font-medium text-gray-700">Menge:</span>
                            <span class="text-sm text-gray-700">{{ row.menge }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Datum:</span>
                            <span class="text-sm text-gray-700">{{ row.datum }}</span>
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
import {ref, onMounted} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    fluidManagement: {
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
    items.value = props.fluidManagement.map(entry => ({
        ...entry,
        localKey: `existing-${entry.id}`,
        isEditing: false
    }))
})

const addNewRow = () => {
    Inertia.get(route('fluid-management.create'))
}

const editRow = (index) => {
    const row = items.value[index]
    Inertia.get(route('fluid-management.edit', row.id))
}

const deleteRow = (index) => {
    const row = items.value[index]
    if (!confirm('Möchten Sie diesen Datensatz wirklich löschen?')) return
    Inertia.delete(route('fluid-management.destroy', row.id))
}
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
