<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Kanji, Reading, Radical, Meaning } from "@/types";
import { Badge } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

const props = defineProps<{
    kanji: Kanji;
    readings: Reading[];
    meanings: Meaning[];
    radicals: Radical[];
    similarKanjis: Kanji[];
}>();

const onyomiReadings = props.readings.filter(
    (reading) => reading.type == "onyomi",
);
const kunyomiReadings = props.readings.filter(
    (reading) => reading.type == "kunyomi",
);
</script>

<template>
    <!-- Datos básicos -->
    <div class="mb-3 flex flex-col sm:flex-row sm:space-x-3">
        <div>
            <h3 class="mr-1 inline text-lg">Trazos:</h3>
            <span class="text-lg font-semibold">{{ kanji.strokes }}</span>
        </div>
        <div>
            <h3 class="mr-1 inline text-lg">Grado:</h3>
            <span class="text-lg font-semibold">{{ kanji.grade }}</span>
        </div>
        <div v-if="kanji.frequency">
            <h3 class="mr-1 inline text-lg">Frecuencia:</h3>
            <span class="text-lg font-semibold">{{ kanji.frequency }}</span
            ><span> de 2500</span>
        </div>
    </div>
    <!-- Lecturas -->
    <div class="mb-3">
        <h3 class="text-lg font-semibold tracking-tight">Lecturas</h3>
        <div class="flex flex-col flex-wrap lg:flex-row">
            <div class="mr-6">
                <h4 class="mr-2 inline tracking-tight">Onyomi:</h4>
                <Badge
                    variant="secondary"
                    class="m-1 text-base"
                    v-for="reading of onyomiReadings"
                >
                    {{ reading.reading }}
                </Badge>
            </div>
            <div v-if="kunyomiReadings.length">
                <h4 class="mr-2 inline tracking-tight">Kunyomi:</h4>
                <Badge
                    variant="secondary"
                    class="m-1 text-base"
                    v-for="reading of kunyomiReadings"
                >
                    {{ reading.reading }}
                </Badge>
            </div>
        </div>
    </div>
    <!-- Significados -->
    <div class="mb-3" v-if="meanings.length">
        <h3 class="text-lg font-semibold tracking-tight">Significados</h3>
        <Badge
            variant="secondary"
            class="m-1 text-base first-letter:capitalize"
            v-for="meaning of meanings"
        >
            {{ meaning.meaning }}
        </Badge>
    </div>
    <div class="flex flex-col lg:flex-row lg:space-x-20">
        <!-- Radicales -->
        <div class="lg:max-w-[50%]">
            <h3 class="text-lg font-semibold tracking-tight">Radicales</h3>
            <template v-for="radical of radicals">
                <Link :href="`/radicales/${radical.id}`">
                    <HoverCard>
                        <HoverCardTrigger asChild>
                            <Button
                                variant="secondaryGradient"
                                size="gradient"
                                class="m-1"
                            >
                                <p>
                                    {{ radical.literal }}
                                </p>
                            </Button>
                        </HoverCardTrigger>
                        <HoverCardContent class="w-fit max-w-48">
                            <p class="capitalize">
                                {{ radical.meaning }}
                            </p>
                        </HoverCardContent>
                    </HoverCard>
                </Link>
            </template>
        </div>
        <!-- Kanjis similares -->
        <div v-if="similarKanjis.length" class="lg:max-w-[50%]">
            <h3 class="text-lg font-semibold tracking-tight">
                Kanjis similares
            </h3>
            <template v-for="similarKanji of similarKanjis">
                <Link :href="`/kanjis/${similarKanji.id}`">
                    <HoverCard>
                        <HoverCardTrigger asChild>
                            <Button
                                variant="secondaryGradient"
                                size="gradient"
                                class="m-1"
                            >
                                {{ similarKanji.literal }}
                            </Button>
                        </HoverCardTrigger>
                        <HoverCardContent class="w-fit max-w-48">
                            <p class="capitalize">
                                {{ similarKanji.meaning }}
                            </p>
                        </HoverCardContent>
                    </HoverCard>
                </Link>
            </template>
        </div>
    </div>
</template>
