<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <h1 class="text-2xl font-bold mb-4">Fluidmanagement-Datensatz bearbeiten</h1>

            <form @submit.prevent="save">
                <div class="space-y-4">
                    <!-- See -->
                    <div>
                        <label for="see_id" class="block text-sm font-medium text-gray-700">See</label>
                        <select id="see_id" v-model="form.see_id" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1">
                            <option value="">– Bitte wählen –</option>
                            <option v-for="see in sees" :key="see.id" :value="see.id">{{ see.name }}</option>
                        </select>
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <input type="text" id="type" v-model="form.type" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Kommt von -->
                    <div>
                        <label for="comming_from" class="block text-sm font-medium text-gray-700">Kommt von</label>
                        <input type="text" id="comming_from" v-model="form.comming_from" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Geht zu -->
                    <div>
                        <label for="going_too" class="block text-sm font-medium text-gray-700">Geht zu</label>
                        <input type="text" id="going_too" v-model="form.going_too" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Grund -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Grund</label>
                        <input type="text" id="reason" v-model="form.reason" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Beginn Drainage -->
                    <div>
                        <label for="started_drain" class="block text-sm font-medium text-gray-700">Beginn Drainage</label>
                        <input type="date" id="started_drain" v-model="form.started_drain" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Ende Drainage -->
                    <div>
                        <label for="ended_drain" class="block text-sm font-medium text-gray-700">Ende Drainage</label>
                        <input type="date" id="ended_drain" v-model="form.ended_drain" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <!-- Pegelstand vor -->
                    <div>
                        <label for="pegelstand_vor" class="block text-sm font-medium text-gray-700">Pegelstand vor</label>
                        <input type="number" id="pegelstand_vor" v-model="form.pegelstand_vor" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01" />
                    </div>

                    <!-- Pegelstand nach -->
                    <div>
                        <label for="pegelstand_nach" class="block text-sm font-medium text-gray-700">Pegelstand nach</label>
                        <input type="number" id="pegelstand_nach" v-model="form.pegelstand_nach" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01" />
                    </div>

                    <!-- Menge -->
                    <div>
                        <label for="menge" class="block text-sm font-medium text-gray-700">Menge</label>
                        <input type="number" id="menge" v-model="form.menge" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01" />
                    </div>

                    <!-- Datum -->
                    <div>
                        <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                        <input type="date" id="datum" v-model="form.datum" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none">Speichern</button>
                        <button @click="cancel" type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none">Abbrechen</button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    sees: {
        type: Array,
        default: () => []
    },
    fluidManagement: {
        type: Object,
        default: () => {}
    }
})

const form = ref({
    see_id: props.fluidManagement.see_id,
    type: props.fluidManagement.type,
    comming_from: props.fluidManagement.comming_from,
    going_too: props.fluidManagement.going_too,
    reason: props.fluidManagement.reason,
    started_drain: props.fluidManagement.started_drain,
    ended_drain: props.fluidManagement.ended_drain,
    pegelstand_vor: props.fluidManagement.pegelstand_vor,
    pegelstand_nach: props.fluidManagement.pegelstand_nach,
    menge: props.fluidManagement.menge,
    datum: props.fluidManagement.datum
})

const save = () => {
    Inertia.put(route('fluid-management.update', props.fluidManagement.id), form.value)
}

const cancel = () => {
    Inertia.get(route('fluid-management.index'))
}
</script>
