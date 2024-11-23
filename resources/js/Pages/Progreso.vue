<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ProgressChart from "@/Components/ProgressChart.vue";
import DateRangePicker from "@/Components/ui/date-range-picker/DateRangePicker.vue";
import {
    CircleCheck,
    CircleEqual,
    CircleX,
    CirclePercent,
} from "lucide-vue-next";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Head title="Tu pogreso" />
    <MainLayout />
    <!-- Resumen de kanjis por nivel -->
    <div class="container my-12">
        <div
            class="grid grid-cols-2 text-primary-foreground shadow-lg sm:grid-cols-3 lg:grid-cols-6"
        >
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-zinc-500"
            >
                <p class="text-5xl font-bold">1600</p>
                <p>nuevos</p>
            </div>
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-levels-learner"
            >
                <p class="text-5xl font-bold">220</p>
                <p>aprendiz</p>
            </div>
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-levels-educated"
            >
                <p class="text-5xl font-bold">180</p>
                <p>conocedor</p>
            </div>
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-levels-proficient"
            >
                <p class="text-5xl font-bold">100</p>
                <p>versado</p>
            </div>
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-levels-expert"
            >
                <p class="text-5xl font-bold">30</p>
                <p>experto</p>
            </div>
            <div
                class="flex h-40 min-w-40 grow flex-col items-center justify-center bg-levels-master"
            >
                <p class="text-5xl font-bold">2000</p>
                <p>maestro</p>
            </div>
        </div>
        <div
            class="mt-12 flex flex-col rounded-md bg-card p-3 shadow-md md:p-6 lg:flex-row"
        >
            <div
                class="flex flex-col items-center lg:order-last lg:basis-2/5 lg:pl-6"
            >
                <DateRangePicker />
                <div
                    class="flex w-full flex-col items-center justify-between sm:flex-row lg:flex-col xl:mt-5"
                >
                    <div
                        class="flex items-baseline bg-gradient-primary bg-clip-text text-transparent"
                    >
                        <span
                            class="text-7xl font-semibold sm:text-8xl md:text-9xl"
                            >200</span
                        >
                        <span class="text-3xl md:text-4xl">kanjis</span>
                    </div>
                    <div
                        class="mt-5 flex flex-col justify-evenly gap-2 text-lg md:text-xl xl:text-2xl"
                    >
                        <div class="flex items-center gap-2">
                            <CircleCheck class="text-emerald-500" :size="32" />
                            <p>
                                <span
                                    class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                                >
                                    1190
                                </span>
                                Aciertos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <CircleX class="text-rose-500" :size="32" />
                            <p>
                                <span
                                    class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                                >
                                    210
                                </span>
                                Fallos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <CircleEqual
                                class="text-foreground/70"
                                :size="32"
                            />
                            <p>
                                <span
                                    class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                                >
                                    1400
                                </span>
                                Repasos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <CirclePercent
                                class="text-foreground/70"
                                :size="32"
                            />
                            <p>
                                <span
                                    class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                                >
                                    85%
                                </span>
                                Aciertos
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <ProgressChart class="lg:basis-3/5" />
        </div>
        <div class="kanji-grid mt-10 grid gap-0.5">
            <div
                v-for="index in 2100"
                class="w-12 rounded-md bg-primary p-3 text-center text-primary-foreground"
            >
                <h2 class="font-semibold">{{ index }}</h2>
            </div>
        </div>
    </div>
    <!--      TODO:Lista de kanjis tipo tabla-->
</template>
