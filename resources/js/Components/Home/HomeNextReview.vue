<script setup lang="ts">
import moment from "moment/moment";
import "moment/locale/es";
import { CalendarClock } from "lucide-vue-next";
import { Study } from "@/types";
import { hourIcons } from "@/lib/utils";
import {
    Accordion,
    AccordionItem,
    AccordionTrigger,
    AccordionContent,
} from "@/Components/ui/accordion";

const props = defineProps<{ studies: Study[] }>();

//Obtener próximos estudios de cada kanji
let kanjisToStudy: moment.Moment[] = [];
props.studies.forEach((study) => {
    kanjisToStudy.push(moment.utc(study.date).add(study.time, "hours").local());
});

//Ordenar por fecha
kanjisToStudy.sort((a, b) => {
    return a.isBefore(b) ? -1 : 1;
});

let dates: {
    date: string;
    data: { hour: string; items: number }[];
    total: number;
}[] = [];

kanjisToStudy.forEach((date) => {
    const now = moment();
    const dateString = date.isBefore(now)
        ? now.format("D [de] MMMM")
        : date.format("D [de] MMMM");
    const hour = date.isBefore(now) ? now.format("HH") : date.format("HH");

    let dateEntry = dates.find((entry) => dateString == entry.date);

    if (!dateEntry) {
        // Crear nueva fecha si no existe
        dates.push({
            date: dateString,
            data: [{ hour: hour, items: 1 }],
            total: 1,
        });
    } else {
        // Añadir o actualizar hora a fecha
        const hourEntry = dateEntry.data.find((entry) => entry.hour === hour);
        if (!hourEntry) {
            dateEntry.data.push({ hour: hour, items: 1 });
        } else {
            hourEntry.items++;
        }
        //Actualizar total
        dateEntry.total++;
    }
});
</script>

<template>
    <section class="mt-10 rounded-xl bg-card shadow-md lg:mt-0">
        <h2
            class="mx-3 flex items-center gap-2 border-b-4 p-3 pb-2 pt-6 text-3xl font-semibold"
        >
            <CalendarClock :size="32" />Repasos
        </h2>

        <div class="flex flex-col pb-5">
            <h2 v-if="!dates.length" class="p-5 text-2xl">
                No tienes repasos pendientes.
            </h2>
            <Accordion v-else type="single" class="w-full px-6" collapsible>
                <AccordionItem v-for="date in dates" :value="date.date">
                    <AccordionTrigger
                        class="hover:text-primary hover:no-underline"
                    >
                        <div class="flex w-full justify-between pr-3 text-lg">
                            <p>{{ date.date }}</p>
                            <p class="rounded-sm bg-secondary px-2 shadow-sm">
                                {{ date.total }}
                            </p>
                        </div>
                    </AccordionTrigger>
                    <AccordionContent>
                        <div
                            class="flex justify-between gap-2 px-7 text-base"
                            v-for="hour in date.data"
                        >
                            <div class="flex items-center gap-1">
                                <component
                                    :is="hourIcons[parseInt(hour.hour)]"
                                    :size="16"
                                />
                                <p>{{ hour.hour }}:00</p>
                            </div>
                            <p class="px-2 text-lg">
                                {{ hour.items }}
                            </p>
                        </div>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>
        </div>
    </section>
</template>
