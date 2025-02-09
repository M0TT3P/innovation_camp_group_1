<script setup>
import {ref} from 'vue';
import SidebarLayout from '@/Components/Sidebar.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <SidebarLayout>
            <slot/>
        </SidebarLayout>
    </div>
</template>
