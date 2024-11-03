<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { useColorMode } from "@vueuse/core";

const mode = useColorMode();
</script>

<template>
    <div
        class="flex flex-col items-center min-h-screen pt-6 bg-background sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/home">
                <ApplicationLogo class="w-20 h-20 text-gray-500 fill-current" />
            </Link>
        </div>

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden shadow-lg bg-card sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
