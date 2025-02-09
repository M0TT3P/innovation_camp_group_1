<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <h1 class="text-2xl font-bold mb-4">Pegel-Datensatz bearbeiten</h1>

            <form @submit.prevent="save">
                <div class="space-y-4">
                    <!-- See -->
                    <div>
                        <label for="see_id" class="block text-sm font-medium text-gray-700">See</label>
                        <select id="see_id" v-model="form.see_id"
                                class="block w-full border border-gray-300 rounded px-3 py-2 mt-1">
                            <option value="">– Bitte wählen –</option>
                            <option v-for="see in sees" :key="see.id" :value="see.id">{{ see.name }}</option>
                        </select>
                    </div>

                    <!-- Pegelstand -->
                    <div>
                        <label for="pegelstand" class="block text-sm font-medium text-gray-700">Pegelstand</label>
                        <input type="number" id="pegelstand" v-model="form.pegelstand"
                               class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01"/>
                    </div>

                    <!-- Verdunstung -->
                    <div>
                        <label for="verdunstung" class="block text-sm font-medium text-gray-700">Verdunstung</label>
                        <input type="number" id="verdunstung" v-model="form.verdunstung"
                               class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01"/>
                    </div>

                    <div>
                        <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                        <input type="date" id="datum" v-model="form.datum"
                               class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01"/>
                    </div>

                    <!-- Niederschlag -->
                    <div>
                        <label for="niederschlag" class="block text-sm font-medium text-gray-700">Niederschlag</label>
                        <input type="number" id="niederschlag" v-model="form.niederschlag"
                               class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.01"/>
                    </div>

                    <!-- Temperatur -->
                    <div>
                        <label for="temperatur" class="block text-sm font-medium text-gray-700">Temperatur</label>
                        <input type="number" id="temperatur" v-model="form.temperatur"
                               class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" step="0.1"/>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none">
                            Speichern
                        </button>
                        <button @click="cancel" type="button"
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none">
                            Abbrechen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    sees: {
        type: Array,
        default: () => []
    },
    monitoring: {
        type: Object,
        default: () => {
        }
    }
})

const form = ref({
    see_id: props.monitoring.see_id,
    pegelstand: props.monitoring.pegelstand,
    datum: props.monitoring.datum,
    verdunstung: props.monitoring.verdunstung,
    niederschlag: props.monitoring.niederschlag,
    temperatur: props.monitoring.temperatur,
})

const save = () => {
    Inertia.put(route('monitoring.update', props.monitoring.id), form.value)
}

const cancel = () => {
    Inertia.get(route('monitoring.index'))
}
</script>

<style scoped>
/* Tailwind Styling */
</style>
