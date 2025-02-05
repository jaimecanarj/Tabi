<script setup lang="ts">
import { Skeleton } from "@/Components/ui/skeleton";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb";

defineProps<{ type: string }>();
</script>

<template>
    <div class="mb-4 flex flex-wrap items-center justify-between pl-6">
        <!-- Ruta -->
        <Breadcrumb class="mb-2 mr-2">
            <BreadcrumbList>
                <BreadcrumbItem class="text-xl">
                    <BreadcrumbLink> Inicio </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem class="text-xl capitalize">
                    <BreadcrumbLink> {{ type }} </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <Skeleton class="h-7 w-7" />
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>
        <!-- Botón arriba a la derecha -->
        <Skeleton
            class="h-10 w-[116px]"
            v-if="type === 'kanji' && $page.props.auth.user"
        />
    </div>
    <div
        class="mb-6 flex flex-col space-y-8 rounded-md bg-card p-6 shadow-xl md:mb-0 md:flex-row md:space-x-10 md:space-y-0 lg:space-x-20"
    >
        <!-- Literal -->
        <Skeleton
            class="flex h-[352px] basis-2/5 rounded-lg bg-gradient-primary-to-alt xl:basis-1/3"
        />
        <!-- Información -->
        <div class="basis-3/5 xl:basis-2/3">
            <Skeleton class="mb-3 mt-2 h-16 w-2/5" />
            <Skeleton class="mb-3 h-6 w-3/5" />
            <Skeleton class="mb-3 h-6 w-1/5" />
            <Skeleton class="mb-3 h-6 w-2/5" />
            <Skeleton class="mb-3 h-6 w-1/5" />
            <Skeleton class="mb-3 h-6 w-4/5" />
            <Skeleton class="mb-3 h-6 w-1/5" />
            <div class="mb-3 flex gap-2">
                <Skeleton class="h-12 w-12" v-for="i in 4" />
            </div>
        </div>
    </div>
</template>
