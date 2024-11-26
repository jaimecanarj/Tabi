<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import moment from "moment/moment";
import { ChevronRight } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";
import Button from "@/Components/ui/button/Button.vue";
import { Badge } from "@/Components/ui/badge";

const page = usePage();

const props = defineProps<{
    type: string;
    estudios: (Estudio & { kanji: Kanji })[];
}>();

const typeStudy = props.type == "estudio";

let kanjisStudied: number;
let kanjisToStudy = 0;

if (typeStudy) {
    //Calcular estudiados hoy
    kanjisStudied = props.estudios.reduce((acc, estudio) => {
        if (
            estudio.intentos == 1 &&
            moment(estudio.fecha).isSame(moment(), "day")
        ) {
            return acc + 1;
        }
        return acc;
    }, 0);
    //Calcular por estudiar hoy
    kanjisToStudy = page.props.auth.user.estudio_diario - kanjisStudied;
    kanjisToStudy = kanjisToStudy < 0 ? 0 : kanjisToStudy;
} else {
    //Calcular repasados hoy
    kanjisStudied = props.estudios.reduce((acc, estudio) => {
        if (
            estudio.intentos != 1 &&
            moment(estudio.fecha).isSame(moment(), "day")
        ) {
            return acc + 1;
        }
        return acc;
    }, 0);
    //Calcular repasos disponibles
    const kanjisSeen: number[] = [];
    props.estudios.forEach((estudio) => {
        if (!kanjisSeen.includes(estudio.kanji_id)) {
            moment(estudio.fecha)
                .add(estudio.tiempo, "hours")
                .isBefore(moment()) && kanjisToStudy++;

            kanjisSeen.push(estudio.kanji_id);
        }
    });
}
</script>

<template>
    <div
        :class="[
            typeStudy ? 'bg-primary' : 'bg-primary-alt',
            'w-full min-w-[296px] rounded-md p-5 shadow-lg',
        ]"
    >
        <div class="flex justify-between">
            <div class="ml-1 flex flex-col justify-evenly">
                <div
                    class="mb-3 flex items-end gap-2 text-2xl font-semibold text-primary-foreground sm:text-3xl"
                >
                    {{ typeStudy ? "Estudiar" : "Repasar" }}
                    <Badge
                        variant="secondary"
                        :class="[
                            typeStudy ? 'text-primary' : 'text-primary-alt',
                            'min-w-10 justify-center bg-primary-foreground text-base text-primary hover:bg-primary-foreground',
                        ]"
                    >
                        {{ kanjisToStudy }}
                    </Badge>
                </div>
                <div class="flex flex-col leading-8 sm:flex-row xl:flex-col">
                    <p class="mr-1 inline text-primary-foreground">
                        Hoy has
                        {{ typeStudy ? "estudiado" : "repasado" }}
                    </p>
                    <p class="inline text-primary-foreground">
                        <span class="text-xl font-semibold underline">
                            {{ kanjisStudied }}
                        </span>
                        kanjis.
                    </p>
                </div>
            </div>
            <div>
                <img
                    :src="
                        typeStudy
                            ? '/assets/Viajero%20con%20pergamino.webp'
                            : '/assets/Viajero.webp'
                    "
                    alt="aah"
                    class="w-32 sm:w-40"
                />
            </div>
        </div>
        <Link :href="typeStudy ? '/estudiar' : '/repasar'">
            <Button
                variant="secondary"
                class="mt-2 w-full bg-primary-foreground text-xl text-primary hover:bg-primary-foreground"
            >
                <p>Empezar a {{ typeStudy ? "estudiar" : "repasar" }}</p>
                <ChevronRight :size="28" class="mt-1.5" />
            </Button>
        </Link>
    </div>
</template>
