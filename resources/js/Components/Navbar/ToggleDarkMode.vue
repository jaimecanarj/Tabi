<script setup lang="ts">
import { computed } from "vue";
import { useColorMode } from "@vueuse/core";
import { Sun, Moon } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";

const { system, store } = useColorMode({ disableTransition: false });
const mode = computed(() =>
    store.value === "auto" ? system.value : store.value,
);

const changeTheme = () => {
    store.value = store.value == "light" ? "dark" : "light";
};
</script>

<template>
    <Button variant="ghost" size="icon" @click="changeTheme">
        <Sun
            class="absolute transition-all scale-0 rotate-90 dark:rotate-0 dark:scale-100"
        />
        <Moon
            class="transition-all scale-100 rotate-0 dark:-rotate-90 dark:scale-0"
        />
    </Button>
</template>
