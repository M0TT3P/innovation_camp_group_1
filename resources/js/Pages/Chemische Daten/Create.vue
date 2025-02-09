<template>
    <AuthenticatedLayout>
        <div class="px-6 py-4">
            <h1 class="text-2xl font-bold mb-4">Neuen Chemic Analytics-Datensatz hinzufügen</h1>

            <form @submit.prevent="save">
                <div class="space-y-4">
                    <!-- Alle Eingabefelder für die Attribute -->
                    <div>
                        <label for="see_id" class="block text-sm font-medium text-gray-700">See</label>
                        <select id="see_id" v-model="form.see_id" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1">
                            <option value="">– Bitte wählen –</option>
                            <option v-for="see in sees" :key="see.id" :value="see.id">{{ see.name }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                        <input type="date" id="datum" v-model="form.datum" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="wetter" class="block text-sm font-medium text-gray-700">Wetter</label>
                        <input type="text" id="wetter" v-model="form.wetter" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="sonderzustand" class="block text-sm font-medium text-gray-700">Sonderzustand</label>
                        <input type="text" id="sonderzustand" v-model="form.sonderzustand" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="temperatur" class="block text-sm font-medium text-gray-700">Temperatur</label>
                        <input type="number" id="temperatur" v-model="form.temperatur" step="0.1" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="sauerstoffgehalt" class="block text-sm font-medium text-gray-700">Sauerstoffgehalt</label>
                        <input type="number" id="sauerstoffgehalt" v-model="form.sauerstoffgehalt" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="ph" class="block text-sm font-medium text-gray-700">pH</label>
                        <input type="number" id="ph" v-model="form.ph" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="el" class="block text-sm font-medium text-gray-700">EL</label>
                        <input type="number" id="el" v-model="form.el" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="ung_stoffe" class="block text-sm font-medium text-gray-700">Ung. Stoffe</label>
                        <input type="number" id="ung_stoffe" v-model="form.ung_stoffe" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="ammonium" class="block text-sm font-medium text-gray-700">Ammonium</label>
                        <input type="number" id="ammonium" v-model="form.ammonium" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="nitrit" class="block text-sm font-medium text-gray-700">Nitrit</label>
                        <input type="number" id="nitrit" v-model="form.nitrit" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="nitrat" class="block text-sm font-medium text-gray-700">Nitrat</label>
                        <input type="number" id="nitrat" v-model="form.nitrat" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="ortho_p" class="block text-sm font-medium text-gray-700">ortho-P</label>
                        <input type="number" id="ortho_p" v-model="form.ortho_p" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="gesamt_p" class="block text-sm font-medium text-gray-700">Gesamt-P</label>
                        <input type="number" id="gesamt_p" v-model="form.gesamt_p" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="np_verhaltnis" class="block text-sm font-medium text-gray-700">N/P-Verhältnis</label>
                        <input type="number" id="np_verhaltnis" v-model="form.np_verhaltnis" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="doc" class="block text-sm font-medium text-gray-700">DOC</label>
                        <input type="number" id="doc" v-model="form.doc" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="chlorid" class="block text-sm font-medium text-gray-700">Chlorid</label>
                        <input type="number" id="chlorid" v-model="form.chlorid" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div>
                        <label for="chlorophyll" class="block text-sm font-medium text-gray-700">Chlorophyll</label>
                        <input type="number" id="chlorophyll" v-model="form.chlorophyll" step="0.01" class="block w-full border border-gray-300 rounded px-3 py-2 mt-1" />
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none">Speichern</button>
                        <button @click="cancel" type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none">Abbrechen</button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    sees: {
        type: Array,
        default: () => []
    }
})

const form = ref({
    see_id: null,
    datum: null,
    wetter: null,
    sonderzustand: null,
    temperatur: null,
    sauerstoffgehalt: null,
    ph: null,
    el: null,
    ung_stoffe: null,
    ammonium: null,
    nitrit: null,
    nitrat: null,
    ortho_p: null,
    gesamt_p: null,
    np_verhaltnis: null,
    doc: null,
    chlorid: null,
    chlorophyll: null
})

const save = () => {
    Inertia.post(route('chemic-analytics.store'), form.value)
}

const cancel = () => {
    Inertia.get(route('chemic-analytics.index'))
}
</script>
