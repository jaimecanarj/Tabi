<script setup lang="ts">
import { Study } from "@/types";
import KanjiProgressChart from "@/Components/KanjiProgress/KanjiProgressChart.vue";
import KanjiProgressResume from "@/Components/KanjiProgress/KanjiProgressResume.vue";
import KanjiProgressHistoric from "@/Components/KanjiProgress/KanjiProgressHistoric.vue";
import { Separator } from "@/Components/ui/separator";

defineProps<{ studies: Study[] }>();
</script>

<template>
    <section class="mx-6 my-10">
        <!-- Sin datos -->
        <div v-if="!studies.length">
            <h2 class="text-4xl font-semibold">Tu progreso</h2>
            <p class="mt-5">Todavía no has estudiado este kanji.</p>
        </div>

        <!-- Con datos -->
        <div v-else class="flex flex-col justify-around lg:flex-row">
            <!-- Datos -->
            <div
                class="mb-4 flex flex-col justify-between gap-5 sm:h-80 sm:flex-row lg:w-3/5"
            >
                <!-- Resumen -->
                <KanjiProgressResume :studies="studies" />
                <Separator orientation="vertical" />
                <!-- Histórico -->
                <KanjiProgressHistoric :studies="studies" />
            </div>
            <!-- Gráfica -->
            <div class="lg:w-2/5">
                <KanjiProgressChart :studies="studies" />
            </div>
        </div>
    </section>
</template>
