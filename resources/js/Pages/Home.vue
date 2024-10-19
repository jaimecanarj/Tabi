<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container mt-6">
        {{ $page.props }}
    </main>
</template>
