<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { Pencil } from "lucide-vue-next";
import { Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Badge } from "@/Components/ui/badge";

type Pagination = {
    data: Radical[];
    current_page: number;
    per_page: number;
    total: number;
};

const props = defineProps<{ response: Pagination }>();

const { current_page, data, total, per_page } = props.response;

const fetchPage = (page: number) => {
    router.get("/radicales", { page: page.toString() });
};
</script>

<template>
    <Head title="Radicales" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Cabecera -->
        <div class="flex items-end justify-between pb-5 mb-3 border-b-2">
            <h1 class="text-6xl font-semibold">Radicales</h1>
            <p class="text-lg">{{ total }} radicales</p>
        </div>
        <!-- Grid de radicales -->
        <div class="flex flex-wrap justify-center gap-4">
            <template v-for="radical of data">
                <Link :href="`/radicales/${radical.id}`">
                    <div
                        class="flex border rounded-md shadow-md bg-card hover:bg-secondary w-72 h-36"
                    >
                        <div
                            class="flex items-center p-4 rounded-l-md bg-primary"
                        >
                            <h2 class="text-6xl text-primary-foreground">
                                {{ radical.literal }}
                            </h2>
                        </div>
                        <div class="flex flex-col justify-between px-4 py-2">
                            <p
                                class="w-40 text-2xl font-semibold tracking-tight capitalize hyphens-auto line-clamp-2"
                                lang="es"
                            >
                                {{ radical.significado }}
                            </p>
                            <div>
                                <Badge variant="secondary">
                                    <Pencil class="inline" />
                                    {{ radical.trazos }}
                                </Badge>
                            </div>
                        </div>
                    </div>
                </Link>
            </template>
        </div>
        <!-- Paginación -->
        <div class="flex justify-center mt-6">
            <Pagination
                :total="total"
                :current_page="current_page"
                :per_page="per_page"
                @change-page="fetchPage"
            />
        </div>
    </main>
</template>
