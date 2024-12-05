<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { useColorMode } from "@vueuse/core";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ToggleDarkMode from "@/Components/Navbar/ToggleDarkMode.vue";
import { Button } from "@/Components/ui/button";

useColorMode();
</script>

<template>
    <Head title="Bienvenido" />
    <header>
        <div class="container flex h-14 items-center justify-end">
            <ToggleDarkMode />
        </div>
    </header>
    <main>
        <div
            class="container mt-32 flex flex-col items-center justify-center gap-12 lg:mt-56 lg:flex-row lg:gap-28"
        >
            <div class="flex flex-col items-center">
                <ApplicationLogo class="h-72 w-72" />
                <p
                    class="bg-gradient-primary-to-alt bg-clip-text font-logo text-[120px] font-bold text-transparent"
                >
                    Tabi
                </p>
            </div>
            <div>
                <p class="text-3xl">
                    Tu aplicación para aprender <br />el sistema de escritura
                    Kanji
                </p>
                <div class="mt-4 flex justify-center gap-3 lg:justify-normal">
                    <Link href="/inicio">
                        <Button variant="secondary">Echar un vistazo</Button>
                    </Link>
                    <Link href="/login">
                        <Button>Empieza tu viaje</Button>
                    </Link>
                </div>
            </div>
        </div>
    </main>
</template>
