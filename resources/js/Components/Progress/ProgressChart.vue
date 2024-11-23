<script setup lang="ts">
import VueApexCharts from "vue3-apexcharts";
import { useColorMode } from "@vueuse/core";
import { watch } from "vue";

const mode = useColorMode({ disableTransition: false });

watch(mode, (mode) => {
    chartOptions["theme"].mode = mode;
});

const series = [
    {
        name: "Aprendiz",
        data: [
            { x: "02-10-2017 GMT", y: 34 },
            { x: "02-11-2017 GMT", y: 59 },
            { x: "02-12-2017 GMT", y: 84 },
            { x: "02-13-2017 GMT", y: 110 },
            { x: "02-14-2017 GMT", y: 130 },
            { x: "02-15-2017 GMT", y: 160 },
        ],
    },
    {
        name: "Conocedor",
        data: [
            { x: "02-10-2017 GMT", y: 44 },
            { x: "02-11-2017 GMT", y: 72 },
            { x: "02-12-2017 GMT", y: 95 },
            { x: "02-13-2017 GMT", y: 118 },
            { x: "02-14-2017 GMT", y: 142 },
            { x: "02-15-2017 GMT", y: 167 },
        ],
    },
    {
        name: "Versado",
        data: [
            { x: "02-10-2017 GMT", y: 44 },
            { x: "02-11-2017 GMT", y: 72 },
            { x: "02-12-2017 GMT", y: 96 },
            { x: "02-13-2017 GMT", y: 121 },
            { x: "02-14-2017 GMT", y: 141 },
            { x: "02-15-2017 GMT", y: 173 },
        ],
    },
    {
        name: "Experto",
        data: [
            { x: "02-10-2017 GMT", y: 44 },
            { x: "02-11-2017 GMT", y: 76 },
            { x: "02-12-2017 GMT", y: 100 },
            { x: "02-13-2017 GMT", y: 124 },
            { x: "02-14-2017 GMT", y: 145 },
            { x: "02-15-2017 GMT", y: 175 },
        ],
    },
    {
        name: "Maestro",
        data: [
            { x: "02-10-2017 GMT", y: 44 },
            { x: "02-11-2017 GMT", y: 73 },
            { x: "02-12-2017 GMT", y: 98 },
            { x: "02-13-2017 GMT", y: 122 },
            { x: "02-14-2017 GMT", y: 145 },
            { x: "02-15-2017 GMT", y: 174 },
        ],
    },
];

const chartOptions = {
    chart: {
        type: "area",
        height: 350,
        stacked: true,
        background: "transparent",
        parentHeightOffset: 0,

        toolbar: {
            show: false,
        },
    },
    colors: ["#4777E6", "#4752E6", "#7C54E9", "#AD54E9", "#E3AF35"],
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: 0.6,
            opacityTo: 0.8,
        },
    },
    xaxis: {
        type: "datetime",
    },
    yaxis: { show: false },
    grid: { padding: { top: 0, right: 0, bottom: 0, left: 0 } },
    theme: {
        mode: mode.value,
    },
};
</script>

<template>
    <div id="chart">
        <VueApexCharts
            :key="mode"
            :options="chartOptions"
            :series="series"
        ></VueApexCharts>
    </div>
</template>
