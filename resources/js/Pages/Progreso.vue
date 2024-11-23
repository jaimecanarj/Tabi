<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Estudio, Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ProgressChart from "@/Components/Progress/ProgressChart.vue";
import ProgressLevels from "@/Components/Progress/ProgressLevels.vue";
import ProgressTable from "@/Components/Progress/ProgressTable.vue";
import ProgressDetails from "@/Components/Progress/ProgressDetails.vue";
import DateRangePicker from "@/Components/ui/date-range-picker/DateRangePicker.vue";

defineProps<{ kanjis: (Kanji & { estudios: Estudio[] })[] }>();
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
                <DateRangePicker />
                <ProgressDetails :kanjis="kanjis" />
            </div>
            <ProgressChart class="lg:basis-3/5" />
        </div>
        <!--Tabla de kanjis por nivel-->
        <ProgressTable :kanjis="kanjis" />
    </div>
</template>
