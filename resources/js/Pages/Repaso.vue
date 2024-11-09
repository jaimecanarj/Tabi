<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Head title="Estudio" />
    <MainLayout />
    <main class="container relative mt-12">
        <pre>{{ kanjis }}</pre>
        <!-- Mostrar kanji en grande con fondo gradiente
        Añadir cuadro enorme para introducir respuesta
        Al introducir la respuesta, dar la opción de mostrar información
        Si lo resuelve Mostrar en verde o rojo si acertó o no
        Una vez pulse enter o la flecha de siguiente, mostrar siguiente kanji
        La vista es igual a la de estudio pero no hay paginación y donde pone el significado es un input -->
    </main>
</template>
