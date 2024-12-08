<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { useColorMode } from "@vueuse/core";
import { Button } from "@/Components/ui/button";

defineProps<{ status: string }>();

useColorMode();
</script>

<template>
    <Head :title="status" />
    <main
        class="container box-border flex h-screen flex-col items-center justify-between gap-4 pt-12"
    >
        <h2 class="text-8xl font-semibold">{{ status }}</h2>
        <Link href="/inicio"
            ><Button size="lg" class="w-80">Volver a inicio</Button></Link
        >
        <img src="/assets/Viajero%20404.webp" alt="404" class="w-[50vw]" />
    </main>
</template>
