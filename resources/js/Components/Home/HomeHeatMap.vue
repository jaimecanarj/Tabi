<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Crown } from "lucide-vue-next";
</script>

<template>
    <section class="mt-10 rounded-xl bg-gradient-primary p-6 shadow-md">
        <Link href="/progreso">
            <h2
                class="flex items-center gap-2 text-3xl font-bold text-primary-foreground"
            >
                <Crown :size="32" />Tu progreso
            </h2>
        </Link>
        <div class="text-primary-foreground">
            Mucho texto para rellenar, hecho de menos el lorem ipsum, maldito
            phpstorm me has robado lo mejor que tenia
        </div>
    </section>
</template>
