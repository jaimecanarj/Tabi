<script setup lang="ts">
import { Ref, ref, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import type { DateRange } from "radix-vue";
import { CalendarDate } from "@internationalized/date";
import { Estudio, Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ProgressChart from "@/Components/Progress/ProgressChart.vue";
import ProgressLevels from "@/Components/Progress/ProgressLevels.vue";
import ProgressTable from "@/Components/Progress/ProgressTable.vue";
import ProgressDetails from "@/Components/Progress/ProgressDetails.vue";
import DateRangePicker from "@/Components/ui/date-range-picker/DateRangePicker.vue";

const props = defineProps<{
    kanjis: (Kanji & { estudios: Estudio[] })[];
    fechas: { inicio: string; fin: string };
    details: {
        kanjisStudiedNumber: number;
        userStudySessions: number;
        userCorrectAnswers: number;
    };
}>();

let fechaInicio = props.fechas.inicio.split("-");
let fechaFin = props.fechas.fin.split("-");

//Definido as any porque typescript no entiende bien el tipo
const dates: Ref<DateRange> = ref({
    start: new CalendarDate(
        parseInt(fechaInicio[0]),
        parseInt(fechaInicio[1]),
        parseInt(fechaInicio[2]),
    ) as any,
    end: new CalendarDate(
        parseInt(fechaFin[0]),
        parseInt(fechaFin[1]),
        parseInt(fechaFin[2]),
    ) as any,
});

watch(dates, (newValue) => {
    if (newValue.end) {
        router.get(
            "/progreso",
            { start: newValue.start?.toString(), end: newValue.end.toString() },
            {
                preserveScroll: true,
                replace: true,
            },
        );
    }
});
</script>

<template>
    <Head title="Tu pogreso" />
    <MainLayout />
    <div class="container my-12">
        <!-- Resumen de kanjis por nivel -->
        <ProgressLevels :kanjis="kanjis" />
        <!--Tarjeta central-->
        <div
            class="mt-12 flex flex-col rounded-md bg-card p-3 shadow-md md:p-6 lg:flex-row"
        >
            <div
                class="flex flex-col items-center lg:order-last lg:basis-2/5 lg:pl-6"
            >
                <DateRangePicker v-model="dates" />
                <ProgressDetails :data="details" />
            </div>
            <ProgressChart class="lg:basis-3/5" :kanjis="kanjis" />
        </div>
        <!--Tabla de kanjis por nivel-->
        <ProgressTable :kanjis="kanjis" />
    </div>
</template>
