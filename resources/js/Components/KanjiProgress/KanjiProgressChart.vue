<script setup lang="ts">
import { watch } from "vue";
import VueApexCharts from "vue3-apexcharts";
import { useColorMode } from "@vueuse/core";
import { Estudio } from "@/lib/types";

const props = defineProps<{ estudios: Estudio[] }>();

const mode = useColorMode({ disableTransition: false });

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
        labels: {
            style: {
                fontSize: "14px",
            },
        },
    },
    yaxis: {
        min: 0,
        max: Math.max(...series[0].data) + 1,
        forceNiceScale: true,
        decimalsInFloat: 0,
        labels: {
            style: {
                fontSize: "14px",
            },
        },
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
    <VueApexCharts
        :key="mode"
        :options="chartOptions"
        :series="series"
    ></VueApexCharts>
</template>
