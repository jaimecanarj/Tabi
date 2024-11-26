<script setup lang="ts">
import moment from "moment/moment";
import "moment/locale/es";
import { CalendarClock } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";
import {
    Accordion,
    AccordionItem,
    AccordionTrigger,
    AccordionContent,
} from "@/Components/ui/accordion";

const props = defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();

//Obtener próximos estudios de cada kanji
let kanjisToStudy: moment.Moment[] = [];
const kanjisSeen: number[] = [];
props.estudios.forEach((estudio) => {
    if (!kanjisSeen.includes(estudio.kanji_id)) {
        kanjisToStudy.push(moment(estudio.fecha).add(estudio.tiempo, "hours"));
        kanjisSeen.push(estudio.kanji_id);
    }
});

//Ordenar por fecha
kanjisToStudy.sort((a, b) => {
    return a.isBefore(b) ? -1 : 1;
});

let dates: {
    fecha: string;
    data: { hour: string; items: number }[];
    total: number;
}[] = [];

kanjisToStudy.forEach((date) => {
    const now = moment();
    const dateString = date.isBefore(now)
        ? now.format("D [de] MMMM")
        : date.format("D [de] MMMM");
    const hour = date.isBefore(now) ? now.format("HH") : date.format("HH");

    let dateEntry = dates.find((entry) => dateString == entry.fecha);

    if (!dateEntry) {
        // Crear nueva fecha si no existe
        dates.push({
            fecha: dateString,
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
    <section class="mt-10 rounded-xl bg-card p-6 shadow-md md:mt-0">
        <h2
            class="flex items-center gap-2 border-b-4 border-primary pb-2 text-3xl font-semibold"
        >
            <CalendarClock :size="32" />Repasos
        </h2>
        <div class="mt-3 flex flex-col">
            <Accordion type="single" class="w-full" collapsible>
                <AccordionItem v-for="date in dates" :value="date.fecha">
                    <AccordionTrigger
                        class="hover:text-primary hover:no-underline"
                    >
                        <div
                            class="flex w-full justify-between pr-3 text-lg capitalize"
                        >
                            <p>{{ date.fecha }}</p>
                            <p>{{ date.total }}</p>
                        </div>
                    </AccordionTrigger>
                    <AccordionContent>
                        <div
                            class="flex justify-between gap-2 px-7 text-base"
                            v-for="hour in date.data"
                        >
                            <p>{{ hour.hour }}:00</p>
                            <p>{{ hour.items }}</p>
                        </div>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>
        </div>
    </section>
</template>
