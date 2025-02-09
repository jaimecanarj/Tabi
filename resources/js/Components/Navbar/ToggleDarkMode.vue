<script setup lang="ts">
import { computed } from "vue";
import { useColorMode } from "@vueuse/core";
import { Sun, Moon } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";

const { system, store } = useColorMode({ disableTransition: false });
computed(() => (store.value === "auto" ? system.value : store.value));

const changeTheme = () => {
    store.value = store.value === "light" ? "dark" : "light";
};
</script>

<template>
    <Button variant="ghost" size="icon" @click="changeTheme">
        <Sun
            class="absolute rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"
        />
        <Moon
            class="rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"
        />
    </Button>
</template>
