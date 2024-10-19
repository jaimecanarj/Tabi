<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import { useColorMode } from "@vueuse/core";
import { Sun, Moon } from "lucide-vue-next";
import { computed } from "vue";

const { system, store } = useColorMode({ disableTransition: false });
const mode = computed(() =>
    store.value === "auto" ? system.value : store.value,
);
</script>

<template>
    <Button variant="ghost">
        <Sun
            @click="store = 'light'"
            class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"
        />
        <Moon
            @click="store = 'dark'"
            class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"
        />
    </Button>
</template>
