<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Pencil } from "lucide-vue-next";
import Pagination from "@/Components/Pagination.vue";

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
        <div class="flex items-end justify-between pb-5 mb-3 border-b-2">
            <h1 class="text-6xl font-semibold">Radicales</h1>
            <p class="text-lg">{{ total }} radicales</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            <template v-for="radical of data">
                <Link :href="`/radicales/${radical.id}`">
                    <div
                        class="p-4 rounded-md shadow-md bg-card hover:bg-secondary w-72 h-36"
                    >
                        <div class="flex items-center gap-6">
                            <h2 class="text-6xl">
                                {{ radical.literal }}
                            </h2>
                            <p
                                class="text-3xl font-semibold tracking-tight capitalize line-clamp-2 text-ellipsis"
                            >
                                {{ radical.significado }}
                            </p>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <p>
                                <Pencil class="inline" /> {{ radical.trazos }}
                            </p>
                        </div>
                    </div>
                </Link>
            </template>
        </div>
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
