<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { Kanji, Lectura, Significado, Radical } from "@/lib/types";
import Button from "@/Components/ui/button/Button.vue";
import Badge from "@/Components/ui/badge/Badge.vue";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";

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
    <Head :title="kanji.literal" />
    <MainLayout />
    <main class="container mt-6">
        <ItemDetailsCard
            :literal="kanji.literal"
            tipo="kanjis"
            :titulo="significados[0].significado"
        >
            <!-- Datos básicos -->
            <div class="flex flex-col mb-3 sm:space-x-3 sm:flex-row">
                <div>
                    <h3 class="inline mr-1 text-lg">Trazos:</h3>
                    <span class="text-lg font-semibold">{{
                        kanji.trazos
                    }}</span>
                </div>
                <div>
                    <h3 class="inline mr-1 text-lg">Grado:</h3>
                    <span class="text-lg font-semibold">{{ kanji.grado }}</span>
                </div>
                <div v-if="kanji.frecuencia">
                    <h3 class="inline mr-1 text-lg">Frecuencia:</h3>
                    <span class="text-lg font-semibold">{{
                        kanji.frecuencia
                    }}</span
                    ><span> de 2500</span>
                </div>
            </div>
            <!-- Lecturas -->
            <div class="mb-3">
                <h3 class="text-lg font-semibold tracking-tight">Lecturas</h3>
                <div class="flex flex-col flex-wrap lg:flex-row">
                    <div class="mr-6">
                        <h4 class="inline mr-2 tracking-tight">Onyomi:</h4>
                        <Badge
                            variant="secondary"
                            class="m-1 text-base"
                            v-for="lectura of lecturasOnyomi"
                        >
                            {{ lectura.lectura }}
                        </Badge>
                    </div>
                    <div v-if="lecturasKunyomi.length">
                        <h4 class="inline mr-2 tracking-tight">Kunyomi:</h4>
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
            <div class="mb-3">
                <h3 class="text-lg font-semibold tracking-tight">
                    Significados
                </h3>
                <Badge
                    variant="secondary"
                    class="m-1 text-base capitalize"
                    v-for="significado of significados"
                >
                    {{ significado.significado }}
                </Badge>
            </div>
            <div class="flex flex-col lg:flex-row lg:space-x-20">
                <!-- Radicales -->
                <div class="mb-3 lg:max-w-48">
                    <h3 class="text-lg font-semibold tracking-tight">
                        Radicales
                    </h3>
                    <template v-for="radical of radicales">
                        <Link :href="`/radicales/${radical.id}`">
                            <Button class="m-1 text-2xl text-foreground">
                                <p>
                                    {{ radical.literal }}
                                </p>
                            </Button>
                        </Link>
                    </template>
                </div>
                <!-- Kanjis similares -->
                <div v-if="similares.length">
                    <h3 class="text-lg font-semibold tracking-tight">
                        Kanjis similares
                    </h3>
                    <template v-for="similar of similares">
                        <Link :href="`/kanjis/${similar.id}`">
                            <Button class="m-1 text-2xl text-foreground">
                                {{ similar.literal }}
                            </Button>
                        </Link>
                    </template>
                </div>
            </div>
        </ItemDetailsCard>
    </main>
</template>
