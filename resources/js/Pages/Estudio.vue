<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Kanji } from "@/lib/types";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Head title="Estudio" />
    <MainLayout />
    <main class="container mt-12">
        <div>Estoy estudiando</div>
        <pre>{{ kanjis }}</pre>
    </main>
</template>
