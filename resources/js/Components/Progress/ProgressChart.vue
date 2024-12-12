<script setup lang="ts">
import { watch } from "vue";
import VueApexCharts from "vue3-apexcharts";
import { useColorMode } from "@vueuse/core";
import moment from "moment/moment";
import "moment/locale/es";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{
    kanjis: (Kanji & { estudios: Estudio[] })[];
}>();

const mode = useColorMode({ disableTransition: false });

const height = window.innerWidth < 640 ? 350 : "auto";

watch(mode, (mode) => {
    chartOptions["theme"].mode = mode;
});

type SeriesType = { name: string; data: { x: string; y: number }[] };

//Creador de series
const createEmptySeries = (name: string): SeriesType => ({ name, data: [] });

//Inicializar datos
const updatesByDay: Record<string, SeriesType> = {
    Aprendiz: createEmptySeries("Aprendiz"),
    Conocedor: createEmptySeries("Conocedor"),
    Versado: createEmptySeries("Versado"),
    Experto: createEmptySeries("Experto"),
    Maestro: createEmptySeries("Maestro"),
};

//Actualizar o crear serie en base a fecha
const updateSeriesData = (
    series: SeriesType,
    date: string,
    increment: number,
) => {
    const existingEntry = series.data.find((entry) => entry.x === date);
    if (existingEntry) {
        existingEntry.y += increment;
    } else {
        series.data.push({ x: date, y: increment });
    }
};

//Obtengo las actualizaciones por día de cada nivel
props.kanjis.forEach((kanji) => {
    if (kanji.estudios.length) {
        let currentLevel = "";

        for (const estudio of [...kanji.estudios].reverse()) {
            // Obtener nivel del estudio
            let newLevel = kanjiLevels.find((levelData) => {
                return estudio.tiempo / 24 < levelData.threshold;
            })!;
            //Fecha del estudio
            const date = estudio.fecha.split(" ")[0];

            // Primera iteración
            if (!currentLevel) {
                updateSeriesData(updatesByDay.Aprendiz, date, 1);
            }
            // Si cambia de nivel
            else if (newLevel.name !== currentLevel) {
                updateSeriesData(updatesByDay[currentLevel], date, -1);
                updateSeriesData(updatesByDay[newLevel.name], date, 1);
            }
            //Añadir fecha a todas las series
            kanjiLevels.forEach((level) => {
                if (level.name == "Nuevos") return;
                updateSeriesData(updatesByDay[level.name], date, 0);
            });
            // Actualizar nivel
            currentLevel = newLevel.name;
        }
    }
});

const series = Object.values(updatesByDay);

//Ordeno las series por fecha
series.forEach((series) => {
    series.data.sort((a, b) => {
        return new Date(a.x).getTime() - new Date(b.x).getTime();
    });
});

//Calculo el sumatorio
series.forEach((serie) => {
    let counter = 0;
    serie.data = serie.data.map((row) => {
        counter += row.y;
        return { ...row, y: counter };
    });
});

const chartOptions = {
    chart: {
        type: "area",
        height: 350,
        stacked: true,
        background: "transparent",
        parentHeightOffset: 0,
        zoom: {
            autoScaleYaxis: true,
        },
        toolbar: {
            show: false,
        },
    },
    colors: ["#7A9CED", "#7A82ED", "#A084EF", "#C284EF", "#E8C471"],
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    stroke: {
        colors: ["#4777E6", "#4752E6", "#7C54E9", "#AD54E9", "#E3AF35"],
    },
    fill: {
        type: "solid",
    },
    xaxis: {
        type: "datetime",
        labels: {
            formatter: function (val: string) {
                return moment(val).format("DD MMM");
            },
            style: {
                fontSize: "16px",
            },
        },
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
            :height="height"
            :key="mode"
            :options="chartOptions"
            :series="series"
        ></VueApexCharts>
    </div>
</template>
