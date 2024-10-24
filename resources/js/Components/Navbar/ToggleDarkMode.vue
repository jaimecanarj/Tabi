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
    <Button variant="ghost" size="icon">
        <Sun
            @click="store = 'light'"
            class="absolute transition-all scale-0 rotate-90 dark:rotate-0 dark:scale-100"
        />
        <Moon
            @click="store = 'dark'"
            class="transition-all scale-100 rotate-0 dark:-rotate-90 dark:scale-0"
        />
    </Button>
</template>
