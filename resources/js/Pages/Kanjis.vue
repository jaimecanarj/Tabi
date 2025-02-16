<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router, Link, Deferred } from "@inertiajs/vue3";
import { Info, Library, PencilLine, TrendingUp } from "lucide-vue-next";
import { Kanji, Pagination as PaginationType, Filters } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import KanjiGrid from "@/Components/Kanjis/KanjiGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import KanjiFilters from "@/Components/Kanjis/KanjiFilters.vue";
import GridSkeleton from "@/Components/Skeletons/GridSkeleton.vue";
import GridFiltersSkeleton from "@/Components/Skeletons/GridFiltersSkeleton.vue";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

const props = defineProps<{
    data?: {
        response: PaginationType;
        strokes: number[];
        grades: number[];
    };
    filters: Filters;
}>();

const kanjis = computed(() => {
    if (props.data) {
        return props.data.response.data as Kanji[];
    } else {
        return [];
    }
});

const page = ref(props.filters.page ?? 1);

const updatePage = (newPage: number) => {
    page.value = newPage;
    fetchResults({ ...props.filters, page: page.value });
};

const fetchResults = (filters: Filters) => {
    router.get("/kanjis", filters, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Kanjis" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Cabecera -->
        <div
            class="mb-3 flex flex-wrap items-end justify-between gap-1 text-nowrap border-b-2 pb-5"
        >
            <Link href="/kanjis">
                <h1 class="text-5xl font-semibold sm:text-6xl">
                    Kanjis <span class="text-xl sm:text-3xl">「漢字」</span>
                </h1>
            </Link>
            <Deferred data="data">
                <template #fallback>
                    <p class="text-lg">0 kanjis</p>
                </template>
                <p class="text-lg">
                    {{
                        `${data!.response.total} kanji${data!.response.total != 1 ? "s" : ""}`
                    }}
                </p>
            </Deferred>
        </div>
        <Deferred data="data">
            <template #fallback>
                <GridFiltersSkeleton type="kanji" />
                <GridSkeleton />
            </template>
            <!-- Formulario de búsqueda -->
            <KanjiFilters
                :filters="filters"
                :strokes="data!.strokes"
                :grades="data!.grades"
                @change="fetchResults"
            />
            <!-- Grid de kanjis -->
            <div v-if="!kanjis.length" class="ml-2 text-5xl sm:text-6xl">
                No hay resultados.
            </div>
            <div
                class="grid grid-cols-1 justify-items-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6"
            >
                <KanjiGrid :kanjis="kanjis" />
            </div>
        </Deferred>
    </main>
    <!-- Footer -->
    <footer
        class="sticky top-[100vh] mb-6 mt-10 flex flex-col items-center gap-3"
    >
        <!-- Información -->
        <HoverCard>
            <HoverCardTrigger>
                <div
                    class="flex cursor-default items-center gap-1 text-muted-foreground"
                >
                    <Info />
                    Información
                </div>
            </HoverCardTrigger>
            <HoverCardContent class="w-fit">
                <div class="flex flex-col gap-2">
                    <div class="flex gap-3">
                        <PencilLine /> Número de trazos
                    </div>
                    <div class="flex gap-3"><Library /> Año escolar</div>
                    <div class="flex gap-3">
                        <TrendingUp /> Frecuencia de uso
                    </div>
                </div>
            </HoverCardContent>
        </HoverCard>
        <!-- Paginación -->
        <Deferred data="data">
            <template #fallback>
                <Pagination
                    :total="(Number(page) ?? 0) + 5"
                    :currentPage="Number(page) ?? 1"
                    :perPage="1"
                    disabled
                />
            </template>
            <Pagination
                :key="page"
                :total="data!.response.total"
                :currentPage="data!.response.current_page"
                :perPage="data!.response.per_page"
                @update:page="updatePage"
            />
        </Deferred>
    </footer>
</template>
