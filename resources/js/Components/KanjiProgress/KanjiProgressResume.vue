<script setup lang="ts">
import { computed } from "vue";
import moment from "moment/moment";
import "moment/locale/es";
import { CircleCheck, CircleEqual, CircleX, Clock } from "lucide-vue-next";
import { Estudio } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ estudios: Estudio[] }>();

//Fecha del próximo estudio
const nextStudy = computed(() => {
    let result = moment(props.estudios[0].fecha)
        .add(props.estudios[0].tiempo, "hours")
        .from(moment());
    return result.includes("hace") ? "disponible" : result;
});

const level = computed(() => {
    let result = kanjiLevels.find(
        (level) => props.estudios[0].tiempo / 24 < level.threshold,
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
                    'text-light flex items-center justify-center gap-2 rounded-md p-2 font-semibold',
                    level.color,
                ]"
            >
                <component :is="level.icon" />
                {{ level.name }}
            </div>
            <div class="flex items-center gap-2">
                <CircleCheck class="text-emerald-500" />
                <p>
                    <span class="font-semibold">
                        {{ estudios[0].aciertos }}
                    </span>
                    Aciertos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <CircleX class="text-rose-400" />
                <p>
                    <span class="font-semibold">
                        {{ estudios[0].intentos - estudios[0].aciertos }}
                    </span>
                    Fallos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <CircleEqual class="text-foreground/70" />
                <p>
                    <span class="font-semibold">
                        {{ estudios[0].intentos }}
                    </span>
                    Intentos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <Clock class="text-primary-alt" />
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
