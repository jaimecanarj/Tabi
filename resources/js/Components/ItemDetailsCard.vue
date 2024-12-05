<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb/";

defineProps({ literal: String, tipo: String, titulo: String });
</script>

<template>
    <div class="mb-4 flex flex-wrap items-center justify-between pl-6">
        <!-- Ruta -->
        <Breadcrumb class="mb-2 mr-2">
            <BreadcrumbList>
                <BreadcrumbItem class="text-xl">
                    <BreadcrumbLink asChild>
                        <Link href="/inicio"> Inicio </Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem class="text-xl capitalize">
                    <BreadcrumbLink asChild>
                        <Link :href="`/${tipo}`">
                            {{ tipo }}
                        </Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem class="text-xl">
                    <BreadcrumbPage>{{ literal }}</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>
        <!-- Botón arriba a la derecha -->
        <slot name="boton" />
    </div>
    <div
        class="mb-6 flex flex-col space-y-8 rounded-md bg-card p-6 shadow-xl md:mb-0 md:flex-row md:space-x-10 md:space-y-0 lg:space-x-20"
    >
        <!-- Literal -->
        <div
            class="bg-gradient-primary-to-alt flex basis-2/5 items-center justify-center rounded-lg text-[200px] font-bold text-light xl:basis-1/3"
        >
            <h2>{{ literal }}</h2>
        </div>
        <!-- Información -->
        <div class="basis-3/5 xl:basis-2/3">
            <!-- Significado -->
            <h1 class="mb-3 text-6xl font-semibold first-letter:capitalize">
                {{ titulo }}
            </h1>
            <slot />
        </div>
    </div>
</template>
