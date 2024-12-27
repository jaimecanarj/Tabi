<script setup lang="ts">
import { ref } from "vue";
import { ChevronRight, CircleAlert } from "lucide-vue-next";
import { Kanji, Answer } from "@/types";
import { Input } from "@/Components/ui/input";

const props = defineProps<{ kanji: Kanji }>();
const emit = defineEmits(["answer"]);

const answer = ref<Answer>({
    userAnswer: "",
    answered: false,
    answerResult: undefined,
});

const checkAnswer = () => {
    if (answer.value.answered) {
        emit("answer", answer.value);
        answer.value = {
            userAnswer: "",
            answered: false,
            answerResult: undefined,
        };
    } else {
        //Compruebo resultado sin mayúsculas ni tildes
        answer.value.answerResult =
            props.kanji.meaning.localeCompare(
                answer.value.userAnswer,
                undefined,
                {
                    sensitivity: "base",
                },
            ) == 0;
        emit("answer", answer.value);
        answer.value.answered = true;
    }
};
</script>

<template>
    <form @submit.prevent="checkAnswer" class="relative">
        <Input
            v-model="answer.userAnswer"
            required
            :class="[
                {
                    '!border-emerald-500 !bg-emerald-500': answer.answerResult,
                    '!border-destructive !bg-destructive':
                        answer.answerResult == false,
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
        <div
            v-show="answer.answerResult == false"
            class="absolute left-1/2 right-1/2 mt-2 flex animate-pulse justify-center"
        >
            <div
                class="flex items-center gap-2 rounded-md bg-accent px-4 py-2 shadow-md"
            >
                <CircleAlert />
                <p class="text-nowrap text-2xl first-letter:capitalize">
                    {{ kanji.meaning }}
                </p>
            </div>
        </div>
    </form>
</template>
