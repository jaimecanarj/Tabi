<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Head title="Tu pogreso" />
    <MainLayout />
    <div class="container mt-12">
        <h2 class="mb-6 text-6xl">Kanjis aprendidos</h2>
        <div class="grid grid-cols-12 gap-2">
            <div
                v-for="kanji of kanjis"
                class="p-2 text-2xl text-center rounded-sm bg-primary text-primary-foreground"
            >
                {{ kanji.literal }}
            </div>
        </div>
    </div>
</template>
