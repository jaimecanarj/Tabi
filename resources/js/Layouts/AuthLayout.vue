<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { useColorMode } from "@vueuse/core";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

useColorMode();
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-background pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/inicio" class="flex items-center">
                <ApplicationLogo class="w-30 h-40" />
                <p class="ml-3 font-logo text-7xl">Tabi</p>
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-card px-6 py-4 shadow-lg sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
