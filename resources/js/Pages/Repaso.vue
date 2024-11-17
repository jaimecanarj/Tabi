<script setup lang="ts">
//TODO: Si no hay más kanjis en kanjisToAnswer, acabar la sesión
//TODO: Al fallar, mostrar de alguna manera la solución
//TODO: Hacer storeStudy dinámico para que meta los datos basados en updateRecall
import { ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import axios from "axios";
import moment from "moment";
import * as ebisu from "ebisu-js";
import { ChevronRight } from "lucide-vue-next";
import EstudioLayout from "@/Layouts/EstudioLayout.vue";
import { Kanji, Question } from "@/lib/types";
import { Input } from "@/Components/ui/input";

const page = usePage();
const props = defineProps<{ kanjis: Kanji[] }>();

let kanjisToAnswer: Kanji[] = [];

//Obtener kanjis a repasar
if (props.kanjis[0].estudio) {
    //Ordenar por posibilidad de olvidarse
    kanjisToAnswer = props.kanjis
        .toSorted((kanjiA, kanjiB) => {
            let kanjiAModel = ebisu.defaultModel(
                kanjiA.estudio!.tiempo,
                kanjiA.estudio!.betaA,
                kanjiA.estudio!.betaB,
            );
            let kanjiATime = moment().diff(
                moment(kanjiA.estudio!.fecha, "YYYY-MM-DD HH:mm:ss"),
                "hours",
            );
            let kanjiBModel = ebisu.defaultModel(
                kanjiB.estudio!.tiempo,
                kanjiB.estudio!.betaA,
                kanjiB.estudio!.betaB,
            );
            let kanjiBTime = moment().diff(
                moment(kanjiB.estudio!.fecha, "YYYY-MM-DD HH:mm:ss"),
                "hours",
            );
            return (
                ebisu.predictRecall(kanjiAModel, kanjiATime) -
                ebisu.predictRecall(kanjiBModel, kanjiBTime)
            );
        })
        .slice(0, 10);
} else {
    kanjisToAnswer = props.kanjis.toSorted(() => Math.random() - 0.5);
}

let kanjisAnswered: number = 1; //Contador
let kanji = ref(kanjisToAnswer[0]); //Kanji a repasar

const question = ref<Question>({
    answer: "",
    answered: false,
    answerResult: undefined,
});

const handleForm = () => {
    if (question.value.answered) {
        kanji.value = kanjisToAnswer[0]; //Actualizar kanji
        if (kanjisToAnswer.length + kanjisAnswered == 10) kanjisAnswered++; //Actualizar contador
        //Reiniciar formulario
        question.value.answer = "";
        question.value.answered = false;
        question.value.answerResult = undefined;
    } else {
        checkAnswer();
    }
};
const checkAnswer = () => {
    if (
        //Compruebo resultado sin mayúsculas ni tildes
        kanji.value.significado.localeCompare(
            question.value.answer,
            undefined,
            {
                sensitivity: "base",
            },
        ) == 0
    ) {
        question.value.answerResult = true; //Respueta correcta
        kanjisToAnswer.shift(); //Eliminar kanji de la lista
        storeStudy(); //Añadir a tabla estudios
    } else {
        question.value.answerResult = false; //Respueta incorrecta
        if (kanji.value.estudio) {
            //Repaso
            kanjisToAnswer.shift(); //Eliminar kanji de la lista
            storeStudy(); //Añadir a tabla estudios
        } else {
            //Estudio
            kanjisToAnswer.sort(() => Math.random() - 0.5); //Mezclar lista de kanjis
        }
    }
    question.value.answered = true; //Marcar como respondida
};

const storeStudy = async () => {
    let model = ebisu.defaultModel(48, 3, 3);
    let correctAnswers = 1;
    let attempts = 1;

    if (kanji.value.estudio) {
        model = ebisu.defaultModel(
            kanji.value.estudio.tiempo,
            kanji.value.estudio.betaA,
            kanji.value.estudio.betaB,
        );
        attempts += kanji.value.estudio.intentos;
        if (question.value.answerResult) {
            correctAnswers += kanji.value.estudio.aciertos;
        } else {
            correctAnswers = kanji.value.estudio.aciertos;
        }
        let newTime = moment().diff(
            moment(kanji.value.estudio.fecha, "YYYY-MM-DD HH:mm:ss"),
            "hours",
        );
        model = ebisu.updateRecall(
            model,
            question.value.answerResult ? 1 : 0,
            1,
            newTime,
        );
    }

    await axios.post("/repasar", {
        kanji_id: String(kanji.value.id),
        user_id: String(page.props.auth.user.id),
        tiempo: model[2],
        betaA: model[0],
        betaB: model[1],
        respuesta: question.value.answerResult,
        aciertos: correctAnswers,
        intentos: attempts,
    });
};
</script>

<template>
    <Head title="Estudio" />
    <EstudioLayout :kanji="kanji" :showData="question.answered">
        <template #significado>
            <form @submit.prevent="handleForm" class="relative">
                <Input
                    v-model="question.answer"
                    :class="[
                        {
                            '!border-emerald-500 !bg-emerald-500':
                                question.answerResult,
                            '!border-destructive !bg-destructive':
                                question.answerResult == false,
                        },
                        'h-20 rounded-b-md rounded-t-none bg-card p-4 px-10 text-center text-3xl focus-visible:ring-0 focus-visible:ring-offset-0 sm:text-4xl lg:text-5xl',
                    ]"
                    placeholder="Tu respuesta"
                />
                <button class="absolute -right-2 top-2">
                    <ChevronRight
                        :stroke-width="1"
                        class="h-16 w-16 hover:text-primary"
                    />
                </button>
            </form>
        </template>
        <template #footer>
            <footer
                class="sticky top-[100vh] mb-6 mt-10 flex justify-center text-xl"
            >
                {{ kanjisAnswered }} de 10
            </footer>
        </template>
    </EstudioLayout>
</template>
