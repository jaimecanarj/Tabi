<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Kanji, Lectura, Radical, Significado } from "@/lib/types";
import { Badge } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "./ui/tooltip";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

const props = defineProps<{
    kanji: Kanji;
    lecturas: Lectura[];
    significados: Significado[];
    radicales: Radical[];
    similares: Kanji[];
}>();

const lecturasOnyomi = props.lecturas.filter(
    (lectura) => lectura.tipo == "onyomi",
);
const lecturasKunyomi = props.lecturas.filter(
    (lectura) => lectura.tipo == "kunyomi",
);
</script>

<template>
    <!-- Datos básicos -->
    <div class="mb-3 flex flex-col sm:flex-row sm:space-x-3">
        <div>
            <h3 class="mr-1 inline text-lg">Trazos:</h3>
            <span class="text-lg font-semibold">{{ kanji.trazos }}</span>
        </div>
        <div>
            <h3 class="mr-1 inline text-lg">Grado:</h3>
            <span class="text-lg font-semibold">{{ kanji.grado }}</span>
        </div>
        <div v-if="kanji.frecuencia">
            <h3 class="mr-1 inline text-lg">Frecuencia:</h3>
            <span class="text-lg font-semibold">{{ kanji.frecuencia }}</span
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
                    v-for="lectura of lecturasOnyomi"
                >
                    {{ lectura.lectura }}
                </Badge>
            </div>
            <div v-if="lecturasKunyomi.length">
                <h4 class="mr-2 inline tracking-tight">Kunyomi:</h4>
                <Badge
                    variant="secondary"
                    class="m-1 text-base"
                    v-for="lectura of lecturasKunyomi"
                >
                    {{ lectura.lectura }}
                </Badge>
            </div>
        </div>
    </div>
    <!-- Significados -->
    <div class="mb-3" v-if="significados.length">
        <h3 class="text-lg font-semibold tracking-tight">Significados</h3>
        <Badge
            variant="secondary"
            class="m-1 text-base first-letter:capitalize"
            v-for="significado of significados"
        >
            {{ significado.significado }}
        </Badge>
    </div>
    <div class="flex flex-col lg:flex-row lg:space-x-20">
        <!-- Radicales -->
        <div class="lg:max-w-[50%]">
            <h3 class="text-lg font-semibold tracking-tight">Radicales</h3>
            <template v-for="radical of radicales">
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
                                {{ radical.significado }}
                            </p>
                        </HoverCardContent>
                    </HoverCard>
                </Link>
            </template>
        </div>
        <!-- Kanjis similares -->
        <div v-if="similares.length" class="lg:max-w-[50%]">
            <h3 class="text-lg font-semibold tracking-tight">
                Kanjis similares
            </h3>
            <template v-for="similar of similares">
                <Link :href="`/kanjis/${similar.id}`">
                    <HoverCard>
                        <HoverCardTrigger asChild>
                            <Button
                                variant="secondaryGradient"
                                size="gradient"
                                class="m-1"
                            >
                                {{ similar.literal }}
                            </Button>
                        </HoverCardTrigger>
                        <HoverCardContent class="w-fit max-w-48">
                            <p class="capitalize">
                                {{ similar.significado }}
                            </p>
                        </HoverCardContent>
                    </HoverCard>
                </Link>
            </template>
        </div>
    </div>
</template>
