<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { Kanji, Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Button } from "@/Components/ui/button";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";

defineProps<{
    radical: Radical;
    kanjis: Kanji[];
}>();
</script>

<template>
    <Head :title="radical.literal" />
    <MainLayout />
    <main class="container mt-6">
        <ItemDetailsCard
            :literal="radical.literal"
            tipo="radicales"
            :titulo="radical.significado"
        >
            <!-- Trazos -->
            <div class="mb-3">
                <h3 class="inline mr-1 text-lg">Trazos:</h3>
                <span class="text-lg font-semibold">{{ radical.trazos }}</span>
            </div>
            <!-- Kanjis donde aparece -->
            <div class="mb-3">
                <h3 class="mb-1 text-lg font-semibold tracking-tight">
                    Kanjis donde aparece
                </h3>
                <div class="flex flex-wrap overflow-x-scroll max-h-96">
                    <template v-for="kanji of kanjis">
                        <Link :href="`/kanjis/${kanji.id}`">
                            <Button class="m-1 text-2xl">{{
                                kanji.literal
                            }}</Button>
                        </Link>
                    </template>
                </div>
            </div>
        </ItemDetailsCard>
    </main>
</template>
