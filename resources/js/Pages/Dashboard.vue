<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Swimming from "@/Components/Swimming.vue";
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <Swimming></Swimming>
    </AuthenticatedLayout>
</template>
