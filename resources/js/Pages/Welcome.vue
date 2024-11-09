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
        <div class="container flex items-center justify-end h-14">
            <ToggleDarkMode />
        </div>
    </header>
    <main>
        <div
            class="container flex flex-col items-center justify-center gap-12 mt-32 lg:mt-56 lg:flex-row lg:gap-28"
        >
            <div class="flex flex-col items-center">
                <ApplicationLogo class="h-72 w-72" />
                <p
                    class="text-[120px] font-bold text-transparent font-logo bg-clip-text bg-gradient-primary"
                >
                    Tabi
                </p>
            </div>
            <div>
                <p class="text-3xl">
                    Tu aplicación para aprender <br />el sistema de escritura
                    Kanji
                </p>
                <div class="flex justify-center gap-3 mt-4 lg:justify-normal">
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
