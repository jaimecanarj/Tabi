<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb/";
import { Link } from "@inertiajs/vue3";

const props = defineProps({ literal: String, tipo: String, titulo: String });
const { literal, tipo, titulo } = props;
</script>

<template>
    <Breadcrumb class="pl-6 mb-4">
        <BreadcrumbList>
            <BreadcrumbItem class="text-xl">
                <BreadcrumbLink asChild
                    ><Link href="/home"> Inicio </Link></BreadcrumbLink
                >
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
    <div
        class="flex flex-col p-6 space-x-10 space-y-8 rounded-md md:flex-row lg:space-x-20 bg-card"
    >
        <!-- Literal -->
        <div
            class="flex justify-center items-center rounded-lg text-[200px] font-bold bg-gradient-primary basis-2/5 xl:basis-1/3"
        >
            <h2>{{ literal }}</h2>
        </div>
        <!-- Información -->
        <div>
            <!-- Significado -->
            <h1 class="mb-3 text-6xl font-semibold capitalize">
                {{ titulo }}
            </h1>
            <slot />
        </div>
    </div>
</template>
