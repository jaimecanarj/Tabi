<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ReviewConfetti from "@/Components/ReviewConfetti.vue";
import { Button } from "@/Components/ui/button";

const props = defineProps<{ answersCorrect: number }>();

let title: string;
let subTitle: string;

switch (true) {
    case props.answersCorrect == 10:
        title = "¡Perfecto!";
        subTitle =
            "Los kanjis ya no tienen secretos para ti, al menos por hoy.";
        break;
    case props.answersCorrect >= 5 && props.answersCorrect < 10:
        title = "¡Bien hecho!";
        subTitle =
            "Vas por buen camino. Con cada paso te acercas más a tu objetivo.";
        break;
    default:
        title = "¡Eso es todo!";
        subTitle =
            "Aprender japonés es todo un viaje, y con cada repaso avanzas más.";
}
</script>

<template>
    <ReviewConfetti />
    <div class="rounded-md bg-gradient-primary p-12">
        <div
            class="flex flex-col items-center gap-12 lg:flex-row lg:gap-32 xl:gap-40"
        >
            <div class="text-light">
                <h2
                    class="text-center text-6xl sm:text-8xl lg:text-start lg:text-7xl lg:leading-tight xl:text-8xl"
                >
                    {{ title }}
                </h2>
                <p class="ml-2 mt-10 text-xl sm:text-2xl lg:text-3xl">
                    {{ subTitle }}
                </p>
            </div>
            <img
                src="/assets/Viajero%20enhorabuena.webp"
                alt="Viajero celebrando"
                class="w-96"
            />
        </div>
        <div class="mt-5 flex lg:mt-0">
            <Link href="/repasar" class="w-full">
                <Button
                    size="lg"
                    variant="secondary"
                    class="mt-4 w-full bg-light text-xl text-primary shadow-md transition-all duration-300 hover:translate-x-[4px] hover:translate-y-[-4px] hover:rounded-md hover:bg-light hover:shadow-[-4px_4px_0px_black] active:translate-x-[0px] active:translate-y-[0px] active:rounded-2xl active:shadow-none lg:w-80"
                >
                    Seguir repasando
                </Button>
            </Link>
        </div>
    </div>
</template>
