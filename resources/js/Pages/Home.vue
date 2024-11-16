<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Button from "@/Components/ui/button/Button.vue";
import { Badge } from "@/Components/ui/badge";
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container mt-12">
        <section class="flex gap-5">
            <div class="p-5 rounded-md shadow-lg bg-primary w-96">
                <h2 class="mb-3 text-3xl font-semibold text-primary-foreground">
                    Estudiar
                    <Badge variant="secondary" class="text-base">10</Badge>
                </h2>
                <p class="text-primary-foreground">
                    Hoy has estudiado
                    <span class="text-lg font-semibold underline">10</span>
                    kanjis
                </p>
                <Link href="/estudiar">
                    <Button
                        class="w-full mt-2 bg-secondary hover:bg-secondary-foreground/90 text-primary"
                        >Empezar</Button
                    >
                </Link>
            </div>
            <div class="p-5 rounded-md shadow-lg bg-primary-alt w-96">
                <h2 class="mb-3 text-3xl font-semibold text-primary-foreground">
                    Repasar
                    <Badge
                        variant="secondary"
                        class="justify-center text-base min-w-10"
                    >
                        6
                    </Badge>
                </h2>
                <p class="text-primary-foreground">
                    Hoy has repasado
                    <span class="text-lg font-semibold underline">15</span>
                    kanjis
                </p>
                <Link href="/repasar">
                    <Button
                        class="w-full mt-2 bg-secondary hover:bg-secondary-foreground/90 text-primary-alt"
                    >
                        Empezar
                    </Button>
                </Link>
            </div>
        </section>
        <section>Últimos kanjis estudiados 人</section>
        <section>
            Fechas de cuando tienes kanjis para repasar, posible gráfica
        </section>
    </main>
</template>
