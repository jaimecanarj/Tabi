<script setup lang="ts">
import { computed } from "vue";
import moment from "moment/moment";
import "moment/locale/es";
import {
    SquareSigma,
    SquareCheck,
    SquareX,
    CalendarClock,
} from "lucide-vue-next";
import { Study } from "@/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ studies: Study[] }>();

const lastStudy = props.studies[0];

//Fecha del próximo estudio
const nextStudy = computed(() => {
    let result = moment(lastStudy.date)
        .add(lastStudy.time, "hours")
        .from(moment());
    return result.includes("hace") ? "disponible" : result;
});

const level = computed(() => {
    let result = kanjiLevels.find(
        (level) => lastStudy.time / 24 < level.threshold,
    );
    return result ?? kanjiLevels[0];
});
</script>

<template>
    <div class="flex flex-col gap-5">
        <h2 class="text-4xl font-semibold">Tu progreso</h2>
        <div class="flex flex-col gap-2 text-lg">
            <div
                :class="[
                    'flex items-center justify-center gap-2 rounded-md p-2 font-semibold text-light',
                    level.bgColor,
                ]"
            >
                <component :is="level.icon" />
                {{ level.name }}
            </div>
            <div class="mx-2 mt-6 flex items-center gap-2">
                <SquareSigma />
                <p>
                    <span class="text-xl font-semibold">
                        {{ lastStudy.attempts }}
                    </span>
                    Intentos
                </p>
            </div>
            <div class="mx-2 flex items-center gap-2">
                <SquareCheck class="text-emerald-500" />
                <p>
                    <span class="text-xl font-semibold">
                        {{ lastStudy.successes }}
                    </span>
                    Aciertos
                </p>
            </div>
            <div class="mx-2 flex items-center gap-2">
                <SquareX class="text-rose-500" />
                <p>
                    <span class="text-xl font-semibold">
                        {{ lastStudy.attempts - lastStudy.successes }}
                    </span>
                    Fallos
                </p>
            </div>
            <div class="mx-2 flex items-center gap-2">
                <CalendarClock />
                <p>
                    Repaso
                    <span class="font-semibold">
                        {{ nextStudy }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</template>
