<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router, Link, Deferred } from "@inertiajs/vue3";
import { Info, PencilLine, Hash } from "lucide-vue-next";
import { Radical, Pagination as PaginationType, Filters } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import RadicalFilters from "@/Components/Radicals/RadicalFilters.vue";
import RadicalGrid from "@/Components/Radicals/RadicalGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";
import RadicalFiltersSkeleton from "@/Components/Radicals/RadicalFiltersSkeleton.vue";
import RadicalGridSkeleton from "@/Components/Radicals/RadicalGridSkeleton.vue";

const props = defineProps<{
    data: {
        response: PaginationType;
        strokes: number[];
    };
    filters: Filters;
}>();

const radicals = computed(
    () => props.data.response.data as (Radical & { kanjisCount: number })[],
);

const page = ref(props.filters.page);

const updatePage = (newPage: number) => {
    page.value = newPage;
    fetchResults({ ...props.filters, page: page.value });
};

const fetchResults = (filters: Filters) => {
    router.get("/radicales", filters, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Radicales" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Cabecera -->
        <div
            class="mb-3 flex flex-wrap items-end justify-between gap-1 text-nowrap border-b-2 pb-5"
        >
            <Link href="/radicales">
                <h1 class="text-5xl font-semibold sm:text-6xl">
                    Radicales <span class="text-xl sm:text-3xl">「部首」</span>
                </h1>
            </Link>
            <Deferred data="data">
                <template #fallback>
                    <p class="text-lg">0 radicales</p>
                </template>
                <p class="text-lg">
                    {{
                        `${data.response.total} radical${data.response.total != 1 ? "es" : ""}`
                    }}
                </p>
            </Deferred>
        </div>
        <Deferred data="data">
            <template #fallback>
                <RadicalFiltersSkeleton />
                <RadicalGridSkeleton />
            </template>
            <!-- Formulario de búsqueda -->
            <RadicalFilters
                :filters="filters"
                :strokes="data.strokes"
                @change="fetchResults"
            />
            <!-- Grid de radicales -->
            <div v-if="!radicals.length" class="ml-2 text-5xl sm:text-6xl">
                No hay resultados.
            </div>
            <div
                class="grid grid-cols-1 justify-items-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6"
            >
                <RadicalGrid :radicals="radicals" />
            </div>
        </Deferred>
    </main>
    <!-- Paginación -->
    <footer
        class="sticky top-[100vh] mb-6 mt-10 flex flex-col items-center gap-3"
    >
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
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3">
                        <PencilLine /> Número de trazos
                    </div>
                    <div class="flex items-center gap-3">
                        <Hash /> Número de kanjis<br />donde se usa
                    </div>
                </div>
            </HoverCardContent>
        </HoverCard>
        <Deferred data="data">
            <template #fallback>
                <Pagination :total="3" :currentPage="0" :perPage="1" disabled />
            </template>
            <Pagination
                :key="page"
                :total="data.response.total"
                :currentPage="data.response.current_page"
                :perPage="data.response.per_page"
                @update:page="updatePage"
            />
        </Deferred>
    </footer>
</template>
