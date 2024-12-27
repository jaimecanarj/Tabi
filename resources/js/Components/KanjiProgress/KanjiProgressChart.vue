<script setup lang="ts">
import { watch } from "vue";
import VueApexCharts from "vue3-apexcharts";
import { useColorMode } from "@vueuse/core";
import { Study } from "@/types";

const props = defineProps<{ studies: Study[] }>();

const mode = useColorMode({ disableTransition: false });

watch(mode, (mode) => {
    chartOptions["theme"].mode = mode;
});

const series = [
    {
        name: "Días",
        data: props.studies
            .map((study) => parseFloat((study.time / 24).toFixed(2)))
            .reverse(),
    },
];

const chartOptions = {
    chart: {
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
        categories: props.studies.map((study) => study.attempts).reverse(),
        tickAmount: 5,
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
    grid: { padding: { top: 0, right: 0, bottom: 0, left: 0 } },
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
        height="350"
        :key="mode"
        :options="chartOptions"
        :series="series"
    ></VueApexCharts>
</template>
