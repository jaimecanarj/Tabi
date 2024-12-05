<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Crown, SquareSigma, SquareCheck, SquareX } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";

const props = defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();

let kanjisStudied: number[] = [];
let studyAttempts = 0;
let studyCorrect = 0;
let studyWrong = 0;

props.estudios.forEach((estudio) => {
    studyAttempts++;
    if (!kanjisStudied.includes(estudio.kanji_id)) {
        kanjisStudied.push(estudio.kanji_id);
    }
    if (estudio.respuesta) {
        studyCorrect++;
    } else {
        studyWrong++;
    }
});
</script>

<template>
    <section class="bg-gradient-primary-to-alt mt-10 rounded-xl p-6 shadow-md">
        <Link href="/progreso">
            <h2
                class="inline-flex items-center gap-2 text-3xl font-bold text-light"
            >
                <Crown :size="32" />Tu progreso
            </h2>
        </Link>
        <div
            class="mt-2 flex flex-col justify-between gap-3 text-light sm:flex-row"
        >
            <div class="text-3xl sm:text-5xl">
                <span class="text-7xl font-semibold sm:text-8xl">{{
                    kanjisStudied.length
                }}</span>
                kanjis
            </div>
            <div class="text-2xl">
                <div class="flex items-center gap-1">
                    <SquareSigma :size="30" />
                    <span class="font-semibold">{{ studyAttempts }}</span>
                    <span>repasos</span>
                </div>
                <div class="flex items-center gap-1">
                    <SquareCheck :size="30" />
                    <span class="font-semibold">{{ studyCorrect }}</span>
                    <span>aciertos</span>
                </div>
                <div class="flex items-center gap-1">
                    <SquareX :size="30" />
                    <span class="font-semibold">{{ studyWrong }}</span>
                    <span>fallos</span>
                </div>
            </div>
        </div>
    </section>
</template>
