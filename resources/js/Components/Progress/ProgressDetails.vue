<script setup lang="ts">
import { computed } from "vue";
import {
    SquareSigma,
    SquareCheck,
    SquareX,
    SquarePercent,
} from "lucide-vue-next";

const props = defineProps<{
    data: {
        kanjisStudiedNumber: number;
        userStudySessions: number;
        userCorrectAnswers: number;
    };
}>();

let kanjisStudied = props.data.kanjisStudiedNumber;
let studyAttempts = props.data.userStudySessions;
let studyCorrect = props.data.userCorrectAnswers;

let studyWrong = computed(() => studyAttempts - studyCorrect);

let studyPercentage = computed(() => {
    if (studyAttempts === 0) return 0;
    return Math.round((studyCorrect / studyAttempts) * 100);
});
</script>

<template>
    <div
        class="flex w-full flex-col items-center justify-between sm:flex-row lg:flex-col xl:mt-5"
    >
        <div
            class="flex items-baseline bg-gradient-primary-to-alt bg-clip-text text-transparent"
        >
            <span class="text-7xl font-semibold sm:text-8xl md:text-9xl">
                {{ kanjisStudied }}
            </span>
            <span class="text-3xl md:text-4xl">kanjis</span>
        </div>
        <div
            class="mt-5 flex flex-col justify-evenly gap-2 text-lg md:text-xl xl:text-2xl"
        >
            <div class="flex items-center gap-2">
                <SquareSigma :size="32" />
                <p>
                    <span
                        class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                    >
                        {{ studyAttempts }}
                    </span>
                    Repasos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <SquareCheck class="text-emerald-500" :size="32" />
                <p>
                    <span
                        class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                    >
                        {{ studyCorrect }}
                    </span>
                    Aciertos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <SquareX class="text-rose-500" :size="32" />
                <p>
                    <span
                        class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                    >
                        {{ studyWrong }}
                    </span>
                    Fallos
                </p>
            </div>
            <div class="flex items-center gap-2">
                <SquarePercent :size="32" />
                <p>
                    <span
                        class="text-2xl font-semibold md:text-3xl xl:text-4xl"
                    >
                        {{ studyPercentage }}%
                    </span>
                    Aciertos
                </p>
            </div>
        </div>
    </div>
</template>
