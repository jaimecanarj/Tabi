<script setup lang="ts">
import { computed, watch } from "vue";
import moment from "moment/moment";
import "moment/locale/es";
import VueApexCharts from "vue3-apexcharts";
import { useColorMode } from "@vueuse/core";
import {
    CircleCheck,
    CircleX,
    CircleEqual,
    Clock,
    Dice1,
} from "lucide-vue-next";
import { Estudio } from "@/lib/types";
import { ScrollArea } from "@/Components/ui/scroll-area";

const props = defineProps<{ estudios: Estudio[] }>();

const mode = useColorMode({ disableTransition: false });

const nextStudy = computed(() => {
    let result = moment(props.estudios[0].fecha)
        .add(props.estudios[0].tiempo, "hours")
        .from(moment());
    console.log(result);
    return result.includes("hace") ? "disponible" : result;
});

watch(mode, (mode) => {
    chartOptions["theme"].mode = mode;
});

const series = [
    {
        name: "Días",
        data: props.estudios
            .map((estudio) => parseFloat((estudio.tiempo / 24).toFixed(2)))
            .reverse(),
    },
];

const chartOptions = {
    chart: {
        height: 300,
        type: "area",
        background: "transparent",
        zoom: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
    },
    colors: ["#4752e6"],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
    },
    xaxis: {
        name: "Intento",
        categories: props.estudios.map((estudio) => estudio.intentos).reverse(),
    },
    yaxis: {
        min: Math.min(...series[0].data) - 1,
        max: Math.max(...series[0].data) + 1,
    },
    theme: {
        mode: mode.value,
    },
    tooltip: {
        x: {
            formatter: (value: number) => `${value} Intentos`,
        },
    },
};
</script>

<template>
    <section class="mx-6 my-10">
        <!-- Sin datos -->
        <div v-if="!estudios.length">
            <h2 class="text-4xl font-semibold">Tu progreso</h2>
            <p class="mt-5">Todavía no has estudiado este kanji.</p>
        </div>

        <!-- Con datos -->
        <div v-else class="flex flex-col justify-around lg:flex-row">
            <!-- Datos -->
            <div
                class="mb-4 flex flex-col justify-between gap-5 sm:flex-row lg:w-3/5"
            >
                <!-- Resumen -->
                <div class="flex flex-col gap-5">
                    <h2 class="text-4xl font-semibold">Tu progreso</h2>
                    <div class="flex flex-col gap-2 text-lg">
                        <div
                            class="flex items-center justify-center gap-2 rounded-md bg-primary p-2 text-primary-foreground"
                        >
                            <Dice1 />
                            Aprendiz
                        </div>
                        <div class="flex items-center gap-2">
                            <CircleCheck class="text-emerald-500" />
                            <p>
                                <span class="font-semibold">{{
                                    estudios[0].aciertos
                                }}</span>
                                Aciertos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <CircleX class="text-rose-400" />
                            <p>
                                <span class="font-semibold">{{
                                    estudios[0].intentos - estudios[0].aciertos
                                }}</span>
                                Fallos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <CircleEqual class="text-foreground/70" />
                            <p>
                                <span class="font-semibold">{{
                                    estudios[0].intentos
                                }}</span>
                                Intentos
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <Clock class="text-primary-alt" />
                            <p>
                                Repaso
                                <span class="font-semibold">
                                    {{ nextStudy }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Histórico -->
                <div class="mt-3 lg:mr-24">
                    <h2 class="mb-3 text-2xl font-semibold lg:px-3">
                        Histórico
                    </h2>
                    <ScrollArea class="h-60 w-48 lg:px-3">
                        <div
                            :class="[
                                { 'mb-6': index < estudios.length - 1 },
                                'relative',
                            ]"
                            v-for="(estudio, index) of estudios"
                        >
                            <span
                                v-if="index < estudios.length - 1"
                                class="absolute left-[0.7rem] top-8 h-2/3 w-0.5 bg-muted"
                            ></span>
                            <p class="capitalize">
                                <CircleCheck
                                    v-if="estudio.respuesta"
                                    class="inline text-emerald-500"
                                />
                                <CircleX v-else class="inline text-rose-400" />
                                {{
                                    moment
                                        .utc(estudio.fecha)
                                        .local()
                                        .format("DD MMM YYYY HH:mm")
                                }}
                            </p>
                        </div>
                    </ScrollArea>
                </div>
            </div>
            <!-- Gráfica -->
            <div class="lg:w-2/5">
                <VueApexCharts
                    :key="mode"
                    :options="chartOptions"
                    :series="series"
                ></VueApexCharts>
            </div>
        </div>
    </section>
</template>
